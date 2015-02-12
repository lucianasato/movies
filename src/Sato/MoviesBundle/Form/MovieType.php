<?php

namespace Sato\MoviesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MovieType extends AbstractType
{
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('title')
			->add('description')
			->add('country_id')
			->add('distributor_id')
			->add('release_date', 'date' , array(
				'years' => range( date('Y'), date('Y' , strtotime( '-50 years' ) ) ) ,
				'required' => true ,
			))
			->add('actors', null, array('required' => false,
				'multiple' => true,
				'expanded' => true,
				)
			)
			->add('directors', null, array('required' => false,
				'multiple' => true,
				'expanded' => true,
				)
			)
			->add('genres', null, array('required' => false,
				'multiple' => true,
				'expanded' => true,
				)
			);
	}
	
	/**
	 * @param OptionsResolverInterface $resolver
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'Sato\MoviesBundle\Entity\Movie'
		));
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return 'sato_moviesbundle_movie';
	}
}
