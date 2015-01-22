<?php

namespace Sato\MoviesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContactType extends AbstractType
{
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
		 	->add('name', 'text')
			->add('email', 'email')
			->add('message', 'textarea' )
			->add('save', 'submit', array('label' => 'Send'))
		;
	}
	
	/**
	 * @param OptionsResolverInterface $resolver
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'Sato\MoviesBundle\Entity\Contact'
		));
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return 'sato_moviesbundle_contact';
	}
}
