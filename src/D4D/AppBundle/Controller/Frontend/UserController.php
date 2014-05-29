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
        $user = ($step == 1) ? new Users() : $doctrine->getRepository('D4DAppBundle:Users')->find($request->get('userId'));

        $form = $this->createForm(new SignUpType($user, $doctrine, $step), $user);
        
        if($request->isMethod('POST')){
            $form->submit($request);
            if($form->isValid()){
                $em = $doctrine->getManager();
                if($step == 1){
                    $factory = $this->get('security.encoder_factory');
                    $encoder = $factory->getEncoder($user);
                    $pass = $user->getUserpass();
                    $password = $encoder->encodePassword($user->getUserpass(), $user->getSalt());
                    $user->setUserpass($password);
                    $user->setUserip($request->getClientIp());
                   
                    $em->persist($user);
                    $em->flush();
                    
//                    $user = $doctrine->getRepository('D4DAppBundle:Users')->findOneByUsernic('pavel1');
                    $this->sendMailAction($user, $pass, array('welcome','activation'));
                    $step = $step+1;
                    $form = $this->createForm(new SignUpType($user, $doctrine, $step), $user);
                    
                }
                elseif($step == 2){
                    $em->persist($user);
                    $em->flush();
                    //$this->redirect($this->generateUrl('homepage'));
                    $form = false;
                }        
            
            }
        }
    	
    	return $this->render('D4DAppBundle:Frontend/User:signUp.twig.html', array(
    		'form' => $form ? $form->createView() : $form,
                'step' => $step,
                'userId' => $user->getUserid()
    	));    	
    }
    
    public function loadRegionsAction(){
        $isAjax = $this->getRequest()->isXmlHttpRequest();
        if($isAjax){
            $countrycode = $this->get('request')->get('countrycode');
            $value = $this->get('request')->get('value');
            $doctrine = $this->getDoctrine();
            $res = array('cities' => false, 'regions' => false);
            if($countrycode != 'false'){
                $citiesRepo = $doctrine->getRepository('D4DAppBundle:LocCities'); 
                $res['cities'] = $citiesRepo->findBy(array('countrycode' => $countrycode, 'regioncode' => $value));
            }else{
                $regionsRepo = $doctrine->getRepository('D4DAppBundle:LocRegions');
                $res['regions'] = $regionsRepo->findByCountrycode($value);
            }
            $user = new Users();
            $form = $this->createForm(new SignUpType($user, $doctrine, $res), $user);           
            return $this->render('D4DAppBundle:Frontend/User:loadRegions.twig.html', array(
                'form' => $form->createView()
            ));
        }
    }

    public function checkFieldsAction(){
        $isAjax = $this->getRequest()->isXmlHttpRequest();
    	if($isAjax){
            $usersRepo = $this->getDoctrine()->getRepository('D4DAppBundle:Users');
            $field = $this->get('request')->get('field');
            $value = $this->get('request')->get('value');
            $function = 'findBy' . $field;
            $user = $usersRepo->$function($value);
            return $this->render('D4DAppBundle:Frontend/User:checkFields.twig.html', array(
                'nick'  => $user ? 1 : 0,
                'class' => $field
            ));
    	}
    }
    
    public function sendMailAction($user, $pass = '', $templates = array()){  
        if(is_string($templates))$templates = array($templates);
        $templatesRepo = $this->getDoctrine()->getRepository('D4DAppBundle:LangDyncpages');
        $code = md5($user->getUseremail() . $user->getUsernic() . $user->getUserId());        
        $hostName = $this->getRequest()->getHost();
        $ConstantsValues = $templatesRepo->getConstantsValues(array('pass' => $pass, 'code' => $code, 'hostName' => $hostName, 'user' => $user)); 
        
        if(count($templates)>0){
            foreach($templates as $name){
                $template = $templatesRepo->findOneByPagename($name);                        
                $body = str_replace($ConstantsValues['find'], $ConstantsValues['values'], $template->getPagebody());

                $message = \Swift_Message::newInstance()
                    ->setSubject($template->getPagetitle() . ' ' . $hostName)
                    ->setFrom($template->getPagename() . '@' . $hostName)
                    ->setTo('pavel@interdate-ltd.co.il')//$user->getUseremail()
                    ->setBody($body);
                $this->get('mailer')->send($message);		        
            }
        }
    }
    
    public function activationAction($code, $email){
        $result = false;
        $doctrine = $this->getDoctrine();       
        $user = $doctrine->getRepository('D4DAppBundle:Users')->findOneBy(array('useremail' => $email, 'usernotcomlitedregistration' => 1));
        if($user){
            $codeCheck = md5($user->getUseremail() . $user->getUsernic() . $user->getUserId());
            if($codeCheck === $code){
                $user->setUsernotcomlitedregistration(0);
                $em = $doctrine->getManager();
                $em->persist($user);
                $em->flush();
                $result = true;
                //$this->redirect($this->generateUrl('homepage'));   
            }
        }
        return $this->render('D4DAppBundle:Frontend/User:activation.twig.html', array(
            'result' => $result
        ));
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
