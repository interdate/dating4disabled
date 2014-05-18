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
		
		$builder->add('paymentStartDateFrom', 'text', array('label'  => 'Payment Start Date (From)'));
		$builder->add('paymentStartDateTo', 'text', array('label'  => 'Payment Start Date (To)'));
		
		$builder->add('paymentEndDateFrom', 'text', array('label'  => 'Payment End Date (From)'));
		$builder->add('paymentEndDateTo', 'text', array('label'  => 'Payment End Date (To)'));
		
		$builder->add('registrationDateFrom', 'text', array('label'  => 'Registration Date (From)'));
		$builder->add('registrationDateTo', 'text', array('label'  => 'Registration Date (To)'));
		
		$builder->add('lastVisitDateFrom', 'text', array('label'  => 'Last Visit Date (From)'));
		$builder->add('lastVisitDateTo', 'text', array('label'  => 'Last Visit Date (To)'));

		
		
		
		
		$builder->remove('userbirthday');
		$builder->add('userBirthdayFrom', 'text', array('label'  => 'Date Of Birth From'));
		$builder->add('userBirthdayTo', 'text', array('label'  => 'Date Of Birth To'));
		 
		$builder->add('usergender', 'choice', array(
			'label' => 'Gender',
			'data' => '_null',
			'choices' => array('_null' => "Doesn't matter", '0' => 'Male', '1' => 'Female'),
		));
		
		//$array = range(date('Y') - 18, date('Y') - 90);
		
		
		//$array[] = '0000'; 
		
		/*
		print_r($array);
		die();
		*/
		
		
		
		
		/*
		$builder->add('userBirthdayFrom', 'date', array(
    		'label' => 'Date Of Birth From',
    		'years' => $array,
			//'data' => new \DateTime('0000-00-00'),
			'empty_value' => array('year' => 'Year', 'month' => 'Month', 'day' => 'Day'),	
    	));
		
		$builder->add('userBirthdayTo', 'date', array(
			'label' => 'Date Of Birth To',
			'years' => range(date('Y') - 18, date('Y') - 90),				
		));
		*/
		
		
		
		
		
		$choices = array('_null' => "Doesn't matter", '0' => 'No', '1' => 'Yes');
		
		//Not Activated
    	$builder->add('usernotactivated', 'choice', array(
			'label' => 'Not Activated',    		
			'data' => '_null',
			'choices' => $choices,
    	));
    	    	
    	
    	//Not Completed Registration
    	$builder->add('usernotcomlitedregistration', 'choice', array(
			'label' => 'Not Completed Registration',
			'data' => '_null',
			'choices' => $choices,
    	));
    	
    	
    	//Not Approved
		$builder->add('usernotapproved', 'choice', array(
			'label' => 'Not Approved',
			'data' => '_null',
			'choices' => $choices,
		));
		
    	
    	//Blocked
		$builder->add('userblocked', 'choice', array(
			'label' => 'Blocked',
			'data' => '_null',
			'choices' => $choices,
		));
		
		
		//Frozen
		$builder->add('userfrozen', 'choice', array(
			'label' => 'Frozen',
			'data' => '_null',
			'choices' => $choices,
		));
		
		
		//Flagged
		$builder->add('useradminmarked', 'choice', array(
			'label' => 'Flagged',
			'data' => '_null',    
			'choices' => $choices,
		));
		
		//Paying
		$builder->add('userPaying', 'choice', array(
			'label' => 'Paying',
			'data' => '_null',
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
    	
    	
    	$builder->add('countrycode', 'entity', array(
    		'label' => 'Country',
    		'multiple' => false,
    		'expanded' => false,
    		'data'=> $this->doctrine->getManager()->getReference("D4DAppBundle:LocCountries",'--'),
    		//'data'=> '--',
    		'class' => 'D4DAppBundle:LocCountries',
    		'property' => 'countryname',
    	));
    	
    	
    	
    	/*
    	
    	$builder->add('countrycode', 'choice', array(
    		'label' => 'Country',
    		'data' => 'US',
    		'choices' => $countriesList,
    	));
    	*/
    	
    	
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
