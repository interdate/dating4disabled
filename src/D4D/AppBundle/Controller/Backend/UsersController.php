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
use Symfony\Component\HttpFoundation\File\UploadedFile;

use D4D\AppBundle\Entity\Users;
use D4D\AppBundle\Entity\Images;
use D4D\AppBundle\Entity\UsersSearch;
use D4D\AppBundle\Entity\Adminsavedreports;

use D4D\AppBundle\Form\Type\UsersType;
use D4D\AppBundle\Form\Type\SearchType;



class UsersController extends Controller{
	    
    public function statisticsAction(Request $request, $filter){
    	$page = $this->get('request')->query->get('page', 1);    	
    	$action = $this->get('request')->query->get('action', false);    	
    	$paginator  = $this->get('knp_paginator');
    	
    	$usersRepo = $this->getDoctrine()->getRepository('D4DAppBundle:Users');    	
    	$post = $request->request->all();
    	
    	if($post){
    		$usersRepo->execute($action, $post['usersIds']);
    	}
    	
    	$geoip = $this->get('maxmind.geoip');
    	$usersRepo->setFilter($filter);
    	$users = $usersRepo->getUsers($paginator, $page, $geoip);    	
    	//$statistics = $usersRepo->getStatistics();
    	    	
    	return $this->render('D4DAppBundle:Backend/Users:statistics.twig.html', array(
    		'users' => $users, 
    		//'statistics' => $statistics,
    		'page' => $page,    					
    	));
    }
    
    public function reportsAction(){    	
    	$reportsRepo = $this->getDoctrine()->getRepository('D4DAppBundle:Adminsavedreports');    	
    	$reports = $reportsRepo->findByIshomepage(true);    	
    	return $this->render('D4DAppBundle:Backend/Users:reports.twig.html', array(
    		'reports' => $reports,    		
    	));
    }
    
    public function searchAction(Request $request){    
    	$user = new UsersSearch();
    	$usersRepo = $this->getDoctrine()->getRepository('D4DAppBundle:Users');    	
    	$form = $this->createForm(new SearchType($user, $this->getDoctrine()), $user);
    	
    	//$page = 1;
    	$action = $this->get('request')->query->get('action', false);
    	$page = $this->get('request')->query->get('page', 1);
    	    	
    	$users['itemsNumber'] = 0;
    	$users['items'] = array(); 
    	$searchData = false;
    	
    	$post = $request->request->all();
    	$get = $request->query->all();
    	
    	if(isset($post['users']) or isset($get['users'])){
    		$form->submit($request);
    		
    		if($action){
    			$usersRepo->execute($action, $post['usersIds']);
    		}
    		    		    		
    		$searchData = isset($post['users']) ? $post['users'] : $get['users'];    		
    		$geoip = $this->get('maxmind.geoip');
    		$page = isset($post['page']) ? $post['page'] : $page;
    		$users = $usersRepo->search($searchData, $page, $geoip);
    		
    		/*
    		print_r($searchData);
    		die;
    		*/    		
    	}    	
    	
    	return $this->render('D4DAppBundle:Backend/Users:search.twig.html', array(    	
    		'pageIcon' => "users basic",
    		'pageTitle' => "Search Results",
    		'form' => $form->createView(),
    		'users' => $users,
    		'page' => $page,
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
    
    public function photosAction($userId, $active){    	
    	$photosRepo = $this->getDoctrine()->getRepository('D4DAppBundle:Images');
    	$request = $this->get('request');    
    	$photos = $photosRepo->findBy(
    		array('userid' => $userId),
    		array('imgid' => 'ASC')
    	);
    	
    	$active = ($active == 0) ? $imgId = isset($photos[0]) ? $photos[0]->getImgid() : 0 : $active;
    	
    	return $this->render('D4DAppBundle:Backend/Users:photos.twig.html', array(
    		'photos' => $photos,
    		'active' => $active,    		
    	));    	
    }
    
    
    public function photoAction($action, $photoId){    	
    	$photosRepo = $this->getDoctrine()->getRepository('D4DAppBundle:Images');
    	$photo = $photosRepo->find($photoId);
    	$photosRepo->execute($action, $photo);
    	$active = ($action == 'remove') ? 0 : $photo->getImgid();
    	return $this->redirect($this->generateUrl('admin_users_photos', array( 'userId' => $photo->getUserid()->getUserid(), 'active' => $active )));
    }
    
    public function unapprovedPhotosAction(Request $request){
    	$page = $this->get('request')->query->get('page', 1);
    	$photosRepo = $this->getDoctrine()->getRepository('D4DAppBundle:Images');
    
    	$isAjax = $this->getRequest()->isXmlHttpRequest();
    	if($isAjax){
    		$post = $request->request->all();
    		$photosRepo->approvePhotos($post['unapprovedPhotosIds']);
    		die;
    	}
    	 
    	$photos = $photosRepo->getUnapprovedPhotos();
    	 
    	//$geoip = $this->get('maxmind.geoip');
    	//$statistics = $usersRepo->getStatistics();
    
    	return $this->render('D4DAppBundle:Backend/Users:statistics.twig.html', array(
    			'photos' => $photos,
    			'page' => $page,
    	));
    }
    
    public function ajaxAction(Request $request){
    	$isAjax = $this->getRequest()->isXmlHttpRequest();
    	if($isAjax){
    		//$action = $this->get('request')->query->get('action', false);
    		$usersRepo = $this->getDoctrine()->getRepository('D4DAppBundle:Users');
    		$post = $request->request->all();
    		$usersRepo->execute($action, $post['usersIds']);
    		die;
    	}
    
    	$photos = $photosRepo->getUnapprovedPhotos();
    
    	//$geoip = $this->get('maxmind.geoip');
    	//$statistics = $usersRepo->getStatistics();
    
    	return $this->render('D4DAppBundle:Backend/Users:statistics.twig.html', array(
    		'photos' => $photos,
    		'page' => $page,
    	));
    }
    
    public function blockAndDeleteAction(Request $request){
    	$isAjax = $this->getRequest()->isXmlHttpRequest();
    	if($isAjax){
    		$post = $request->request->all();
    		$usersRepo = $this->getDoctrine()->getRepository('D4DAppBundle:Users');
    		$usersRepo->execute('blockAndDelete', explode(",", $post['usersIds']));
    		die;
    	}
    }

    public function reportAction(Request $request){
    	$post = $request->request->all();
    	/*
    	print_r($post);
    	die;
    	*/
    	
    	$report = new Adminsavedreports();
    	$report->setSavedreportname($post['name']);
    	$report->setSavedreportlink($post['link']);
    	$homepage = isset($post['homepage']) ? $post['homepage'] : false;
    	$report->setIshomepage($homepage);
    	$report->setIsstats($post['stats']);    	
    	
    	$em = $this->getDoctrine()->getManager();
    	$em->persist($report);
    	$em->flush();
    	$this->sendResponse('The report has been created');
    	die;
    }
    
    public function deleteReportAction($id){
    	$reportsRepo = $this->getDoctrine()->getRepository('D4DAppBundle:Adminsavedreports');
    	$report = $reportsRepo->find($id);
    	$report->setIshomepage(false);
    	$em = $this->getDoctrine()->getManager();
    	$em->persist($report);
    	$em->flush();
    	return $this->redirect($this->generateUrl('admin_users_reports'));
    	
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

    public function uploadPhotoAction($userId){
    	 
    	$request = $this->get('request');
    	$files = $request->files;

    	$usersRepo = $this->getDoctrine()->getRepository('D4DAppBundle:Users');
    	$user = $usersRepo->find($userId);
    	
    	$em = $this->getDoctrine()->getManager();
    	 
    	foreach ($files as $uploadedFile){
    		if($uploadedFile instanceof UploadedFile){
    			$image = new Images();
    			$image->setFile($uploadedFile);
    			$image->setUserid($user);
    			$image->setImgMain(true);
    			$image->setImgValidated(true);
    			$image->setHomepage(false);    			
    			$image->setExt($image->getFile()->guessExtension());    			
    			$em->persist($image);
    			$em->persist($user);
    			$em->flush();
    			$image->preUpload();
    			$image->upload();
    		}
    	}
    	
    	$this->sendResponse("success");
    	die;

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
