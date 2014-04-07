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

use D4D\AppBundle\Form\Type\NewsType;
use D4D\AppBundle\Entity\News;


class NewsController extends Controller{
    
    public function indexAction(){        
        $doctrine = $this->getDoctrine();
        $repository = $doctrine->getRepository('D4DAppBundle:News');
        $faqs = $repository->findAllPagination($this);
        $page = $this->get('request')->query->get('page', 1);
        return $this->render('D4DAppBundle:Backend/News:index.twig.html', array('pagination' => $faqs, 'page' => $page));
    }
    
    public function formNewsAction($id = 0, $page = 1){
        $doctrine = $this->getDoctrine();
        $repository = $doctrine->getRepository('D4DAppBundle:News');        
        $action = ($id > 0) ? 'Edit' : 'Add';
        $news = ($id > 0) ? $repository->find($id) : new News();
        $request = $this->get('request');
        $form = $this->createForm(new NewsType(), $news);
        $parameters = ($page == 1) ? array() : array('page' => $page);
        if ($request->isMethod('POST')) {                         
            $form->bind($request);
            if($form->isValid()){ 
                $em = $doctrine->getManager();   
                if($id == 0) $news->setNewsitemdate(new \DateTime());
                $em->persist($news);	    	
                $em->flush();                
                return $this->redirect($this->generateUrl('admin_news',$parameters));
            }
        }
        $backUrl = $this->generateUrl('admin_news',$parameters);
        $formIcon = ($id > 0) ? 'save' : 'add sign';
        $buttonValue = ($id > 0) ? 'Save' : 'Add';
        return $this->render('D4DAppBundle:Backend/News:formNews.twig.html', 
                array(  'form'      => $form->createView(),
                        'action'    => $action, 
                        'newsUrl'    => $backUrl, 
                        'icon'      => $formIcon, 
                        'button'    => $buttonValue));
    }

    public function deleteNewsAction($id = 0, $page = 1){
        if($id > 0) {
            $em = $this->getDoctrine()->getManager();
            $news = $em->getRepository('D4DAppBundle:News')->find($id);
            $parameters = ($page == 1) ? array() : array('page' => $page);
            if($news) {                
                $em->remove($news);
                $em->flush();
            }
        }
        return $this->redirect($this->generateUrl('admin_news',$parameters));
    }
}
