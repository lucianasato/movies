<?php

namespace Sato\MoviesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sato\MoviesBundle\Entity\Contact;
use Sato\MoviesBundle\Form\ContactType;

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

	/**
	 * Creates a new Contact entity.
	 *
	 * @Route("/", name="sato_movies_contact")
	 * @Method({"GET", "POST"})
	 * @Template("SatoMoviesBundle:Default:contact.html.twig")
	 */
	public function contactAction(Request $request)
	{
		$entity = new Contact();
		$form = $this->createForm(new ContactType(), $entity, array(
			'action' => $this->generateUrl('sato_movies_contact'),
			'method' => 'POST',
		));

		$form->handleRequest($request);

		if ($form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($entity);
			$em->flush();

			return $this->redirect($this->generateUrl('sato_movies_contact'));
		}

		return array(
			'entity' => $entity,
			'form'   => $form->createView(),
		);
	}

	public function aboutAction()
	{
		echo "ABOUT" ;
	}
}
