<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PageController extends Controller
{
    /**
     * @Route("/credits", name="credits_page")
     */
    public function creditsAction(Request $request)
    {
        return $this->render('AppBundle:Page:credits.html.twig', array());
    }

    /**
     * @Route("/mentions", name="mentions_page")
     */
    public function mentionsAction(Request $request)
    {
        return $this->render('AppBundle:Page:mentions.html.twig', array());
    }

}
