<?php

namespace Sato\MoviesBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;

class Contact
{
	/**
	 * @Assert\NotBlank()
	 */
	protected $name;

	/**
	 * @Assert\NotBlank()
	 */
	protected $email;

	/**
	 * @Assert\NotBlank()
	 */
	protected $message;

	public function getName()
	{
		return $this->name;
	}

	public function setName($name)
	{
		$this->name = $name;
	}

	public function getEmail()
	{
		return $this->email;
	}

	public function setEmail($email)
	{
		$this->email = $email;
	}

	public function getMessage()
	{
		return $this->message;
	}

	public function setMessage($message)
	{
		$this->message = $message;
	}
}