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



class DefaultController extends Controller{
	    
    public function indexAction(Request $request){
        $result = $this->get('d4d_security')->auth($request);
    	return $this->render('D4DAppBundle:Frontend/Default:index.twig.html', $result);    	
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