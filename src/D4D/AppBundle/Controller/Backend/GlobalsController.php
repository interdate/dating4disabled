<?php

namespace D4D\AppBundle\Controller\Backend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use D4D\AppBundle\Form\Type\GlobalsPointType;
use D4D\AppBundle\Form\Type\GlobalsMessageType;

use Symfony\Component\Form\FormError;


class GlobalsController extends Controller{
    
    public function indexAction(){    
        $point = $this->createForm(new GlobalsPointType());
        $message = $this->createForm(new GlobalsMessageType());
        $request = $this->get('request');
        if ($request->isMethod('POST')) { 
            $globalMessage = $request->request->get("globalMessage");
            if(is_array($globalMessage)){
                $message->submit($request);
                if($message->isValid()){
                    $info = $this->saveAction($request);
                    $message = $this->createForm(new GlobalsMessageType());
                }else
                   $info = false;                 
            }else
            $info = $this->saveAction($request);
        }else
            $info = false;
        
        return $this->render('D4DAppBundle:Backend/Globals:index.twig.html', array('points' => $point->createView(), 'messages' => $message->createView(), 'info' => $info));
    }
    
    public function saveAction($request){
        $result = array();
        $postPoint = $request->request->get("globalPoint");
        if(is_array($postPoint)){            
            $sql = "EXEC admin_users_addPointsAll ";
            $sql .= $postPoint['points'] . ',' . $postPoint['whereLessThen']; 
            //echo $sql . '<br />';
            
            $this->connection = $this->getDoctrine()->getManager()->getConnection();                
            $stmt = $this->connection->query($sql);
            if($stmt->execute()){
                $result['success'] = "Adding points was successful";
            }else{
                $result['error'] = "Error: Something went wrong. Try again";
            }
            $result['form'] = 'point';
        }
        $message = $request->request->get("globalMessage");
        if(is_array($message)){
            
            $result['success'] = "Your messages send was successful to all users";
            $result['form'] = 'message';
        }
        return $result;
    }
}
