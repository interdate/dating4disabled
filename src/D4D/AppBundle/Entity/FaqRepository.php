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
                30
        );
        
        return $pagination;
    }
    
    public function getFormParameters ($id, $router, $page = 1){ 
        
        $parameters = ($page == 1) ? array() : array('page' => $page);
        $backUrl = $router->generate('admin_faq', $parameters);        
        $action = ($id>0) ? 'Edit' : 'Add';            
        $formIcon = ($id>0) ? 'save' : 'add sign';
        $buttonValue = ($id>0) ? 'Save' : 'Add';

        return array(   'action' => $action, 
                        'faqurl' => $backUrl, 
                        'icon' => $formIcon, 
                        'button' => $buttonValue);
    }
    
}
?>
