<?php
namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityRepository;
use D4D\AppBundle\Entity\News;
//use D4D\AppBundle\Entity\Faqcategory;
//use D4D\AppBundle\Form\Type\FaqType;

class NewsRepository extends EntityRepository{
    
    public function findAllPagination($obj){  
        
        $em    = $obj->get('doctrine.orm.entity_manager');
        $dql   = "SELECT u FROM D4DAppBundle:News u ORDER BY u.newsitemid DESC";
        $query = $em->createQuery($dql);
        $paginator  = $obj->get('knp_paginator');
        $pagination = $paginator->paginate(
                $query,
                $obj->get('request')->query->get('page', 1),
                30
        );  
        return $pagination;
    }
    
}
?>
