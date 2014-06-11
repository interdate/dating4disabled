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

class AppServiceController extends Controller
{
    public function indexAction($name)
    {   
        /*
    	$repo = $this->getDoctrine()->getRepository('D4DAppBundle:Users');    	
    	//$qb = $this->getDoctrine()->getEntityManager()->createQueryBuilder();
    	
        $user = $repo->find(40418);
        
        return $this->render('D4DAppBundle:Default:index.html.twig', array(
        	'user' => $user,
        ));       
    	
    	$userId = '40418';
    	$userIdLooking = '40418';
    	$conn = $this->get('database_connection');
    	$stmt = $conn->prepare("EXEC site_users_profile ?,?");
    	$stmt->bindParam(1, $userId);
    	$stmt->bindParam(2, $userIdLooking);    	
    	$stmt->execute();    	
    	
    	while($result = $stmt->fetch(\PDO::FETCH_ASSOC)) {
    		var_dump($result);
    		echo '<br />';
    	}
    	die();
    	*/
    	
    	
    }
    
    public function encodePasswordsAction(){    	
    	
    	/*
    	$repo = $this->getDoctrine()->getRepository('D4DAppBundle:Users');    	
    	$users = $repo->findAll();
    	*/
    	
    	$conn = $this->get('database_connection');
    	$stmt = $conn->prepare("SELECT userId, userPass FROM users");
    	$stmt->execute();
    	
    	while($user = $stmt->fetch(\PDO::FETCH_ASSOC)) {
    		$newUser = new Users();
    		$factory = $this->get('security.encoder_factory');
    		$encoder = $factory->getEncoder($newUser);    		
    		$salt = $newUser->getSalt();
    		$encodedPassword = $encoder->encodePassword($user['userPass'], $salt);    		
    		$users[] = array(
    			'userId' => $user['userId'],	
    			'encodedPassword' => $encodedPassword,
    			'salt' => $salt,    					
    		);
    	}
    	
    	foreach ($users as $user){    		
    		$stmt = $conn->prepare("UPDATE users SET tempPassword = ?, salt = ? WHERE userId = ?");
    		$stmt->bindParam(1, $user['encodedPassword']);
    		$stmt->bindParam(2, $user['salt']);
    		$stmt->bindParam(3, $user['userId']);
    		
    		//$stmt->execute();    		
    	}
    	
    	die();
    	
    	
    }
    
    public function overridePasswordsAction(){
    	    	 
    	$conn = $this->get('database_connection');
    	$stmt = $conn->prepare("SELECT userId, tempPassword FROM users");
    	$stmt->execute();
    	 
    	while($user = $stmt->fetch(\PDO::FETCH_ASSOC)) {    		
    		$users[] = array(
    			'userId' => $user['userId'],
    			'encodedPassword' => $user['tempPassword'],    				
    		);    
    	}
    	 
    	foreach ($users as $user){
    		$stmt = $conn->prepare("UPDATE users SET userPass = ? WHERE userId = ?");
    		$stmt->bindParam(1, $user['encodedPassword']);    		
    		$stmt->bindParam(2, $user['userId']);
    		//$stmt->execute();
    	}
    	
    	die();
    	 
    }
    
    public function checkLoginAction(){
    	$username = 'Test user';
    	$password = '1234';
    	
    	$repo = $this->getDoctrine()->getRepository('D4DAppBundle:Users');
    	$user = $repo->findOneByUsernic($username);
    	
    	if($user){
    		$factory = $this->get('security.encoder_factory');
    		$encoder = $factory->getEncoder($user);
    		$passwordValid = $encoder->isPasswordValid($user->getUserpass(), $password, $user->getSalt());
    		if($passwordValid)
    			echo 1;
    		else 
    			echo 0;
    	}
    	
    	die();
    	
    }    
    
    public function fetchCountriesAction(){
    	 
    	$countriesRepo = $this->getDoctrine()->getRepository('D4DAppBundle:LocCountries');
    	$countries = $countriesRepo->findAll();
    	
    	return $this->render('D4DAppBundle:Frontend/Common:countries.twig.html', array('countries' => $countries));
    }    
    
}
