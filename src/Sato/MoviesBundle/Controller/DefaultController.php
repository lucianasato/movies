<?php

namespace Sato\MoviesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sato\MoviesBundle\Entity\Contact;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
	public function indexAction()
	{
		$entity_manager = $this->getDoctrine()->getManager();
		$movies = $entity_manager->getRepository('SatoMoviesBundle:Movie')->findAll();
		
		return $this->render('SatoMoviesBundle:Default:index.html.twig', array(
			'movies' => $movies
		));
	}

	public function contactAction(Request $request)
	{
        $contact = new Contact();
        $contact->setName('Luciana');
        $contact->setMessage('Message');

        $form = $this->createFormBuilder($contact)
            ->add('name', 'text')
            ->add('message', 'text')
            ->add('save', 'submit', array('label' => 'Send'))
            ->getForm();

        return $this->render('SatoMoviesBundle:Default:contact.html.twig', array(
            'form' => $form->createView(),
        ));
	}
}
