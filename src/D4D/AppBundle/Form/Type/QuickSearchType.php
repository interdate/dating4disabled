<?php

namespace D4D\AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class QuickSearchType extends SearchType{

	function __construct($user, $doctrine) {
		parent::__construct($user, $doctrine);
	}	
	
	public function buildForm(FormBuilderInterface $builder, array $options){		
		parent::buildForm($builder, $options);		
	}
	
}
