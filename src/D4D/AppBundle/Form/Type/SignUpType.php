<?php

namespace D4D\AppBundle\Form\Type;

//use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use D4D\AppBundle\Form\Type\UsersType;

class SignUpType extends UsersType{   
    
    private $step1Fields = array('useremail','userpass','usernic','usergender','sexprefid','userbirthday','countrycode','zipcode','countryoforigincode','role');
    
    private $role = 'ROLE_USER';
            
    function __construct($user, $doctrine, $step) {
        parent::__construct($user, $doctrine);
        $this->step = $step;             
    }        

    public function buildForm(FormBuilderInterface $builder, array $options){
        $rolesRepo = $this->doctrine->getRepository('D4DAppBundle:Roles');
        $role = $rolesRepo->findOneByRole($this->role);
        //var_dump($role);die;
        $builder->add('role','entity',array(
            "class" => "D4D\AppBundle\Entity\Roles",
            'property' => 'role',
            'empty_value'  => $role->getId(),
            'label' => false,
            //'attr'  => array('class' => 'hidden')
        ));
        
        if($this->step == 1){
            //foreach ($builder as $field){
            //var_dump($builder->get('children'));die;
            //}
            $builder->add('userNotComlitedRegistration', 'hidden', array('data' => 1));
            $builder->add('useremail', 'repeated', array(
                'type'              => 'text',
                'invalid_message'   => 'The E-mail fields must match.',
                'options'           => array(
                    'attr' => array(
                        'class'     => 'email-field', 
                        'message'   => '<div class="messageForm">Your Email address is kept privet.
                            Please enter a valid email as your Login details will be sent to this email.
                            This is kept private and is not revealed to other members or any third party.
                            <a href="http://google.com" target="_blank">If you wish to know more about our Confidential Details press Here.</a></div>'
                    )
                ),
                'required'          => true,
                'first_options'     => array('label' => 'Email'),
                'second_options'    => array('label' => 'Retype Email'),
            ));

            $builder->add('userpass', 'repeated', array(
                'type'              => 'password',
                'invalid_message'   => 'The password fields must match.',
                'options'           => array('attr' => array('class'     => 'password-field')),
                'required'          => true,
                'first_options'     => array('label' => 'Password'),
                'second_options'    => array('label' => 'Retype Password'),
            ));
            
            $builder->add('usernic', 'text', array('label' => 'Username'));
            
            $builder->add('usergender', 'choice', array(
    		'label' => 'Gender',
    		'data' => 1,
    		'choices' => array('0' => 'Male', '1' => 'Female'),
            ));
            
            $builder->add('sexprefid', 'entity', array(
    		'label' => 'Sexual Preference',
    		'multiple' => false, //if false then radioboxes will be rendered
    		'expanded' => false, // if false then select tag will be rendered
    		'class' => 'D4DAppBundle:Sexpref',
    		'property' => 'sexprefname',
            ));

            $builder->add('userbirthday', 'date', array(
    		'label' => 'Date Of Birth',
    		'years' => range(date('Y') - 18, date('Y') - 90),
            ));
            
            $countriesRepo = $this->doctrine->getRepository('D4DAppBundle:LocCountries');
            $countries = $countriesRepo->findAll();

            foreach($countries as $country){
                    $countriesList[$country->getCountrycode()] = $country->getCountryname();
            }
            $builder->add('countrycode', 'choice', array(
    		'label' => 'Country',
    		'data' => $this->user->getCountrycode(),
    		'choices' => $countriesList,
            ));

            $builder->add('zipcode', 'text', array('label' => 'Zip Code'));
            
            $builder->add('countryoforigincode', 'choice', array(
                'label' => 'Country of Origin',
                'data' => $this->user->getCountryoforigincode(),
    		'choices' => $countriesList,));
            
        }elseif($this->step == 2){
            
            parent::buildForm($builder, $options);
            foreach ($this->step1Fields as $field){
                //$func = 'get' . ucfirst($field);   
                //$builder->add($field, 'hidden', array('data' => $this->user->$func()));
                $builder->remove($field);
            }
//            $builder->add('useremail', 'repeated', array(
//                'type'              => 'text',
//                'invalid_message'   => 'The E-mail fields must match.',
//                'options'           => array('attr' => array('style' => 'display:none')),
//                'required'          => true,
//                'first_options'     => array('label' => ''),
//                'second_options'    => array('label' => ''),
//            ));
//            $builder->add('userpass', 'repeated', array(
//                'type'              => 'password',
//                'invalid_message'   => 'The password fields must match.',
//                'options'           => array('attr' => array('style' => 'display:none')),
//                'required'          => true,
//                'first_options'     => array('label' => ''),
//                'second_options'    => array('label' => ''),
//            ));
        }
    }
    
    public function getName(){
        return 'users';
    }
}
