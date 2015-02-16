<?php
// src/Sato/MoviesBundle/Exporter/Exporter.php

namespace Sato\MoviesBundle\Exporter;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Templating\EngineInterface;


class Exporter
{
	private $templating;

	public function __construct(EngineInterface $templating)
    {
        $this->templating = $templating;
    }

	public function export( $data , $template )
	{

		$filename = sprintf( "export_%s_%s.csv" , $template , date("Y_m_d_His") ) ; 
		$template = sprintf( 'SatoMoviesBundle:Exporter:%s.html.twig' , strtolower( $template ) ) ;

		$response = $this->templating->render($template, array('data' => $data ) );
		
		return new Response($response, 200, array(
	        'Content-Type' => 'text/csv',
	        'Content-Description' => 'Submissions Export' ,
	        'Content-Disposition' =>'attachment; filename=' . $filename ,
	        'Content-Transfer-Encoding' => 'binary' ,
	        'Pragma' => 'no-cache' ,
	        'Expires' => '0'
	        
	    ));
	}
}