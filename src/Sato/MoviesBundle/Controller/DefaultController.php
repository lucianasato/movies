<?php

namespace Sato\MoviesBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sato\MoviesBundle\Entity\Contact;
use Sato\MoviesBundle\Form\ContactType;
use Sato\MoviesBundle\Entity\Newsletter;

class DefaultController extends Controller
{
	/**
	 * Lists Movie entities.
	 *
	 * @Route("/", name="admin_movie")
	 * @Method("GET")
	 * @Template()
	 */
	public function indexAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$sql   = "SELECT a FROM SatoMoviesBundle:Movie a ORDER BY a.id DESC";
		$query = $em->createQuery($sql);

		$paginator  = $this->get('knp_paginator');
		$pagination = $paginator->paginate(
			$query,
			$request->query->get('page', 1),
			5
		);

		return array(
			'movies' => $pagination,
		);
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

			$data = $form->getData();

	       	if ( $this->get('sato_movies.mailer')->sendContactMessage( $data , 'Contact' ) ) {
	       		$request->getSession()->getFlashBag()->add(
					'success',
					'Formulário enviado com sucesso.'
				);
	       	}

			return $this->redirect($this->generateUrl('sato_movies_contact'));
		}

		return array(
			'entity' => $entity,
			'form'   => $form->createView(),
		);
	}

	public function aboutAction()
	{
        echo 'About' ;
	}

    public function showAction( $id )
    {
        $em = $this->getDoctrine()->getManager();
        $movie = $em->getRepository('SatoMoviesBundle:Movie')->find( $id ) ;
        return $this->render(
            'SatoMoviesBundle:Default:movie.html.twig', array(
                'movie' => $movie
        ));
    }
}
