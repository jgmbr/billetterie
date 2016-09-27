<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Contact;
use AppBundle\Form\ContactType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use AppBundle\Entity\Booking;
use AppBundle\Entity\Ticket;
use AppBundle\Form\BookingType;
use AppBundle\Form\InformationType;

class DefaultController extends Controller
{
	public function getAge($birthDay)
	{
		$serviceAge = $this->get('app_louvre.ticket.age');
		
		return $serviceAge->getAge($birthDay);
	}

	public function getPrice($age, $conditions)
	{
		if( $age < 0 || !is_int($age))
			return false; 
			
		$servicePrice = $this->get('app_louvre.ticket.price');
		
		return $servicePrice->getPrice($age, $conditions);
	}
	
	public function getcodeBooking()
	{
		$servicecodeBooking = $this->get('app_louvre.booking.code');
		
		return $servicecodeBooking->generateCode();
	}
	
	public function getBookingToken()
	{
		$serviceBookingToken = $this->get('app_louvre.booking.token');
		
		return $serviceBookingToken->generateToken();
	}

	public function getCurrency($request)
    {
        if($request->getLocale()=="fr")
            return "eur";
        return "usd";
    }
	
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    { 
		$listPrices = $this->getDoctrine()
		  ->getManager()
		  ->getRepository('AppBundle:Price')
		  ->findAll()
		;
		
		return $this->render('AppBundle:Default:index.html.twig', array(
			'listPrices' => $listPrices
		));
    }

    /**
     * @Route("/credits", name="credits_page")
     */
    public function creditsAction(Request $request)
    {
        return $this->render('AppBundle:Default:credits.html.twig', array(
        ));
    }

    /**
     * @Route("/mentions", name="mentions_page")
     */
    public function mentionsAction(Request $request)
    {
        return $this->render('AppBundle:Default:mentions.html.twig', array(
        ));
    }

    /**
     * @Route("/contact", name="contact_page")
     */
    public function contactAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $contact = new Contact();

        $form = $this->get('form.factory')->create(ContactType::class, $contact, array(
            'current_locale' => $request->getLocale()
        ));

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $entityManager->persist($contact);
            $entityManager->flush();
            $request->getSession()->getFlashBag()->add('success', 'Message envoyé avec succès !');
            return $this->redirectToRoute('contact_page');
        }

        return $this->render('AppBundle:Default:contact.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/payment/{codeBooking}", name="payment_page", requirements={"codeBooking" = "BC\-[a-zA-Z0-9]+"}))
     */
    public function paymentAction(Request $request, Booking $currentBooking)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $listTickets = $entityManager->getRepository('AppBundle:Ticket')->findBy(array('booking' => $currentBooking));

        if ($request->isMethod('POST')) {
            \Stripe\Stripe::setApiKey($this->getParameter('stripe_secret_key'));
            \Stripe\Charge::create(array(
                "amount" => $currentBooking->getTotalPrice() * 100,
                "currency" => $this->getCurrency($request),
                "source" => $request->request->get('stripeToken'),
                "description" => $currentBooking->getCodeBooking()
            ));
            return $this->redirectToRoute('confirmation_page', array(
                'codeBooking' => $currentBooking->getCodeBooking()
            ));
        }

        return $this->render('AppBundle:Default:payment.html.twig', array(
            'listTickets' => $listTickets,
            'currentBooking' => $currentBooking,
            'stripe_public_key' => $this->getParameter('stripe_public_key')
        ));
    }

    /**
     * @Route("/download/{codeBooking}", name="download_page", requirements={"codeBooking" = "BC\-[a-zA-Z0-9]+"}))
     */
	public function downloadAction(Request $request, Booking $currentBooking)
	{ 
		$token = date('Ymdhis');

        $entityManager = $this->getDoctrine()->getManager();

		$listTickets = $entityManager->getRepository('AppBundle:Ticket')->findBy(array('booking' => $currentBooking));
  
		$html = $this->renderView('AppBundle:Default:pdf.html.twig', array(
			'currentBooking' => $currentBooking,
			'listTickets' => $listTickets
		));
		
		return new Response(
			$this->get('knp_snappy.pdf')->getOutputFromHtml($html),
			200,
			array(
				'Content-Type'          => 'application/pdf',
				'Content-Disposition'   => 'attachment; filename="'.$token."-".$currentBooking->getCodeBooking().'.pdf"'
			)
		);
		
	}	
	 
	/**
     * @Route("/sendtickets/{codeBooking}", name="sendtickets_page", requirements={"codeBooking" = "BC\-[a-zA-Z0-9]+"}))
     */
	public function sendticketsAction(Request $request, Booking $currentBooking)
	{
		$token = date('Ymdhis');
		
		$entityManager = $this->getDoctrine()->getManager();
		
		$listTickets = $entityManager->getRepository('AppBundle:Ticket')->findBy(array('booking' => $currentBooking));

		$this->get('knp_snappy.pdf')->generateFromHtml(
			$this->renderView('AppBundle:Default:pdf.html.twig',[
				'currentBooking' => $currentBooking,
				'listTickets' => $listTickets
			]),
            $this->getParameter('path_pdf').$token."-".$currentBooking->getCodeBooking().".pdf"
		); 
		
		$message = \Swift_Message::newInstance()
			->setSubject('Musée du Louvre › billets électroniques')
			->setFrom('example@gmail.com')
			->setTo($currentBooking->getEmail())
			->setBody(
				$this->renderView( 
					'AppBundle:Default:sendtickets.html.twig',
					array('codeBooking' => $currentBooking->getCodeBooking(),'listTickets' => $listTickets,'currentBooking' => $currentBooking)
				),
				'text/html'
			);

		$message->attach(\Swift_Attachment::fromPath($this->getParameter('path_pdf').$token.'-'.$currentBooking->getCodeBooking().'.pdf'));

		if (!$this->get('mailer')->send($message, $failures)) {
			return $this->render('AppBundle:Default:sendtickets_error.html.twig', array(
				'email' => $currentBooking->getEmail()
			));
		} else {
			return $this->render('AppBundle:Default:sendtickets_success.html.twig', array(
				'email' => $currentBooking->getEmail()
			));
		}
        
	}
	
	/**
     * @Route("/pdf/{codeBooking}", name="pdf_page", requirements={"codeBooking" = "BC\-[a-zA-Z0-9]+"}))
     */
	public function pdfAction(Request $request, Booking $currentBooking)
	{
		$entityManager = $this->getDoctrine()->getManager();

		$listTickets = $entityManager->getRepository('AppBundle:Ticket')->findBy(array('booking' => $currentBooking));
		
		return $this->render('AppBundle:Default:pdf.html.twig', array(
			'currentBooking' => $currentBooking,
			'listTickets' => $listTickets
		));   
	}	
	
	/**
     * @Route("/confirmation/{codeBooking}", name="confirmation_page", requirements={"codeBooking" = "BC\-[a-zA-Z0-9]+"}))
     */
	public function confirmationAction(Request $request, Booking $currentBooking)
	{
        $token = date('Ymdhis');

		$entityManager = $this->getDoctrine()->getManager();

		$listTickets = $entityManager->getRepository('AppBundle:Ticket')->findBy(array('booking' => $currentBooking));

        $status = $currentBooking->getState();

        if(!$status) {

            $this->get('knp_snappy.pdf')->generateFromHtml(
                $this->renderView('AppBundle:Default:pdf.html.twig',[
                    'currentBooking' => $currentBooking,
                    'listTickets' => $listTickets
                ]),
                $this->getParameter('path_pdf').$token."-".$currentBooking->getCodeBooking().".pdf"
            );

            $message = \Swift_Message::newInstance()
                ->setSubject('Musée du Louvre › Confirmation de commande')
                ->setFrom('example@gmail.com')
                ->setTo($currentBooking->getEmail())
                ->setBody(
                    $this->renderView(
                        'AppBundle:Default:sendtickets.html.twig',
                        array('codeBooking' => $currentBooking->getCodeBooking(),'listTickets' => $listTickets,'currentBooking' => $currentBooking)
                    ),
                    'text/html'
                );

            $message->embed(\Swift_Image::fromPath('../web/img/louvre.png'));

            $message->attach(\Swift_Attachment::fromPath($this->getParameter('path_pdf').$token.'-'.$currentBooking->getCodeBooking().'.pdf'));

            $this->get('mailer')->send($message);

            if ($this->get('mailer')->send($message)) {
                $currentBooking->setState(true);
                $entityManager->persist($currentBooking);
                $entityManager->flush();
            }

        }
		
		return $this->render('AppBundle:Default:confirmation.html.twig', array(
			'currentBooking' => $currentBooking,
			'listTickets' => $listTickets
		));   
	}
	
    /**
     * @Route("/checkout", name="checkout_page")
     */
	public function checkoutAction(Request $request)
	{  
		$entityManager = $this->getDoctrine()->getManager();
		
		$codeBooking = $this->getcodeBooking();
		
		$booking = new Booking($codeBooking); 
		
		$form = $this->get('form.factory')->create(BookingType::class, $booking, array(
			'current_locale' => $request->getLocale()
		));
		
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
			$entityManager->persist($booking);
			$entityManager->flush();
			return $this->redirectToRoute('informations_page', array(
                'codeBooking' => $codeBooking
            ));
        }

		return $this->render('AppBundle:Default:checkout.html.twig', array(
			'form' => $form->createView(),
		));
	}
	
    /**
     * @Route("/informations/{codeBooking}", name="informations_page", requirements={"codeBooking" = "BC\-[a-zA-Z0-9]+"}))
     */
	public function informationsAction(Request $request, Booking $currentBooking)
	{ 
		$entityManager = $this->getDoctrine()->getManager();

		$nbTickets = (int)$currentBooking->getTotalQuantity();
		
		for($i = 0 ; $i < $nbTickets ;  $i++)
		{
			$ticket = new Ticket();
			$currentBooking->addTicket($ticket);
		} 
	 
		$form = $this->get('form.factory')->create(InformationType::class, $currentBooking, array(
			'current_locale' => $request->getLocale()	
		));
		
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
					  
			$total = 0;   
					    
			foreach($currentBooking->getTickets() as $ticket)
			{  
				$condition = "age";
				if($ticket->getReduction())
					$condition = "reduction";
					
				$objPrice = $this->getPrice($this->getAge($ticket->getBirthday()), $condition);
				
				$total += $objPrice->getPrice();
   
				$ticket->setPrice($objPrice);
				
				$ticket->setBooking($currentBooking);
				   
				$entityManager->persist($ticket); 
			}
			
			$currentBooking->setTotalPrice((float)$total);
			
			$entityManager->flush(); 
			
			return $this->redirectToRoute('summary_page', array(
				'codeBooking' => $currentBooking->getCodeBooking()
			));
        }
		  
		return $this->render('AppBundle:Default:informations.html.twig', array(
			'nbTickets' => $nbTickets, 
			'form' => $form->createView()
		));
	}
	
    /**
     * @Route("/summary/{codeBooking}", name="summary_page", requirements={"codeBooking" = "BC\-[a-zA-Z0-9]+"}))
     */
	public function summaryAction(Request $request, Booking $currentBooking)
	{
		$entityManager = $this->getDoctrine()->getManager();
		
		$listTickets = $entityManager->getRepository('AppBundle:Ticket')->findBy(array('booking' => $currentBooking));
		
		return $this->render('AppBundle:Default:summary.html.twig', array(
			'listTickets' => $listTickets,
			'currentBooking' => $currentBooking,
		));
	}
}
