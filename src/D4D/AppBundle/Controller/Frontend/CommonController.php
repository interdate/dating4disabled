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



class CommonController extends Controller{
	    
    public function newUsersAction($count = 3){
        $doctrine = $this->getDoctrine();
        $sql = "EXEC site_defaultPage";
        $this->connection = $doctrine->getManager()->getConnection();
        $stmt = $this->connection->query($sql);
        $stmt->execute();
        $countries = $stmt->fetchAll();
        $stmt->nextRowset();
        $boys = $stmt->fetchAll();
        $stmt->nextRowset();
        $girls = $stmt->fetchAll();
        for($i = 0; $i < $count; $i++){
            $item = ($i % 2 == 0) ? $girls[$i] : $boys[$i];
            //var_dump($item);die;
            $user = $doctrine->getRepository('D4DAppBundle:Users')->find($item['userId']);
            $image = $doctrine->getRepository('D4DAppBundle:Images')->find($item['imgId']);
            $users[] = array('user' => $user, 'image' => $image, 'age' => $item['age'], 'country' => $item['countryName']);
        }
        
    	return $this->render('D4DAppBundle:Frontend/Common:newUsers.twig.html', array('users' => $users));    	
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