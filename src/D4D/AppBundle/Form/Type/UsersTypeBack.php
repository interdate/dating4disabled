<?php

namespace D4D\AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UsersType extends AbstractType{

	function __construct($user) {
		$this->user = $user;
	}
	
    public function buildForm(FormBuilderInterface $builder, array $options){
    	$builder->add('usernic', 'text', array('label' => 'Username'));
    	
    	/*
    	 $builder->add('userpass', 'repeated', array(
    		'type' => 'password',
    		'first_options'  => array('label' => 'Password'),
    		'second_options' => array('label' => 'Retype Password'),
    	 ));
    	*/
    	
    	$builder->add('userfname', 'text', array('label'  => 'First Name'));
    	$builder->add('userlname', 'text', array('label'  => 'Last Name'));    	
    	$builder->add('useremail', 'text', array('label'  => 'E-mail'));
    	$builder->add('userbirthday', 'date', array(
    		'label' => 'Date Of Birth',
    		'years' => range(date('Y') - 18, date('Y') - 90),
    	));
    	
    	/*
    	$countriesRepo = $this->getEntityManager()->getRepository('D4DAppBundle:LocCountries');
    	$countries = $countriesRepo->findAll();
    		
    	foreach($countries as $country){
    		$countriesList[$country->getCountrycode()] = $country->getCountryname();
    	}
    		
    	$builder->add('countrycode', 'choice', array(
    		'label' => 'Country',
    		'data' => $this->user->getCountrycode(),
    		'choices' => $countriesList,
    	));
    	*/
    	
    	$builder->add('countrycode', 'entity', array(
    		'label' => 'Country',
    		'multiple' => false, //if false then radioboxes will be rendered
    		'expanded' => false, // if false then select tag will be rendered
    		'class' => 'D4DAppBundle:LocCountries',
    		'property' => 'countryname',
    	));
    	
    	//$builder->add('regioncode', 'choice', array('label' => 'Region'));
    	//$builder->add('usercityname', 'choice', array('label' => 'City'));
    	//$builder->add('countryoforigincode', 'choice', array('label' => 'Country of Origin'));
    	
    	$builder->add('usergender', 'choice', array(
    		'label' => 'Gender',
    		'data' => 1,
    		'choices' => array('0' => 'Male', '1' => 'Female'),
    	));
    	
    	//Looking For
    	$builder->add('sexprefid', 'entity', array(
    		'label' => 'Sexual Preference',
    		'multiple' => false, //if false then radioboxes will be rendered
    		'expanded' => false, // if false then select tag will be rendered
    		'class' => 'D4DAppBundle:Sexpref',
    		'property' => 'sexprefname',
    	));
    	
    	
    	$builder->add('zipcode', 'text', array('label' => 'Zip Code'));
    	
    	//BACKGROUND
    	
    	$builder->add('maritalstatusid', 'entity', array(
    		'label' => 'Marital Status',
    		'multiple' => false,
    		'expanded' => false,
    		'class' => 'D4DAppBundle:Maritalstatus',
    		'property' => 'maritalstatusname',
    	));
    	
    	
    	//Children
    	$builder->add('userchildren', 'text', array('label' => 'Children'));
    	
    	
    	//Ethnicity
    	$builder->add('ethnicoriginid', 'entity', array(
    		'label' => 'Ethnicity',
    		'multiple' => false,
    		'expanded' => false,
    		'class' => 'D4DAppBundle:Ethnicorigin',
    		'property' => 'ethnicoriginname',
    	));
    	
    	
    	//Religion
    	$builder->add('religionid', 'entity', array(
    		'label' => 'Religion',
    		'multiple' => false,
    		'expanded' => false,
    		'class' => 'D4DAppBundle:Religion',
    		'property' => 'religionname',
    	));
    	
    	
    	//Education
    	$builder->add('educationid', 'entity', array(
    		'label' => 'Education',
    		'multiple' => false,
    		'expanded' => false,
    		'class' => 'D4DAppBundle:Education',
    		'property' => 'educationname',
    	));
    	
    	
    	//Occupation
    	$builder->add('occupationid', 'entity', array(
    		'label' => 'Occupation',
    		'multiple' => false,
    		'expanded' => false,
    		'class' => 'D4DAppBundle:Occupation',
    		'property' => 'occupationname',
    	));
    	
    	//Income
    	$builder->add('incomeid', 'entity', array(
    		'label' => 'Income',
    		'multiple' => false,
    		'expanded' => false,
    		'class' => 'D4DAppBundle:income',
    		'property' => 'incomename',
    	));
    	
    	
    	//Language
    	$builder->add('languageid', 'entity', array(
    		'label' => 'Language',
    		'multiple' => true, //if false then radioboxes will be rendered
    		'expanded' => true, // if false then select tag will be rendered
    		'class' => 'D4DAppBundle:Language',
    		'property' => 'languagename',
    	));
    	
    	
    	//Appearance
    	$builder->add('appearanceid', 'entity', array(
    		'label' => 'Appearance',
    		'multiple' => false,
    		'expanded' => false,
    		'class' => 'D4DAppBundle:Appearance',
    		'property' => 'appearancename',
    	));
    	
    	//Body type
    	$builder->add('bodytypeid', 'entity', array(
    		'label' => 'Body Type',
    		'multiple' => false,
    		'expanded' => false,
    		'class' => 'D4DAppBundle:Bodytype',
    		'property' => 'bodytypename',
    	));
    	
    	//Height
    	for($i = 54; $i <= 96; $i++){
    		$userHightsList[$i] = (int) ($i / 12) . "' " . ($i % 12) . "\" (" . round($i * 2.54) . " cm)";
    	}
    	
    	$builder->add('userhight', 'choice', array(
    		'label' => 'Hight',
    		'data' => $this->user->getUserhight(),
    		'choices' => $userHightsList,
    	));
    	
    	//Weight
    	for($i = 80; $i <= 400; $i+=2)
    	{
    		$kg = (int) ($i * 0.45359237);
    		$mg = ($i * 0.45359237 - $kg);
    		$mg = ($mg < 0.25) ? 0 : ($mg > 0.75 ? 1 : 0.5);
    		$kg = $kg + $mg;
    		$userWeightsList[$i] = $i . " lbs (" . $kg . " kg)";
    	}
    	
    	$builder->add('userweight', 'choice', array(
    		'label' => 'Weight',
    		'data' => $this->user->getUserweight(),
    		'choices' => $userWeightsList,
    	));
    	
    	
    	//Hair style
    	$builder->add('hairlengthid', 'entity', array(
    		'label' => 'Hair style',
    		'multiple' => false,
    		'expanded' => false,
    		'class' => 'D4DAppBundle:Hairlength',
    		'property' => 'hairlengthname',
    	));
    	
    	
    	//Hair color
    	$builder->add('haircolorid', 'entity', array(
    		'label' => 'Hair color',
    		'multiple' => false,
    		'expanded' => false,
    		'class' => 'D4DAppBundle:Haircolor',
    		'property' => 'haircolorname',
    	));
    	
    	
    	//Eyes color
    	$builder->add('eyescolorid', 'entity', array(
    		'label' => 'Eyes color',
    		'multiple' => false,
    		'expanded' => false,
    		'class' => 'D4DAppBundle:Eyescolor',
    		'property' => 'eyescolorname',
    	));
    	
    	
    	//Smoking
    	$builder->add('smokingid', 'entity', array(
    		'label' => 'Smoking',
    		'multiple' => false,
    		'expanded' => false,
    		'class' => 'D4DAppBundle:Smoking',
    		'property' => 'smokingname',
    	));
    	
    	
    	//Drinking
    	$builder->add('drinkingid', 'entity', array(
    		'label' => 'Drinking',
    		'multiple' => false,
    		'expanded' => false,
    		'class' => 'D4DAppBundle:Drinking',
    		'property' => 'drinkingname',
    	));
    	
    	
    	//Custom Hobbies
    	$builder->add('userhobbies', 'text', array('label' => 'Custom Hobbies'));
    	
    	
    	//About me
    	$builder->add('useraboutme', 'textarea', array('label' => 'About Me'));
    	
    	
    	//Looking For
    	$builder->add('userlookingfor', 'textarea', array('label' => 'Looking For'));
    	
    	
    	//Hobbies
    	$builder->add('hobbyid', 'entity', array(
    		'label' => 'Hobbies',
    		'multiple' => true, //if false then radioboxes will be rendered
    		'expanded' => true, // if false then select tag will be rendered
    		'class' => 'D4DAppBundle:Hobby',
    		'property' => 'hobbyname',
    	));
    	
    	
    	//Characteristics
    	$builder->add('characteristicid', 'entity', array(
    		'label' => 'Characteristics',
    		'multiple' => true, //if false then radioboxes will be rendered
    		'expanded' => true, // if false then select tag will be rendered
    		'class' => 'D4DAppBundle:Characteristic',
    		'property' => 'characteristicname',
    	));
    	
    	
    	//Looking For
    	$builder->add('lookingforid', 'entity', array(
    		'label' => 'Looking For',
    		'multiple' => true, //if false then radioboxes will be rendered
    		'expanded' => true, // if false then select tag will be rendered
    		'class' => 'D4DAppBundle:Lookingfor',
    		'property' => 'lookingforname',
    	));
    	
    	
    	//Life Challenge
    	$builder->add('healthid', 'entity', array(
    		'label' => 'Life Challenge',
    		'multiple' => true, //if false then radioboxes will be rendered
    		'expanded' => true, // if false then select tag will be rendered
    		'class' => 'D4DAppBundle:Health',
    		'property' => 'healthname',
    	));
    	
    	
    	//Mobility
    	$builder->add('mobilityid', 'entity', array(
    		'label' => 'Mobility',
    		'multiple' => true, //if false then radioboxes will be rendered
    		'expanded' => true, // if false then select tag will be rendered
    		'class' => 'D4DAppBundle:Mobility',
    		'property' => 'mobilityname',
    	));
    }
    
    public function getName(){
        return 'users';
    }
}
