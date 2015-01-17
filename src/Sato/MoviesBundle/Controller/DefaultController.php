<?php

namespace Sato\MoviesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SatoMoviesBundle:Default:index.html.twig');
    }
}
