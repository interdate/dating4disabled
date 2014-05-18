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

use D4D\AppBundle\Entity\Images;
use D4D\AppBundle\Entity\ImagesRepository;

use D4D\AppBundle\Entity\UsersSearch;

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
    	
    	//print_r( range(date('Y') - 18, date('Y') - 90) );
    	//die();
    	
    	
    	$user = new UsersSearch();
    	$usersRepo = $this->getDoctrine()->getRepository('D4DAppBundle:Users');    	
    	$form = $this->createForm(new SearchType($user, $this->getDoctrine()), $user);
    	
    	$page = 1;
    	$action = $this->get('request')->query->get('action', false);
    	
    	$users['itemsNumber'] = 0;
    	$users['items'] = array(); 
    	$searchData = false;
    	
    	if($request->isMethod('POST')){    		
    		$form->submit($request);    		
    		$post = $request->request->all();    		
    		if($action){
    			$usersRepo->execute($action, $post['usersIds']);
    		}    		    		
    		$searchData = $post['users'];    		
    		$geoip = $this->get('maxmind.geoip');
    		$page = isset($post['page']) ? $post['page'] : 1;
    		$users = $usersRepo->search($searchData, $page, $geoip);    		
    	}
    	
    	return $this->render('D4DAppBundle:Backend/Users:search.twig.html', array(    	
			'form' => $form->createView(),
    		'users' => $users['items'],
    		'usersNumber' => $users['itemsNumber'],	    		
    		'searchData' => $searchData,
    		'pagination' => array(
	    		'page' => $page,
	    		'route' => 'admin_users_search',
	    		'pages_count' => ceil($users['itemsNumber'] / 20),
	    		'route_params' => array(),
    		)	
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
    
    public function photosAction($userId){
    	$isAjax = $this->getRequest()->isXmlHttpRequest();
    	if($isAjax){
    		$photosRepo = $this->getDoctrine()->getRepository('D4DAppBundle:Images');
    		$request = $this->get('request');
    
    		$photos = $photosRepo->findByUserid($userId);
    		//$form = $this->createForm(new UsersType($user, $this->getDoctrine()), $user);
    
    		if ($request->isMethod('POST')) {
    			/*
    			$form->submit($request);
    			$em = $this->getDoctrine()->getManager();
    			$em->persist($user);
    			$em->flush();
    			*/
    		}
    
    		return $this->render('D4DAppBundle:Backend/Users:photos.twig.html', array(
    			//'form' => $form->createView(),
    			//'userId' => $user->getUserid(),
    			'photos' => $photos
    		));
    	}
    }
    
    
    public function photoAction($action, $photoId){
    	$isAjax = $this->getRequest()->isXmlHttpRequest();
    	if($isAjax){
    		$photosRepo = $this->getDoctrine()->getRepository('D4DAppBundle:Images');
    		$photo = $photosRepo->find($photoId);
    		$result = $photosRepo->execute($action, $photo);
    		$this->sendResponse($result);
    		die();
    	}
    }
    
    public function sendResponse($content = false, $cookie = false){
    	$response = new Response();
    	$response->setStatusCode(Response::HTTP_OK);
    	$response->headers->set('Content-Type', 'text/html');
    	 
    	if($content)
    		$response->setContent($content);
    	 
    	if($cookie)
    		$response->headers->setCookie($cookie);
    	 
    	$response->send();
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