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
		$valid = false ;
		$contact = new Contact();
		
		$form = $this->createFormBuilder($contact)
			->add('name', 'text')
			->add('email', 'email')
			->add('message', 'textarea')
			->add('save', 'submit', array('label' => 'Send'))
			->getForm();

		$form->handleRequest($request);

		if ($form->isValid()) {
			// TODO: perform some action, such as saving the contact to the database
			
			$valid = true ;
		}

		return $this->render('SatoMoviesBundle:Default:contact.html.twig', array(
			'form' => $form->createView(),
			'valid' => $valid ,
		));
	}
}
