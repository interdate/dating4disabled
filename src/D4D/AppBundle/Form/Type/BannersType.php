<?php
namespace D4D\AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
#use Symfony\Component\Form\FormEvents;

use Symfony\Component\Security\Core\SecurityContext;
use Doctrine\ORM\FaqRepository;


class BannersType extends AbstractType{
    
    /**
     * Builds the AddUser form
     * @param  \Symfony\Component\Form\FormBuilder $builder
     * @param  array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options){  
        
    	$builder->add('bannername', 'text', array('label' => 'Name'));
        $builder->add('bannerlink', 'text', array('label' => 'Link'));
        $builder->add('bannerlocation', 'choice', array(
            'label' => 'Location', 'choices' => array(0 => 'Left', 1 => 'Center', 2 => 'Right'), 
            'empty_value' => 0, 'required' => false
        ));
        $builder->add('banneractive', 'checkbox', array('label' => 'Active', 'required'  => false));
        $builder->add('bannerwidth', 'integer', array('label' => 'Width'));
        $builder->add('bannerheight', 'integer', array('label' => 'Height'));
        $builder->add('bannerfileext', 'file', array('label' => 'File','data' => ''));    
    }
       
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            //'attr' => array('novalidate' => 'novalidate')
        ));
    }
    
    /**
     * Mandatory in Symfony2
     * Gets the unique name of this form.
     * @return string
     */
    public function getName(){
        return 'banner';
    }
}
?>
