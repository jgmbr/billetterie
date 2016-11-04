<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends Controller
{
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

		return $this->render('AppBundle:Home:index.html.twig', array(
			'listPrices' => $listPrices
		));
    }

}
