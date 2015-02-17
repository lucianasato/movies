<?php

namespace Sato\MoviesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sato\MoviesBundle\Entity\Newsletter;

/**
 * Newsletter controller.
 *
 */
class NewsletterController extends Controller
{
	/**
	 * Lists all Newsletter entities.
	 *
	 */
	public function indexAction( Request $request )
	{
        $em = $this->getDoctrine()->getManager();
        $data = $request->query->all() ;

        if ( $request->getMethod() == 'GET' && ! empty( $data['email'] ) ) {
            $entities = $em->getRepository('SatoMoviesBundle:Newsletter')->search( $data ) ;
        }
        else {
            $entities = $em->getRepository('SatoMoviesBundle:Newsletter')->findBy( array(), array( 'createdAt'=> 'desc' ) );
        }

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate( $entities, $request->query->get('page', 1) , 5 );

		return $this->render('SatoMoviesBundle:Newsletter:index.html.twig', array(
			'entities' => $pagination,
		));
	}

	/**
	 * Finds and displays a Newsletter entity.
	 *
	 */
	public function showAction($id)
	{
		$em = $this->getDoctrine()->getManager();

		$entity = $em->getRepository('SatoMoviesBundle:Newsletter')->find($id);

		if (!$entity) {
			throw $this->createNotFoundException('Unable to find Newsletter entity.');
		}

		return $this->render('SatoMoviesBundle:Newsletter:show.html.twig', array(
			'entity'      => $entity,
		));
	}

	public function saveAction(Request $request)
	{
		// Requisições Ajax
		if ( ! $request->isXmlHttpRequest() ) {
    		return new Response( json_encode( array( 'error' => 'Problemas ao cadastrar o e-mail' ) ) ) ;
		}

		$entity = new Newsletter();
		$request = $this->container->get('request');
		$email = $request->request->get('email');

		if ( empty( $email ) ) {
			$json = json_encode( array( 'error' => 'email' ) ) ;
			$response = new Response( $json ) ;
			$response->headers->set( 'Content-type' , 'application/json' ) ;
			return $response ;
		}

		$em = $this->getDoctrine()->getManager();
		$entity->setEmail( $email );
		$entity->setCreatedAt( date("Y-m-d H:i:s") );
		
		$em->persist( $entity ) ;
		$em->flush();

		$json = json_encode( array( 'success' => 'E-mail salvo com sucesso.' ) ) ;
		$response = new Response( $json ) ;
		$response->headers->set( 'Content-type' , 'application/json' ) ;
		return $response ;
	}
}
