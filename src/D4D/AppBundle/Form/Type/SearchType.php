<?php

namespace D4D\AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SearchType extends UsersType{

	function __construct($user, $doctrine) {
		parent::__construct($user, $doctrine);
	}
	
	
	public function buildForm(FormBuilderInterface $builder, array $options){		
		parent::buildForm($builder, $options);
		
		$choices = array('null' => "Doesn't matter", '0' => 'No', '1' => 'Yes');
		
		//Not Activated
    	$builder->add('usernotactivated', 'choice', array(
			'label' => 'Not Activated',    		
			'data' => 'null',
			'choices' => $choices,
    	));
    	    	
    	
    	//Not Completed Registration
    	$builder->add('usernotcomlitedregistration', 'choice', array(
			'label' => 'Not Completed Registration',
			'data' => 'null',
			'choices' => $choices,
    	));
    	
    	
    	//Not Approved
		$builder->add('usernotapproved', 'choice', array(
			'label' => 'Not Approved',
			'data' => 'null',
			'choices' => $choices,
		));
		
    	
    	//Blocked
		$builder->add('userblocked', 'choice', array(
			'label' => 'Blocked',
			'data' => 'null',
			'choices' => $choices,
		));
		
		
		//Frozen
		$builder->add('userfrozen', 'choice', array(
			'label' => 'Frozen',
			'data' => 'null',
			'choices' => $choices,
		));
		
		
		//Flagged
		$builder->add('useradminmarked', 'choice', array(
			'label' => 'Flagged',
			'data' => 'null',
			'choices' => $choices,
		));
		
		
		//Sexual Preference
    	$builder->add('sexprefid', 'entity', array(
    		'label' => 'Sexual Preference',
    		'multiple' => true, //if false then radioboxes will be rendered
    		'expanded' => true, // if false then select tag will be rendered
    		'class' => 'D4DAppBundle:Sexpref',
    		'property' => 'sexprefname',
    	));
    	    	
    	
    	//Marital Status
    	$builder->add('maritalstatusid', 'entity', array(
    		'label' => 'Marital Status',
    		'multiple' => true,
    		'expanded' => true,
    		'class' => 'D4DAppBundle:Maritalstatus',
    		'property' => 'maritalstatusname',
    	));
    	
    	//Ethnicity
    	$builder->add('ethnicoriginid', 'entity', array(
    		'label' => 'Ethnicity',
    		'multiple' => true,
    		'expanded' => true,
    		'class' => 'D4DAppBundle:Ethnicorigin',
    		'property' => 'ethnicoriginname',
    	));
    	 
    	 
    	//Religion
    	$builder->add('religionid', 'entity', array(
    		'label' => 'Religion',
    		'multiple' => true,
    		'expanded' => true,
    		'class' => 'D4DAppBundle:Religion',
    		'property' => 'religionname',
    	));
    	 
    	 
    	//Education
    	$builder->add('educationid', 'entity', array(
    		'label' => 'Education',
    		'multiple' => true,
    		'expanded' => true,
    		'class' => 'D4DAppBundle:Education',
    		'property' => 'educationname',
    	));
    	 
    	 
    	//Occupation
    	$builder->add('occupationid', 'entity', array(
    		'label' => 'Occupation',
    		'multiple' => true,
    		'expanded' => true,
    		'class' => 'D4DAppBundle:Occupation',
    		'property' => 'occupationname',
    	));
    	 
    	//Income
    	$builder->add('incomeid', 'entity', array(
    		'label' => 'Income',
    		'multiple' => true,
    		'expanded' => true,
    		'class' => 'D4DAppBundle:income',
    		'property' => 'incomename',
    	));   	 
    	 
    	//Appearance
    	$builder->add('appearanceid', 'entity', array(
    		'label' => 'Appearance',
    		'multiple' => true,
    		'expanded' => true,
    		'class' => 'D4DAppBundle:Appearance',
    		'property' => 'appearancename',
    	));
    	 
    	//Body type
    	$builder->add('bodytypeid', 'entity', array(
    		'label' => 'Body Type',
    		'multiple' => true,
    		'expanded' => true,
    		'class' => 'D4DAppBundle:Bodytype',
    		'property' => 'bodytypename',
    	));
    	
    	//Hair style
    	$builder->add('hairlengthid', 'entity', array(
    		'label' => 'Hair style',
    		'multiple' => true,
    		'expanded' => true,
    		'class' => 'D4DAppBundle:Hairlength',
    		'property' => 'hairlengthname',
    	));
    	 
    	 
    	//Hair color
    	$builder->add('haircolorid', 'entity', array(
    		'label' => 'Hair color',
    		'multiple' => true,
    		'expanded' => true,
    		'class' => 'D4DAppBundle:Haircolor',
    		'property' => 'haircolorname',
    	));
    	 
    	 
    	//Eyes color
    	$builder->add('eyescolorid', 'entity', array(
    		'label' => 'Eyes color',
    		'multiple' => true,
    		'expanded' => true,
    		'class' => 'D4DAppBundle:Eyescolor',
    		'property' => 'eyescolorname',
    	));
    	 
    	 
    	//Smoking
    	$builder->add('smokingid', 'entity', array(
    		'label' => 'Smoking',
    		'multiple' => true,
    		'expanded' => true,
    		'class' => 'D4DAppBundle:Smoking',
    		'property' => 'smokingname',
    	));
    	 
    	 
    	//Drinking
    	$builder->add('drinkingid', 'entity', array(
    		'label' => 'Drinking',
    		'multiple' => true,
    		'expanded' => true,
    		'class' => 'D4DAppBundle:Drinking',
    		'property' => 'drinkingname',
    	));
    	
    	//Life Challenge
    	$builder->add('healthid', 'entity', array(
    		'label' => 'Life Challenge',
    		'multiple' => true, 
    		'expanded' => true, 
    		'class' => 'D4DAppBundle:Health',
    		'property' => 'healthname',
    	));
    	 
    	 
    	//Mobility
    	$builder->add('mobilityid', 'entity', array(
    		'label' => 'Mobility',
    		'multiple' => true, 
    		'expanded' => true, 
    		'class' => 'D4DAppBundle:Mobility',
    		'property' => 'mobilityname',
    	));
		
		
	}
	
}
