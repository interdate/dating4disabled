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
use D4D\AppBundle\Form\Type\UsersType;
use D4D\AppBundle\Form\Type\SearchType;


class UsersController extends Controller{
	    
    public function statisticsAction(Request $request, $filter){
    	$page = $this->get('request')->query->get('page', 1);    	
    	$action = $this->get('request')->query->get('action', false);    	
    	$paginator  = $this->get('knp_paginator');
    	
    	$usersRepo = $this->getDoctrine()->getRepository('D4DAppBundle:Users');
    	$usersRepo->setFilter($filter);
    	
    	$post = $request->request->all();
    	if($post){
    		$usersRepo->execute($action, $post['usersIds']);
    	}
    	
    	$geoip = $this->get('maxmind.geoip');     	
    	$users = $usersRepo->getUsers($paginator, $page, $geoip);    	
    	//$statistics = $usersRepo->getStatistics();
    	    	
    	return $this->render('D4DAppBundle:Backend/Users:statistics.twig.html', array(
    		'users' => $users, 
    		//'statistics' => $statistics,
    		'page' => $page,			
    	));
    }
    
    public function searchAction(Request $request){
    	$user = new Users();
    	$usersRepo = $this->getDoctrine()->getRepository('D4DAppBundle:Users');    	
    	$form = $this->createForm(new SearchType($user, $this->getDoctrine()), $user);
    	
    	if($request->isMethod('POST')){
    		$post = $request->request->all();
    		$data = $post['users'];
    		//$users = $usersRepo->search($data);
    	}
    	
    	return $this->render('D4DAppBundle:Backend/Users:search.twig.html', array(    	
			'form' => $form->createView(),
    		//'users' => $users,    		
    	));
    }
    
    public function profileAction($userId){
    	$isAjax = $this->getRequest()->isXmlHttpRequest();
    	if($isAjax){    		
    		$usersRepo = $this->getDoctrine()->getRepository('D4DAppBundle:Users');
    		$request = $this->get('request');
    		
    		$user = $usersRepo->find($userId);
    		$form = $this->createForm(new UsersType($user, $this->getDoctrine()), $user);
    		
    		if ($request->isMethod('POST')) {
    			$form->submit($request);    			
    			$em = $this->getDoctrine()->getManager();
    			$em->persist($user);
    			$em->flush();
    		}
    		
    		return $this->render('D4DAppBundle:Backend/Users:profile.twig.html', array(    			
    			'form' => $form->createView(),
    			'userId' => $user->getUserid(),	    			
    		));    		
    	}
    }    
}






/*
 $conn = $this->getDoctrine()->getConnection();
$sql = "SELECT TOP 15 * FROM users";
$stmt = $conn->prepare($sql);
$stmt->execute();
$res = $stmt->fetchAll();
echo count($res) . "<br><br>";
foreach ($res as $user){
var_dump($user);
echo "<br /><br />";
}
die();
*/