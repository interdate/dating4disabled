<?php

namespace D4D\AppBundle\Controller\Frontend;

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
use D4D\AppBundle\Form\Type\SignUpType;



class UserController extends Controller{        
	    
    public function signUpAction(){
        $doctrine = $this->getDoctrine();
        $request = $this->get('request');
        
        $step = ($request->isMethod('POST')) ? $request->get('step') : 1;         
        $user = new Users();

        $form = $this->createForm(new SignUpType($user, $doctrine, $step), $user);
        
        if($request->isMethod('POST')){
            $form->submit($request);
            if($form->isValid()){
                if($step == 1){
                    $factory = $this->get('security.encoder_factory');
                    $encoder = $factory->getEncoder($user);
                    $pass = $user->getUserpass();
                    $password = $encoder->encodePassword($user->getUserpass(), $user->getSalt());
                    $user->setUserpass($password);
                    $user->setUserip($request->getClientIp());
                   
                    $em = $doctrine->getManager();
                    $em->persist($user);
                    $em->flush();
                    
                    //$user = $doctrine->getRepository('D4DAppBundle:Users')->findOneByUsernic('pavel1');
                    $this->sendAction($user, $pass, array('welcome','activation'));
                    $step = $step+1;
                    $form = $this->createForm(new SignUpType($user, $doctrine, $step), $user);
                    
                }
                elseif($step == 2){
                    var_dump($user);die;
                }        
            
            }
        }
    	
    	return $this->render('D4DAppBundle:Frontend/Common:signUp.twig.html', array(
    		'form' => $form->createView(),
                'step' => $step
    	));
    	
    }

    public function checkAction(){
        $isAjax = $this->getRequest()->isXmlHttpRequest();
    	if($isAjax){
            $usersRepo = $this->getDoctrine()->getRepository('D4DAppBundle:Users');
            $field = $this->get('request')->get('field');
            $value = $this->get('request')->get('value');
            $function = 'findBy' . $field;
            $user = $usersRepo->$function($value);
            return $this->render('D4DAppBundle:Frontend/User:check.twig.html', array(
                'nick'  => $user ? 1 : 0,
                'class' => $field
            ));
    	}
    }
    
    public function sendAction($user, $pass = '', $templates = array()){        
        $templatesRepo = $this->getDoctrine()->getRepository('D4DAppBundle:LangDyncpages');
        $code = md5($user->getUseremail() . $user->getUsernic() . $user->getUserId());        
        $hostName = $this->getRequest()->getHost();
        
        foreach($templates as $name){
            $template = $templatesRepo->findOneByPagename($name);
            $body = str_replace(array('{userPass}','{HTTP_HOST}','{CODE}','{EMAIL}','{fromNic}','{fromAge}','{fromRegions}','{pic}'), 
                    array($pass,$hostName,$code,$user->getUseremail(),$user->getUsernic(),'','',''), $template->getPagebody());

            $message = \Swift_Message::newInstance()
                ->setSubject($template->getPagetitle() . ' ' . $hostName)
                ->setFrom($template->getPagename() . '@' . $hostName)
                ->setTo($user->getUseremail())
                ->setBody($body);
            $this->get('mailer')->send($message);		        
        }
    }
    
    public function advancedSearchAction(){
    	$user = new UsersSearch();
    	$usersRepo = $this->getDoctrine()->getRepository('D4DAppBundle:Users');    	
    	$form = $this->createForm(new SearchType($user, $this->getDoctrine()), $user);
    	$request = $this->get('request');
    	
    	$action = $request->query->get('action', false);
    	$page = $request->query->get('page', 1);
    	
    	$users['itemsNumber'] = 0;
    	$users['items'] = array();
    	$searchData = false;
    	
    	$post = $request->request->all();
    	$get = $request->query->all();
    	
    	if(isset($post['users']) or isset($get['users'])){
    		$form->submit($request);
    		$searchData = isset($post['users']) ? $post['users'] : $get['users'];
    		$geoip = $this->get('maxmind.geoip');
    		$page = isset($post['page']) ? $post['page'] : $page;
    		$users = $usersRepo->search($searchData, $page, $geoip);
    	}
    	
    	return $this->render('D4DAppBundle:Frontend/User:advancedSearch.twig.html', array(
    		//'pageIcon' => "users basic",
    		//'pageTitle' => "Search Results",
    		
    		'form' => $form->createView(),
    		'users' => $users,
    		'page' => $page,
    		'searchData' => $searchData,
    		'pagination' => array(
    			'page' => $page,
    			'route' => 'user_search_advanced',
    			'pages_count' => ceil($users['itemsNumber'] / 20),
    			'route_params' => array(),
    		)
    		
    	));
    	
    }

}