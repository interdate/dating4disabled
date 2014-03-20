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


class SecurityController extends Controller{
	
	public function userLoginAction(Request $request){	
    	$result = $this->auth($request);
        return $this->render('D4DAppBundle:Frontend/Common:login.twig.html', $result);      
    }  
    
    
    public function adminLoginAction(Request $request){
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
    	return $this->render('D4DAppBundle:Frontend:home.twig.html');
    }
    
    
}
