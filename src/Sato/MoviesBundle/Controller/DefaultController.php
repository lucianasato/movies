<?php

namespace Sato\MoviesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
}
