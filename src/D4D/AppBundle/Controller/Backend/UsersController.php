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
use D4D\AppBundle\Entity\UsersRepository;


class UsersController extends Controller{
    
    public function statisticsAction(Request $request, $filter = false){    	
    	$page = $this->get('request')->query->get('page', 1);
    	$paginator  = $this->get('knp_paginator');
    	
    	$usersRepo = $this->getDoctrine()->getRepository('D4DAppBundle:Users');
    	$usersRepo->setFilter($filter);    	
    	//$usersRepo->test();    	
    	
    	$geoip = $this->get('maxmind.geoip');
    	
    	$users = $usersRepo->getUsers($paginator, $page, $geoip);
    	$statistics = $usersRepo->getStatistics();
    	    	
    	return $this->render('D4DAppBundle:Backend/Users:statistics.twig.html', array(
    		'users' => $users, 
    		'statistics' => $statistics,    			
    	));
    }
    
    public function actionsAction(Request $request, $filter = false, $action){
    	$page = $this->get('request')->query->get('page', 1);
    	$paginator  = $this->get('knp_paginator');
    	 
    	$usersRepo = $this->getDoctrine()->getRepository('D4DAppBundle:Users');
    	$usersRepo->setFilter($filter);

    	 
    	$geoip = $this->get('maxmind.geoip');
    	 
    	$users = $usersRepo->getUsers($paginator, $page, $geoip);
    	$statistics = $usersRepo->getStatistics();
    
    	return $this->render('D4DAppBundle:Backend/Users:statistics.twig.html', array(
    			'users' => $users,
    			'statistics' => $statistics,
    	));
    }
}