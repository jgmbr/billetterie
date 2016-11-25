<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Booking;
use AppBundle\Entity\Ticket;
use AppBundle\Form\BookingType;
use AppBundle\Form\InformationType;

class BookingController extends Controller
{
	protected function getAge($birthDay)
	{
		$serviceAge = $this->get('app_louvre.ticket.age');
		
		return $serviceAge->getAge($birthDay);
	}

    protected function getPrice($age, $conditions)
	{
		if ($age < 0 || !is_int($age))
			return false; 
			
		$servicePrice = $this->get('app_louvre.ticket.price');
		
		return $servicePrice->getPrice($age, $conditions);
	}

    protected function getCodeBooking()
	{
		$servicecodeBooking = $this->get('app_louvre.booking.code');
		
		return $servicecodeBooking->generateCode();
	}

    protected function getCurrency($request)
    {
        if ($request->getLocale()=="fr")
            return "eur";
        return "usd";
    }

    protected function setNewMailer($datas)
    {
        if (!$datas)
            return false;

        $serviceNotificationMailer = $this->get('app_louvre.mailer');

        return $serviceNotificationMailer->sendEmail($datas);
    }

    protected function setTotalPrices($currentBooking)
    {
        if (!$currentBooking)
            return false;

        $servicePrices = $this->get('app_louvre.booking.prices');

        return $servicePrices->setTotalPrices($currentBooking);
    }

    /**
     * @Route("/checkout", name="checkout_page")
     */
    public function checkoutAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $codeBooking = $this->getCodeBooking();

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

        return $this->render('AppBundle:Booking:checkout.html.twig', array(
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

        for($i = 0 ; $i < $nbTickets ;  $i++) {
            $ticket = new Ticket();
            $currentBooking->addTicket($ticket);
        }

        $form = $this->get('form.factory')->create(InformationType::class, $currentBooking, array(
            'current_locale' => $request->getLocale()
        ));

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $currentBooking = $this->setTotalPrices($currentBooking);
            $entityManager->flush();
            return $this->redirectToRoute('summary_page', array(
                'codeBooking' => $currentBooking->getCodeBooking()
            ));
        }

        return $this->render('AppBundle:Booking:informations.html.twig', array(
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

        return $this->render('AppBundle:Booking:summary.html.twig', array(
            'listTickets' => $listTickets,
            'currentBooking' => $currentBooking,
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
            try {
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
            } catch(\Stripe\Error\Card $e) {
                // Since it's a decline, \Stripe\Error\Card will be caught
                $body = $e->getJsonBody();
                $err  = $body['error'];
                $request->getSession()->getFlashBag()->add('success', $err['message']);
                return $this->render('AppBundle:Booking:payment.html.twig', array(
                    'listTickets' => $listTickets,
                    'currentBooking' => $currentBooking,
                    'stripe_public_key' => $this->getParameter('stripe_public_key')
                ));
            } catch (\Stripe\Error\RateLimit $e) {
                // Too many requests made to the API too quickly
                $request->getSession()->getFlashBag()->add('success', 'Echec de la requête');
                return $this->render('AppBundle:Booking:payment.html.twig', array(
                    'listTickets' => $listTickets,
                    'currentBooking' => $currentBooking,
                    'stripe_public_key' => $this->getParameter('stripe_public_key')
                ));
            } catch (\Stripe\Error\InvalidRequest $e) {
                // Invalid parameters were supplied to Stripe's API
                $request->getSession()->getFlashBag()->add('success', 'Requête invalide');
                return $this->render('AppBundle:Booking:payment.html.twig', array(
                    'listTickets' => $listTickets,
                    'currentBooking' => $currentBooking,
                    'stripe_public_key' => $this->getParameter('stripe_public_key')
                ));
            } catch (\Stripe\Error\Authentication $e) {
                // Authentication with Stripe's API failed
                // (maybe you changed API keys recently)
                $request->getSession()->getFlashBag()->add('success', 'Echec d\'authentification');
                return $this->render('AppBundle:Booking:payment.html.twig', array(
                    'listTickets' => $listTickets,
                    'currentBooking' => $currentBooking,
                    'stripe_public_key' => $this->getParameter('stripe_public_key')
                ));
            } catch (\Stripe\Error\ApiConnection $e) {
                // Network communication with Stripe failed
                $request->getSession()->getFlashBag()->add('success', 'Echec de la connexion à l\'API Stripe');
                return $this->render('AppBundle:Booking:payment.html.twig', array(
                    'listTickets' => $listTickets,
                    'currentBooking' => $currentBooking,
                    'stripe_public_key' => $this->getParameter('stripe_public_key')
                ));
            } catch (\Stripe\Error\Base $e) {
                // Display a very generic error to the user, and maybe send
                // yourself an email
                $request->getSession()->getFlashBag()->add('success', 'Une erreur s\'est produite');
                return $this->render('AppBundle:Booking:payment.html.twig', array(
                    'listTickets' => $listTickets,
                    'currentBooking' => $currentBooking,
                    'stripe_public_key' => $this->getParameter('stripe_public_key')
                ));
            } catch (Exception $e) {
                // Something else happened, completely unrelated to Stripe
                $request->getSession()->getFlashBag()->add('success', 'Une erreur s\'est produite');
                return $this->render('AppBundle:Booking:payment.html.twig', array(
                    'listTickets' => $listTickets,
                    'currentBooking' => $currentBooking,
                    'stripe_public_key' => $this->getParameter('stripe_public_key')
                ));
            }
        }

        return $this->render('AppBundle:Booking:payment.html.twig', array(
            'listTickets' => $listTickets,
            'currentBooking' => $currentBooking,
            'stripe_public_key' => $this->getParameter('stripe_public_key')
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
                $this->renderView('AppBundle:Ticket:pdf.html.twig',[
                    'currentBooking' => $currentBooking,
                    'listTickets' => $listTickets
                ]),
                $this->getParameter('path_pdf').$token."-".$currentBooking->getCodeBooking().".pdf"
            );

            $responseMailer = $this->setNewMailer(
                array(
                    'subject'       => 'Musée du Louvre › Confirmation de commande',
                    'from'          => $this->getParameter('from_mailer'),
                    'to'            => $currentBooking->getEmail(),
                    'template'      => 'AppBundle:Ticket:sendtickets.html.twig',
                    'content'       => array('codeBooking' => $currentBooking->getCodeBooking(),'listTickets' => $listTickets,'currentBooking' => $currentBooking),
                    'image'         => '../web/img/louvre.png',
                    'attachment'    => $this->getParameter('path_pdf').$token.'-'.$currentBooking->getCodeBooking().'.pdf'
                )
            );

            if ($responseMailer) {
                $currentBooking->setState(true);
                $entityManager->persist($currentBooking);
                $entityManager->flush();
            }

        }

        return $this->render('AppBundle:Booking:confirmation.html.twig', array(
            'currentBooking' => $currentBooking,
            'listTickets' => $listTickets
        ));
    }

}
