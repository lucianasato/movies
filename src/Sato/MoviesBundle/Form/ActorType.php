<?php

namespace Sato\MoviesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ActorType extends AbstractType
{
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
		 	->add('name')
			->add('birthdate')
			->add('countryId')
			->add('movies')
		;
	}
	
	/**
	 * @param OptionsResolverInterface $resolver
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'Sato\MoviesBundle\Entity\Actor'
		));
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return 'sato_moviesbundle_actor';
	}
}
