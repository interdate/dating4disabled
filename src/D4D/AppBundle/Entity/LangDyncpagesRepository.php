<?php
namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityRepository;
use D4D\AppBundle\Entity\LangDyncpages;
use D4D\AppBundle\Entity\Users;
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
    
    public function getConstantsValues($values = array('pass' => '', 'code' => '', 'hostName' => 'dating4disabled.com', 'user' => '')){
        $response = array();
        if($values['user'] == '') $values['user'] = new Users();
        $userBirthday = $values['user']->getUserbirthday();
        $age = ($userBirthday != null) ? date('Y') - $userBirthday->format('Y') : '';
        $templatesCoctants = $this->getConstant('template');
        $regionsRepo = $this->getEntityManager()->getRepository('D4DAppBundle:LocRegions');
        $region = $regionsRepo->findOneByRegioncode($values['user']->getRegioncode());
        $regionName = ($region) ? $region->getRegionname() : '';
        $photosRepo = $this->getEntityManager()->getRepository('D4DAppBundle:Images');
        $photo = $photosRepo->findOneBy(array('userid' => $values['user']->getUserid(), 'imgmain' => '1' ));
        
        foreach ($templatesCoctants as $costant => $description){
                $response['find'][] = $costant;
                if(stripos($costant, 'pass') !== false)
                    $response['values'][] = $values['pass'];
                elseif(stripos($costant, 'host') !== false)
                    $response['values'][] = $values['hostName'];
                elseif(stripos($costant, 'code') !== false)
                    $response['values'][] = $values['code'];
                elseif(stripos($costant, 'email') !== false)
                    $response['values'][] = $values['user']->getUseremail();
                elseif(stripos($costant, 'nic') !== false)
                    $response['values'][] = $values['user']->getUsernic();
                elseif(stripos($costant, 'age') !== false)
                    $response['values'][] = $age;
                elseif(stripos($costant, 'region') !== false)
                    $response['values'][] = $regionName;
                elseif(stripos($costant, 'pic') !== false)
                    $response['values'][] = $photo ? $photo->getWebPath() : '';
                else
                    $response['values'][] = '';
        }
        return $response;
    }
    
    public function getConstant($type){ 
        if ($type == 'page')
            return false;
        elseif ($type == 'template') {
            return array(
                '{USERPASS}'    => 'Member Password as saved in database',
                '{HTTP_HOST}'   => 'Site Address (<span class="baseUrlPath">www.mysite.com</span>)',
                '{CODE}'        => 'Acctivation code',
                '{EMAIL}'       => 'Member E-mail as saved in database',
                '{FROMNICK}'    => 'Member Nickname as saved in database',
                '{FROMAGE}'     => 'Member Age as saved in database',
                '{FROMREGIONS}' => 'Member Region as saved in database',
                '{PIC}'         => 'Member main Picture'
            );
        }
        
    }
    
}
?>
