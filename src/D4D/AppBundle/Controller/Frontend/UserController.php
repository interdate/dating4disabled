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
use D4D\AppBundle\Entity\Images;
use D4D\AppBundle\Entity\UsersSearch;

use D4D\AppBundle\Form\Type\UsersType;
use D4D\AppBundle\Form\Type\SearchType;
use D4D\AppBundle\Form\Type\SignUpType;
use D4D\AppBundle\Form\Type\ImageType;


class UserController extends Controller{        
	    
    public function signUpAction(){
        if( is_object($this->getUser()) ){            
            return $this->redirect($this->generateUrl('user_home'));
        }
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
            $function = 'findOneBy' . $field;
            $user = $usersRepo->$function($value);
            $userId = is_object($this->getUser()) ? $this->getUser()->getUserid() : null;
            if($user != null && $user->getUserid() == $userId)
                $user = null;
            return $this->render('D4DAppBundle:Frontend/User:checkFields.twig.html', array(
                'nick'  => $user ? 1 : 0,
                'class' => $field
            ));
    	}
    }
    
    public function sendMailAction($user, $pass = '', $templates = array()){  
        if(is_string($templates)) $templates = array($templates);
        $templatesRepo = $this->getDoctrine()->getRepository('D4DAppBundle:LangDyncpages');
        $code = md5($user->getUseremail() . $user->getUsernic() . $user->getUserId());        
        $hostName = $this->getRequest()->getHost();
        $constantsValues = $templatesRepo->getConstantsValues(array('pass' => $pass, 'code' => $code, 'hostName' => $hostName, 'user' => $user)); 
        
        if(count($templates)>0){
            foreach($templates as $name){
                $template = $templatesRepo->findOneByPagename($name);                        
                $body = str_replace($constantsValues['find'], $constantsValues['values'], $template->getPagebody());

                $message = \Swift_Message::newInstance()
                    ->setSubject($template->getPagetitle() . ' ' . $hostName)
                    ->setFrom($template->getPagename() . '@' . $hostName)
                    ->setTo($user->getUseremail())
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
    	$currentRoute = $request->get('_route');
    	
    	$action = $request->query->get('action', false);
    	$page = $request->query->get('page', 1);
    	
    	//$viewType = 0;
    	
    	$users['itemsNumber'] = 0;
    	$users['items'] = array();
    	$searchSettings = false;    	
    	$header = 'Advanced Search';
    	$perPage = ($currentRoute == 'user_search_advanced') ? 20 : 66;
    	
    	
    	//$viewTypePath = ($request->get('_route') == 'user_search_advanced') ? 'user_search_advanced_gallery' : 'user_search_advanced';
    	//$viewTypePath = ($request->get('_route') == 'user_search_advanced') ? 'user_search_advanced_gallery' : 'user_search_advanced';
    	$viewTypeData = $usersRepo->getViewTypeDataByCurrentRoute($currentRoute);
    	
    	
    	$post = $request->request->all();
    	$get = $request->query->all();
    	
    	if(isset($post['users']) or isset($get['users'])){
    		$form->submit($request);
    		$searchSettings = isset($post['users']) ? $post['users'] : $get['users'];
    		$geoip = $this->get('maxmind.geoip');
    		$page = isset($post['page']) ? $post['page'] : $page;
    		
    		$users = $usersRepo->search($searchSettings, $page, $geoip, $perPage);
    		$photosRepo = $this->getDoctrine()->getRepository('D4DAppBundle:Images');	
    		
    		foreach ($users['items'] as $item){    			
    			$mainPhoto = $photosRepo->findOneBy(array(
    				'userid' => $item->getUserid(),
    				'imgmain' => true,    						
    			));
    			    			 
    			if($mainPhoto instanceof Images && is_file($mainPhoto->getAbsolutePath())){
    				$item->setMainPhoto( $mainPhoto );
    			}
    		}
    		
    		$header = 'Search Results';

		}
    	
    	return $this->render('D4DAppBundle:Frontend/User:search.twig.html', array(    	
    		'form' => $form->createView(),
    		'users' => $users,
    		//'page' => $page,
    		'searchSettings' => $searchSettings,    		
	   		'header' => $header,
    		'viewType' => $viewTypeData,
    		'pagination' => array(
    			'page' => $page,
    			'route' => $request->get('_route'),
    			'pages_count' => ceil($users['itemsNumber'] / $perPage),
    			'route_params' => array(),
    		)    		
    	));
    	
    }
    
    public function groupAction($groupName = false){

    	$request = $this->get('request');
    	$currentRoute = $request->get('_route');
    	$perPage = ($currentRoute == 'user_users_group') ? 20 : 66;    	
    	$userId = $this->getUser()->getUserid();
    	$usersRepo = $this->getDoctrine()->getRepository('D4DAppBundle:Users');    	
    	$geoip = $this->get('maxmind.geoip');
    	$post = $request->request->all();
    	$page = isset($post['page']) ? $post['page'] : 1;
    	$users = $usersRepo->getUsersByGroup($userId, $groupName, $page, $perPage, $geoip);
    	
    	if(!$groupName){
    		$groupName = $post['groupName'];
    	}
    	
    	$header = $usersRepo->getGroupHeaderByGroupName($groupName);
    	$viewTypeData = $usersRepo->getViewTypeDataByCurrentRoute($currentRoute);
    
    	return $this->render('D4DAppBundle:Frontend/User:search.twig.html', array(
    		'users' => $users,
    		'groupName' => $groupName, 
    		//'page' => $page,
    		'header' => $header,
    		'viewType' => $viewTypeData,
    		'pagination' => array(
    			'page' => $page,
    			'route' => $request->get('_route'),
    			'pages_count' => ceil($users['itemsNumber'] / $perPage),
    			'route_params' => array(),
    		)
    	));
    	 
    }
    
    public function paymentAction(){
        return $this->render('D4DAppBundle:Frontend/User:payment.twig.html');
    }
    
    public function paymentSuccessAction(){
        $sql = "EXEC site_payments_payment_in ";
        $request = $this->get('request');
        $tranzilaIndex = $request->get("order_number");
        if($tranzilaIndex != null){
            $paymentName = 'Checkout';
            $amount = $request->get('total');
            $productId = $request->get("product_id");
            switch($productId){
                case '1':
                    $numOfMonth = 1;
                    break;
                case '4':
                    $numOfMonth = 12;
                    break;
                default :
                    $numOfMonth = ($productId - 1) * 3;
                    break;                
            }
            
            $userid = $request->get("userid");
            
        }
        $txn_id = $request->get('txn_id');
        if($txn_id != null){
            $paymentName = 'PayPal';
            $amount = $request->get('mc_gross');
            $numOfMonth = $request->get('custom');
            switch($numOfMonth){
                case '1':
                    $productId = 1;
                    break;
                case '12':
                    $productId = 4;
                    break;
                default :                    
                    $productId = ($numOfMonth / 3) + 1;
                    break;                
            }
            $tranzilaIndex = $txn_id;
            $userid = $request->get("item_number");
        }
        $userId = explode('mb', $userid);
        
        $sql .= $productId . ',' . $amount . ',' . $tranzilaIndex . ',' . $userId[0] . ',' . $numOfMonth . ',' . $paymentName . ',null'; 
        $this->connection = $this->getDoctrine()->getManager()->getConnection();                
        $stmt = $this->connection->query($sql);
        if($stmt->execute()){
            $result['success'] = "Your payment was successful";
        }else{
            $result['error'] = "Error: Something went wrong. Try again";
        }
        
    }
    
    public function paymentSubscriptionAction(){
        $sql = "EXEC site_payments_subscription_execute_sa ";
        $request = $this->get('request');
        $order_number = $request->get('order_number');
        $txn_id = $request->get('txn_id');
        if($order_number != null){
            $tranzilaIndex = $parentTranzilaIndex = $order_number;
        }
        if($txn_id != null){
            $tranzilaIndex = $txn_id;
            $parentTranzilaIndex = $request->get("parent_txn_id");
        }
        $test = implode('&', $request->request->all());
        $sql .= $tranzilaIndex . ',' . $parentTranzilaIndex . ',' . $test; 
        $this->connection = $this->getDoctrine()->getManager()->getConnection();                
        $stmt = $this->connection->query($sql);
        if($stmt->execute()){
            $result['success'] = "Your payment was successful";
        }else{
            $result['error'] = "Error: Something went wrong. Try again";
        }
    }
    
    public function profileAction(){
        $doctrine = $this->getDoctrine();
        $save = false;
        $user = $this->getUser();
        
        $variables['form'] = 'edit';
        $citiesRepo = $doctrine->getRepository('D4DAppBundle:LocCities'); 
        $variables['cities'] = $citiesRepo->findBy(array('countrycode' => $user->getCountrycode(), 'regioncode' => $user->getRegioncode()));
        $regionsRepo = $doctrine->getRepository('D4DAppBundle:LocRegions');
        $variables['regions'] = $regionsRepo->findByCountrycode($user->getCountrycode());
        
        $form = $this->createForm(new SignUpType($user, $doctrine, $variables), $user);
        $request = $this->get('request');
        if($request->isMethod('POST')){
            $form->submit($request);
            if($form->isValid()){
                $em = $doctrine->getManager();
                $em->persist($user);
                $em->flush();
                $save = true;
            }
        }
        return $this->render('D4DAppBundle:Frontend/User:profile.twig.html', array(
    		'form' => $form->createView(),
                'save' => $save
    	));
    }
    
    public function photosAction(){
        $request = $this->get('request');
        $doctrine = $this->getDoctrine();
        $photosRepo = $doctrine->getRepository('D4DAppBundle:Images');  
        if($request->isXmlHttpRequest()){
            $photo = $photosRepo->find($request->get('id'));
            $photosRepo->execute($request->get('action'), $photo);
        }        
        $form = $this->createForm(new ImageType());
    	$photos = $photosRepo->findBy(
    		array('userid' => $this->getUser()->getUserid()),
    		array('imgid' => 'ASC')
    	);
        if($request->isMethod('POST')){
            $form->submit($request);
            if($form->isValid()){
                $em = $doctrine->getManager();
                $files = $request->files;
                foreach ($files as $uploadedFile){ 
                    $file = $uploadedFile['file'];
                    if($file){                                            
                        $image = new Images();
                        $image->setImgvalidated(false);
                        $image->setHomepage(false);
                        $image->setFile($file);                        
                        $image->setUserid($this->getUser());
                        if(count($photos) == 0)
                            $image->setImgmain(true);
                        else
                            $image->setImgmain(false);
                        $image->preUpload();
                        $em->persist($image);
                        $em->flush();                        
                        $image->upload(); 
                    }
                }
                $photos[] = $image;
            }
        }
    	    	
        return $this->render('D4DAppBundle:Frontend/User:photos.twig.html', array(
    		'form' => $form->createView(),
                'photos' => $photos
    	));
    }
    
    public function viewProfileAction(){
    	$isAjax = $this->getRequest()->isXmlHttpRequest();
    	if($isAjax){
    		$usersRepo = $this->getDoctrine()->getRepository('D4DAppBundle:Users');
    		$photosRepo = $this->getDoctrine()->getRepository('D4DAppBundle:Images');
    		$request = $this->get('request');
    
    		$userId = $request->query->get('userId');
    		$user = $usersRepo->find($userId);
    
    		$photos = $photosRepo->findBy(
    			array('userid' => $userId),
    			array('imgmain' => 'DESC', 'imgid' => 'ASC')
    		);
    		
    		if(isset($photos[0]))    
    			$user->setMainPhoto($photos[0]);
    
    		return $this->render('D4DAppBundle:Frontend/User:viewProfile.twig.html', array(
    			'user' => $user,
    			'photos' => $photos,
    		));
    	}
    }
    
    


}
