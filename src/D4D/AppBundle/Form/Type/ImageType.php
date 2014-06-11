<?php

namespace D4D\AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
//use Symfony\Component\Form\FormEvents;

use Symfony\Component\Security\Core\SecurityContext;
use Doctrine\ORM\FaqRepository;
use Symfony\Component\Validator\Constraints;

class ImageType extends AbstractType{                  

    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder->add('file','file', array(
            'label' => ' ',
            'data' => '',
            'constraints' => array(
               new Constraints\File(array(
                   'maxSize' => '512k',
                   'mimeTypes' => array('image/jpeg', 'image/jpg', 'image/gif', 'application/x-shockwave-flash'),
                   'mimeTypesMessage' => 'Please upload a valid file (gif, jpg, swf)'
               ))
           )
        ));
    }
    
    public function getName(){
        return 'image';
    }
}
