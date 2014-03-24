<?php

namespace D4D\AppBundle\Controller\Backend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use D4D\AppBundle\Entity\Users;


class UsersController extends Controller{
    
    public function statisticsAction(Request $request, $value = false){

    	if(!$value)
    		$value = 'total';
    	
    	    	
    	switch ($value){
    		case 'total':
    			
    			$em    = $this->get('doctrine.orm.entity_manager');
    			$dql   = "SELECT u FROM D4DAppBundle:Users u";
    			$query = $em->createQuery($dql);
    			
    			$paginator  = $this->get('knp_paginator');
    			$pagination = $paginator->paginate(
    				$query,
    				$this->get('request')->query->get('page', 1)/*page number*/,
    				50/*limit per page*/
    			);
    			
    			
    			
    			// parameters to template
    			return $this->render('D4DAppBundle:Backend/Users:statistics.twig.html', array('pagination' => $pagination));
    			
    			
    			
    			break;
    		
    		case 'male':
    			break;
    	}
    	
    	return $this->render('D4DAppBundle:Backend/Users:statistics.twig.html');
    }
}
