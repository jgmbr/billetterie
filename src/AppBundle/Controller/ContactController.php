<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Contact;
use AppBundle\Form\ContactType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends Controller
{
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

        return $this->render('AppBundle:Contact:contact.html.twig', array(
            'form' => $form->createView(),
        ));
    }

}
