<?php

namespace D4D\AppBundle\Controller\Common;

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
use D4D\AppBundle\Entity\Images;


class SecurityController extends Controller{
	
    public function userLoginAction(Request $request){
        if( is_object($this->getUser()) ){            
            return $this->redirect($this->generateUrl('user_home'));
        }    
        $result = $this->auth($request);
        return $this->render('D4DAppBundle:Frontend/Default:index.twig.html', $result);      
    }  
    
    
    public function adminLoginAction(Request $request){
    	if( is_object($this->getUser()) ){
    		return $this->redirect($this->generateUrl('admin_home'));
    	}
    	$result = $this->auth($request);
    	return $this->render('D4DAppBundle:Backend/Common:login.twig.html', $result);
    }
    
    public function auth($request){
    	$session = $request->getSession();
    	
    	if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
    		$error = $request->attributes->get(
    				SecurityContext::AUTHENTICATION_ERROR
    		);
    	} else {
    		$error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
    		$session->remove(SecurityContext::AUTHENTICATION_ERROR);
    	}
    	
    	return array('last_username' => $session->get(SecurityContext::LAST_USERNAME), 'error' => $error);    	
    }    
    
    public function securedAction(Request $request)
    {
    	$usersRepo = $this->getDoctrine()->getRepository('D4DAppBundle:Users');
    	$photosRepo = $this->getDoctrine()->getRepository('D4DAppBundle:Images');
    	
    	$user = $this->getUser();    	
    	//$userData = $usersRepo->getUserData($userId);

    	$mainPhoto = $photosRepo->findOneBy(array(
    		'userid' => $user->getUserid(),
    		'imgmain' => true,
    	));    	 
    	
    	if(!$mainPhoto instanceof Images){
    		$mainPhoto = new Images();
    		$mainPhoto->setUserid($user);
    	}
    		
    	$this->getUser()->setMainPhoto( $mainPhoto );
    	return $this->render('D4DAppBundle:Frontend/User:home.twig.html'/*, array('userData' => $userData)*/);
    }
    
    
}
