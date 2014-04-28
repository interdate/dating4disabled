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

use D4D\AppBundle\Form\Type\FaqType;
use D4D\AppBundle\Form\Type\FaqcategoryType;
use D4D\AppBundle\Entity\Faq;
use D4D\AppBundle\Entity\Faqcategory;


class FaqController extends Controller{
    
    public function indexAction(){
        
        $doctrine = $this->getDoctrine();
        $repository = $doctrine->getRepository('D4DAppBundle:Faq');
        
        $faqs = $repository->findAllPagination($this);
        $categories = $doctrine->getRepository('D4DAppBundle:Faqcategory')->findAll(); 
        $page = $this->get('request')->query->get('page', 1);
        
        return $this->render('D4DAppBundle:Backend/Faq:faq.twig.html', array('pagination' => $faqs, 'page' => $page, 'cats' => $categories));
    }
    
    public function formFaqAction($id = 0, $page = 1){
        
        $doctrine = $this->getDoctrine();
        $repository = $doctrine->getRepository('D4DAppBundle:Faq');
        
        $request = $this->get('request');
        $faq = ($id>0) ? $repository->find($id) : new Faq();
        $form = $this->createForm(new FaqType(), $faq);
        $parameters = $repository->getFormParameters($id, $this->get('router'), $page);
        
        if ($request->isMethod('POST')) {                         
            $form->bind($request);
            if($form->isValid()){ 
                $em = $doctrine->getManager();
                $em->persist($faq);	    	
                $em->flush();                
                return $this->redirect($parameters['faqurl']);
            }
        }
        
        $parameters['form'] = $form->createView();
        return $this->render('D4DAppBundle:Backend/Faq:formfaq.twig.html', $parameters);
    }
    
    public function deleteFaqAction($id, $page){
        
        if($id>0){
            $em = $this->getDoctrine()->getManager();
            $faq = $em->getRepository('D4DAppBundle:Faq')->find($id); 
            if($faq){
                $em->remove($faq);
                $em->flush();
            }
        }
        
        $parameters = ($page==1) ? array() : array('page' => $page);
        return $this->redirect($this->generateUrl('admin_faq', $parameters));
    }
    
    public function formCategotyAction($id = 0){
        
        $doctrine = $this->getDoctrine();
        
        $categoryRepo = $doctrine->getRepository('D4DAppBundle:Faqcategory');                
        $faqCategory = ($id>0) ? $categoryRepo->find($id) : new Faqcategory();        
        $request = $this->get('request');
        $form = $this->createForm(new FaqcategoryType(), $faqCategory);
        $faqRepo = $doctrine->getRepository('D4DAppBundle:Faq');
        $parameters = $faqRepo->getFormParameters($id, $this->get('router'));
        
        if ($request->isMethod('POST')) { 
            $form->bind($request);
            if($form->isValid()){ 
                $em = $doctrine->getManager(); 
                $em->persist($faqCategory);	    	
                $em->flush();                
                return $this->redirect($parameters['faqurl'] . '#categories');
            }
        }
        
        $parameters['form'] = $form->createView();
        return $this->render('D4DAppBundle:Backend/Faq:formfaqcategory.twig.html', $parameters);
    }

    public function deleteCategoryAction($id = 0){
        
        if($id>0){
            $em = $this->getDoctrine()->getManager();
            $faqRepo = $em->getRepository('D4DAppBundle:Faqcategory');
            $faqs = $em->getRepository('D4DAppBundle:Faq')->findByFaqcategoryid($id);
            
            if($faqs){
                $defaultCategory = $faqRepo->find(15);
                foreach($faqs as $faq){
                    $faq->setFaqcategoryid($defaultCategory);
                    $em->persist($faq);	    	
                    $em->flush();                
                }
            }
            
            $faqCategory = $faqRepo->find($id); 
            $em->remove($faqCategory);
            $em->flush();
        }
        
        return $this->redirect($this->generateUrl('admin_faq') . '#categories');
    }
}
