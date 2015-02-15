<?php
// src/Sato/MoviesBundle/Mailer/Mailer.php

namespace Sato\MoviesBundle\Mailer;

use Symfony\Component\Templating\EngineInterface;

class Mailer
{
	protected $mailer;
	protected $templating;

	public function __construct(\Swift_Mailer $mailer, EngineInterface $templating)
	{
		$this->mailer = $mailer;
		$this->templating = $templating;
	}

	public function sendContactMessage( $contact , $type )
	{

		$template = sprintf( 'SatoMoviesBundle:Mailer:%s.html.twig' , strtolower( $type ) ) ;
		$from = 'no-replay@movies.com' ;
		$to = $contact->getEmail() ;
		$subject = sprintf( '[%s] Formulário de Contato' , $type ) ;
		$body = $this->templating->render( $template, array('name' => $contact->getName() ) ) ;

		return $this->sendMessage( $from , $to , $subject , $body ) ;
	}

	protected function sendMessage( $from , $to , $subject , $body)
	{
		$mail = \Swift_Message::newInstance();

		$mail
			->setFrom($from)
			->setTo($to)
			->setSubject($subject)
			->setBody($body)
			->setContentType('text/html');

		return $this->mailer->send($mail);
	}
}