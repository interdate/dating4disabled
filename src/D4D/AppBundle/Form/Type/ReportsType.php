<?php

namespace D4D\AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ReportsType extends AbstractType{	
	
    public function buildForm(FormBuilderInterface $builder, array $options){
    	
    	$builder->add('savedreportname', 'text', array('label' => 'Name'));
    	$builder->add('ishomepage', 'checkbox', array('label' => 'Flag Report'));
    	
    	
    }
    
    public function getName(){
        return 'reports';
    }
}
