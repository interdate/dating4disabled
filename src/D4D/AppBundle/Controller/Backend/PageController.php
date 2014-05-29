<?php

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
use D4D\AppBundle\Form\Type\TemplatesType;
use D4D\AppBundle\Entity\LangDyncpages;


class PageController extends Controller{
    
    public function indexAction($type = 'page'){
        $doctrine = $this->getDoctrine();
        $repository = $doctrine->getRepository('D4DAppBundle:LangDyncpages');
        
        $parameters = $repository->getIndexParameters($type);
        $parameters['pagination'] = $repository->findAllPagination($this, $type);
        $parameters['page'] = $this->get('request')->query->get('page', 1);
        
        return $this->render('D4DAppBundle:Backend/Page:index.twig.html', $parameters);
    }
    

    public function formAction($id = 0, $page = 1, $type = 'page'){
        $doctrine = $this->getDoctrine();
        $repository = $doctrine->getRepository('D4DAppBundle:LangDyncpages');  
        
        $parameters = $repository->getFormParameters($id, $page, $this->get('router'), $type);
        $pages = ($id > 0) ? $repository->find($id) : new LangDyncpages();
        $formType = ($type == 'page') ? new LangDyncpagesType() : new TemplatesType();
        $form = $this->createForm($formType, $pages);
        $request = $this->get('request');
        
        if ($request->isMethod('POST')) {                         
            $form->bind($request);
            if($form->isValid()){ 
                $em = $doctrine->getManager();   
                $em->persist($pages);	    	
                $em->flush();                
                return $this->redirect($parameters['pagesUrl']);
            }
        }
        
        $parameters['form'] = $form->createView();        
        return $this->render('D4DAppBundle:Backend/Page:formPage.twig.html', $parameters);
    }

    public function deleteAction($id = 0, $page = 1, $type = 'page'){
        
        if($id>0){
            $em = $this->getDoctrine()->getManager();
            $pages = $em->getRepository('D4DAppBundle:LangDyncpages')->find($id);
            $parameters = ($page == 1) ? array() : array('page' => $page);
            
            if($pages){                
                $em->remove($pages);
                $em->flush();
            }
        }
        $url = ($type == 'page') ? 'admin_pages' : 'admin_templates';
        return $this->redirect($this->generateUrl($url,$parameters));
    }
    
}
