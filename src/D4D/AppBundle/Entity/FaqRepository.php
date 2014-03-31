<?php
namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityRepository;
use D4D\AppBundle\Entity\Faq;
use D4D\AppBundle\Entity\Faqcategory;
use D4D\AppBundle\Form\Type\FaqType;

class FaqRepository extends EntityRepository{
    
    public function findAllPagination($obj){  
        
        $em    = $obj->get('doctrine.orm.entity_manager');
        $dql   = "SELECT u FROM D4DAppBundle:Faq u ORDER BY u.faqid DESC";
        $query = $em->createQuery($dql);

        $paginator  = $obj->get('knp_paginator');
        $pagination = $paginator->paginate(
                $query,
                $obj->get('request')->query->get('page', 1),
                10
        );  
        return $pagination;
    }
    
    public function bildFaqForm ($obj,$id=0){
        
        $doctrine = $obj->getDoctrine();
        $repository = $doctrine->getRepository('D4DAppBundle:Faq');
        $categories = $doctrine->getRepository('D4DAppBundle:Faqcategory')->findAll();
        $cat_options = array();
        foreach ($categories as $cat){$cat_options[$cat->getFaqcategoryid()]=$cat->getFaqcategoryname();}
        $faq = ($id>0)?$repository->find($id):new Faq();        
        $choice_option = array('label' => 'Category','choices' => $cat_options,'mapped'   => false);
        if($id>0)$choice_option['data']=$faq->getFaqcategoryid()->getFaqcategoryid();
        $form = $obj->createForm(new FaqType(), $faq);
        $form->add('faqcategoryid', 'choice', $choice_option);
        return $form;
    }
    
}
?>
