<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Booking;
use AppBundle\Entity\Ticket;

class TicketController extends Controller
{
    /**
     * @Route("/download/{codeBooking}", name="download_page", requirements={"codeBooking" = "BC\-[a-zA-Z0-9]+"}))
     */
	public function downloadAction(Request $request, Booking $currentBooking)
	{ 
		$token = date('Ymdhis');

        $entityManager = $this->getDoctrine()->getManager();

		$listTickets = $entityManager->getRepository('AppBundle:Ticket')->findBy(array('booking' => $currentBooking));
  
		$html = $this->renderView('AppBundle:Ticket:pdf.html.twig', array(
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

}
