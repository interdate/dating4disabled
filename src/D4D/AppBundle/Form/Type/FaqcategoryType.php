<?php
namespace D4D\AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
//use Symfony\Component\Form\FormEvents;

use Symfony\Component\Security\Core\SecurityContext;
//use Doctrine\ORM\FaqRepository;

//use D4D\AppBundle\Entity\Faq;
use D4D\AppBundle\Entity\Faqcategory;
use D4D\AppBundle\Entity\LangLanguages;

class FaqcategoryType extends AbstractType{
    
    /**
     * Builds the AddUser form
     * @param  \Symfony\Component\Form\FormBuilder $builder
     * @param  array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options){  
        
    	$builder->add('faqcategoryname', 'text', array('label' => 'Name of category',
//            'constraints' => array(
//                        new NotBlank(),
//                        new MinLength(4),
//            )
            ));    
       // $builder->add('langid', 'hidden', array('data' => 27,'mapped' => false));
    }
       
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
   //         'data_class' => 'D4D\AppBundle\Entity\Faqcategory'
        ));
    }
    
    /**
     * Mandatory in Symfony2
     * Gets the unique name of this form.
     * @return string
     */
    public function getName(){
        return 'faqcategory';
    }
}
?>
