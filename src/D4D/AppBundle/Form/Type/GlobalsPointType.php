<?php
namespace D4D\AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
#use Symfony\Component\Form\FormEvents;

use Symfony\Component\Security\Core\SecurityContext;
use Doctrine\ORM\FaqRepository;


class GlobalsPointType extends AbstractType{
    
    /**
     * Builds the AddUser form
     * @param  \Symfony\Component\Form\FormBuilder $builder
     * @param  array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options){  
        
    	$builder->add('points', 'integer', array('label' => 'Points'));        
        $builder->add('whereLessThen', 'choice', array(
            'expanded'          => false,
            'multiple'          => false,
            'label'             => 'Members', 
            'choices'           => array(1 => 'With no points', 1000000 => 'All'), 
            'empty_value'       => 1, 
            'required'          => false
        ));            
    }
       
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            //'csrf_protection' => false,
            //'attr' => array('novalidate' => 'novalidate')
        ));
    }
    
    /**
     * Mandatory in Symfony2
     * Gets the unique name of this form.
     * @return string
     */
    public function getName(){
        return 'globalPoint';
    }
}
?>
