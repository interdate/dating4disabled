<?php
namespace D4D\AppBundle\Form\Type;

use D4D\AppBundle\Form\Type\LangDyncpagesType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;

use Symfony\Component\Security\Core\SecurityContext;
use Doctrine\ORM\LangDyncpagesRepository;

class TemplatesType extends LangDyncpagesType{
    
    /**
     * Builds the AddUser form
     * @param  \Symfony\Component\Form\FormBuilder $builder
     * @param  array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options){  
        parent::buildForm($builder, $options);
//    	$builder->add('pagename', 'text', array('label' => 'Name')); 
        $builder->add('pagetitle', 'text', array('label' => 'Subject','required' => false)); 
//        $builder->add('pagebody', 'textarea', array('label' => 'Body','required' => false)); //,'error_bubbling'   => true
        $builder->add('pagetype', 'hidden', array('data' => 'template'));
    }
       
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            //'csrf_protection'   => false,  
            //'attr' => array('novalidate' => 'novalidate'),
        ));        
    }
    
    /**
     * Mandatory in Symfony2
     * Gets the unique name of this form.
     * @return string
     */
    public function getName(){
        return 'templates';
    }
}
?>
