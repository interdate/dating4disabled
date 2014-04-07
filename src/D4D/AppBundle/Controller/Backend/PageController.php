<?php

//namespace D4D\AppBundle\Controller\Backend;
//
//use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//
//use Symfony\Component\Security\Core\SecurityContext;
//use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
//use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
//use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
//
//use Symfony\Component\HttpFoundation\Cookie;
//use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\HttpFoundation\Response;
//use Symfony\Component\HttpFoundation\JsonResponse;
//
//use D4D\AppBundle\Form\Type\LangDyncpagesType;
//use D4D\AppBundle\Entity\LangDyncpages;

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

use D4D\AppBundle\Entity\Users;
use D4D\AppBundle\Form\Type\LangDyncpagesType;
//use D4D\AppBundle\Form\Type\FaqcategoryType;
use D4D\AppBundle\Entity\LangDyncpages;
//use D4D\AppBundle\Entity\Faqcategory;


class PageController extends Controller{
    
    public function indexAction(){
        
        $doctrine = $this->getDoctrine();
        $repository = $doctrine->getRepository('D4DAppBundle:LangDyncpages');
        $pages = $repository->findAllPagination($this);
        $page = $this->get('request')->query->get('page', 1);
        return $this->render('D4DAppBundle:Backend/Page:index.twig.html', array('pagination' => $pages, 'page' => $page));
    }
    

    public function formPageAction($id = 0, $page = 1){
        $doctrine = $this->getDoctrine();
        $repository = $doctrine->getRepository('D4DAppBundle:LangDyncpages');        
        $action = ($id > 0) ? 'Edit' : 'Add';
        $pages = ($id > 0) ? $repository->find($id) : new LangDyncpages();
        $request = $this->get('request');
        $form = $this->createForm(new LangDyncpagesType(), $pages);
        $parameters = ($page == 1) ? array() : array('page' => $page);
        $backUrl = $this->generateUrl('admin_pages',$parameters);
        if ($request->isMethod('POST')) {                         
            $form->bind($request);
            if($form->isValid()){ 
                $em = $doctrine->getManager();   
                $em->persist($pages);	    	
                $em->flush();                
                return $this->redirect($backUrl);
            }
        }        
        $formIcon = ($id > 0) ? 'save' : 'add sign';
        $buttonValue = ($id > 0) ? 'Save' : 'Add';
        return $this->render('D4DAppBundle:Backend/Page:formPage.twig.html', 
                array(  'form'      => $form->createView(),
                        'action'    => $action, 
                        'pagesUrl'    => $backUrl, 
                        'icon'      => $formIcon, 
                        'button'    => $buttonValue));
    }

    public function deletePageAction($id = 0, $page = 1){
        if($id>0){
            $em = $this->getDoctrine()->getManager();
            $pages = $em->getRepository('D4DAppBundle:LangDyncpages')->find($id);
            $parameters = ($page == 1) ? array() : array('page' => $page);
            if($pages){                
                $em->remove($pages);
                $em->flush();
            }
        }
        return $this->redirect($this->generateUrl('admin_pages',$parameters));
    }
    
}
