<?php

namespace Sato\MoviesBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sato\MoviesBundle\Entity\Contact;
use Sato\MoviesBundle\Form\ContactType;

/**
 * Contact controller.
 *
 */
class ContactController extends Controller
{

	/**
	 * Lists all Contact entities.
	 *
	 * @Route("/", name="admin_contact")
	 * @Method("GET")
	 * @Template()
	 */
	public function indexAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();

		$sql   = "SELECT a FROM SatoMoviesBundle:Contact a ORDER BY a.id desc";
		$query = $em->createQuery($sql);

		$paginator  = $this->get('knp_paginator');
		$pagination = $paginator->paginate(
			$query,
			$request->query->get('page', 1),
			5
		);
		return array(
			'entities' => $pagination,
		);
	}

	/**
	 * Finds and displays a Contact entity.
	 *
	 */
	public function showAction($id)
	{
		$em = $this->getDoctrine()->getManager();

		$entity = $em->getRepository('SatoMoviesBundle:Contact')->find($id);

		if (!$entity) {
			throw $this->createNotFoundException('Unable to find Contact entity.');
		}

		return $this->render('SatoMoviesBundle:Contact:show.html.twig', array(
			'entity'      => $entity,
		));
	}
}