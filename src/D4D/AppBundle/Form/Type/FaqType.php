<?php
namespace D4D\AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
#use Symfony\Component\Form\FormEvents;

use Symfony\Component\Security\Core\SecurityContext;
use Doctrine\ORM\FaqRepository;


class FaqType extends AbstractType{
    
    /**
     * Builds the AddUser form
     * @param  \Symfony\Component\Form\FormBuilder $builder
     * @param  array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options){  
        
    	$builder->add('faqq', 'textarea', array('label' => 'Question'));
        $builder->add('faqa', 'textarea', array('label' => 'Answer'));     
    }
       
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
  //          'attr' => array('novalidate' => 'novalidate')
        ));
    }
    
    /**
     * Mandatory in Symfony2
     * Gets the unique name of this form.
     * @return string
     */
    public function getName(){
        return 'faq';
    }
}
?>
