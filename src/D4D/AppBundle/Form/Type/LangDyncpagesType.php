<?php
//namespace D4D\AppBundle\Form\Type;
//
//use Symfony\Component\Form\AbstractType;
//use Symfony\Component\Form\FormBuilderInterface;
//use Symfony\Component\OptionsResolver\OptionsResolverInterface;
//use Symfony\Component\Form\FormEvent;
//use Symfony\Component\Form\FormEvents;
//
//use Symfony\Component\Security\Core\SecurityContext;
//use Doctrine\ORM\LangDyncpagesRepository;
//
//use D4D\AppBundle\Entity\LangDyncpages;
namespace D4D\AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;

use Symfony\Component\Security\Core\SecurityContext;
use Doctrine\ORM\LangDyncpagesRepository;

class LangDyncpagesType extends AbstractType{
    
    /**
     * Builds the AddUser form
     * @param  \Symfony\Component\Form\FormBuilder $builder
     * @param  array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options){  
        
    	$builder->add('pagename', 'text', array('label' => 'Name')); 
        $builder->add('pagetitle', 'text', array('label' => 'Title')); 
        $builder->add('pagebody', 'textarea', array('label' => 'Body','required' => false)); //,'error_bubbling'   => true
        //$builder->add('add', 'submit');
    }
       
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            //'csrf_protection'   => false,  
            //'js_validation' => false,
            //'attr' => array('novalidate' => 'novalidate'),
        ));        
    }
    
    /**
     * Mandatory in Symfony2
     * Gets the unique name of this form.
     * @return string
     */
    public function getName(){
        return 'pages';
    }
}
?>
