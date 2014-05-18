<?php
namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityRepository;
use D4D\AppBundle\Entity\LangDyncpages;
use D4D\AppBundle\Form\Type\LangDyncpagesType;

class LangDyncpagesRepository extends EntityRepository{
    
    public function findAllPagination($obj, $type){ 
        $condition = ($type=='page') ? "u.pagetype='dyncpage'" : "u.pagetype='email' OR u.pagetype='template'";
        $em    = $obj->get('doctrine.orm.entity_manager');
        $dql   = "SELECT u FROM D4DAppBundle:LangDyncpages u WHERE " . $condition . " ORDER BY u.pageid DESC";
        $query = $em->createQuery($dql);
        
        $paginator  = $obj->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $obj->get('request')->query->get('page', 1),
            30
        ); 
        
        return $pagination;
    }
    
    public function getFormParameters($id, $page, $router, $type){
        
        $action = ($id > 0) ? 'Edit' : 'Add';
        $parameters = ($page == 1) ? array() : array('page' => $page);
        $url = ($type == 'page') ? 'admin_pages' : 'admin_templates';
        $backUrl = $router->generate($url,$parameters);
        $formIcon = ($id > 0) ? 'save' : 'add sign';
        $buttonValue = ($id > 0) ? 'Save' : 'Add';
        $params = $this->getIndexParameters($type);        
        $params['constants'] = $this->getConstant($type);
        return $params + array(   'action'    => $action, 
                        'pagesUrl'  => $backUrl, 
                        'icon'      => $formIcon, 
                        'button'    => $buttonValue);
    }
    
    public function getIndexParameters($type){
        $topTitle = ($type == 'page') ? 'Pages' : 'Templates';
        $section = ($type == 'page') ? 'pages' : 'templates';
        $globalIcon = ($type == 'page') ? 'text file' : 'paste';
        //$addButtonTitle = ($type == 'page') ? 'page' : 'template';
        return array('topTitle'         => $topTitle,
                    'addButtonTitle'    => $type,
                    'section'           => $section,
                    'globalIcon'        => $globalIcon);
    }
    
    public function getConstant($type){
        if ($type == 'page')
            return false;
        elseif ($type == 'template') {
            return array(
                '{userPass}'    => 'Member Password as saved in database',
                '{HTTP_HOST}'   => 'Site Address (<span class="baseUrlPath">www.mysite.com</span>)',
                '{CODE}'        => 'Acctivation code',
                '{EMAIL}'       => 'Member E-mail as saved in database',
                '{fromNic}'     => 'Member Nickname as saved in database',
                '{fromAge}'     => 'Member Age as saved in database',
                '{fromRegions}' => 'Member Region as saved in database',
                '{pic}'         => 'Member Picture'
            );
        }
        
    }
    
}
?>
