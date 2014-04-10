<?php
namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityRepository;
use D4D\AppBundle\Entity\Banners;
//use D4D\AppBundle\Entity\Faqcategory;
//use D4D\AppBundle\Form\Type\FaqType;

class BannersRepository extends EntityRepository{
    
    public function findAllPagination($obj){  
        
        $em    = $obj->get('doctrine.orm.entity_manager');
        $dql   = "SELECT u FROM D4DAppBundle:Banners u ORDER BY u.bannerid DESC";
        $query = $em->createQuery($dql);
        $paginator  = $obj->get('knp_paginator');
        $pagination = $paginator->paginate(
                $query,
                $obj->get('request')->query->get('page', 1),
                30
        ); 
        foreach($pagination as $i => $banner){
            if($banner->getBannerlocation()==0)		
               $pagination[$i]->location = "Left";
            elseif($banner->getBannerlocation()==1)
                $pagination[$i]->location = "Center";
            elseif($banner->getBannerlocation()==2)		
                $pagination[$i]->location = "Right";
            $pagination[$i]->activeClass = (($banner->getBanneractive()=='1') ? 'green checkmark' : 'red cancel circle basic');  
            $pagination[$i]->image = $this->getBannersPath() . $banner->getBannerid() . '.' . $banner->getBannerfileext();
        }
        return $pagination;
    }
    
    public function getOptionsForm($id){
        $action = ($id > 0) ? 'Edit' : 'Add';
        $formIcon = ($id > 0) ? 'save' : 'add sign';
        $buttonValue = ($id > 0) ? 'Save' : 'Add';
        $banner = $this->find($id);
        if($id > 0) {
            $image = $banner;
            $image->src = $this->getBannersPath() . $banner->getBannerid() . '.' . $banner->getBannerfileext();
            $image->ext = $banner->getBannerfileext();
            $image->width = $banner->getBannerwidth();
            $image->height = $banner->getBannerheight();
        } else $image = false;
        $checkbox = ($id > 0 && $banner->getBanneractive()==1) ? 'enable' : 'disable';
        return array(   'action'    => $action,                         
                        'icon'      => $formIcon, 
                        'button'    => $buttonValue,
                        'image'     => $image,
                        'checkbox'  => $checkbox);
    }
    
    public function getBannersPath($root = false){
        if(!$root)$root = 'http://' . $_SERVER['HTTP_HOST'];
        return $root . '/uploads/banners/';
    }
    
}
?>
