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
        return $this->render('D4DAppBundle:Backend/Faq:faq.twig.html', array('pagination' => $faqs, 'page'=>$page, 'cats' => $categories));
    }
    
    public function formFaqAction($id=0,$page=1){
        
        $doctrine = $this->getDoctrine();
        $repository = $doctrine->getRepository('D4DAppBundle:Faq');        
        $action=($id>0)?'Edit':'Add';        
        $request = $this->get('request');
    	$post = $request->request->all(); 
        $form = $repository->bildFaqForm($this,$id); 
        $parameters = $page==1?array():array('page'=>$page);
        if ($request->isMethod('POST')) {                         
            $form->bind($request);
            if($form->isValid()){ 
                $em = $doctrine->getManager();
                $faq = ($id>0)?$repository->find($id): new Faq();
                $faq->setFaqq($post['faq']['faqq']);
                $faq->setFaqa($post['faq']['faqa']);
                $catRepo = $doctrine->getRepository('D4DAppBundle:Faqcategory');
                $catId = $catRepo->find($post['faq']['faqcategoryid']);
                $faq->setFaqcategoryid($catId);
                $em->persist($faq);	    	
                $em->flush();                
                return $this->redirect($this->generateUrl('admin_faq',$parameters));
            }
        }
        $backUrl = $this->generateUrl('admin_faq',$parameters);
        $formIcon = ($id>0)?'save':'add sign';
        $buttonValue = ($id>0)?'Save':'Add';
        return $this->render('D4DAppBundle:Backend/Faq:formfaq.twig.html', 
                array(  'form'=>$form->createView(),
                        'action'=>$action, 
                        'faqurl'=>$backUrl, 
                        'icon'=>$formIcon, 
                        'button'=>$buttonValue));
    }
    
    public function deleteFaqAction($id,$page){
        if($id>0){
            $em = $this->getDoctrine()->getManager();
            $faq = $em->getRepository('D4DAppBundle:Faq')->find($id); 
            if($faq){
                $em->remove($faq);
                $em->flush();
            }
        }
        $parameters = $page==1?array():array('page'=>$page);
        
        return $this->redirect($this->generateUrl('admin_faq',$parameters));
    }
    
    public function formCategotyAction($id=0){
        $doctrine = $this->getDoctrine();
        $repository = $doctrine->getRepository('D4DAppBundle:Faqcategory');        
        $action=($id>0)?'Edit':'Add';
        $faqCategory = ($id>0)?$repository->find($id): new Faqcategory();
        $request = $this->get('request');
        $form = $this->createForm(new FaqcategoryType(), $faqCategory);        
        if ($request->isMethod('POST')) {                         
            $form->bind($request);
            if($form->isValid()){ 
                $em = $doctrine->getManager();   
                $em->persist($faqCategory);	    	
                $em->flush();                
                return $this->redirect($this->generateUrl('admin_faq').'#categories');
            }
        }
        $backUrl = $this->generateUrl('admin_faq');
        $formIcon = ($id>0)?'save':'add sign';
        $buttonValue = ($id>0)?'Save':'Add';
        return $this->render('D4DAppBundle:Backend/Faq:formfaqcategory.twig.html', 
                array(  'form'=>$form->createView(),
                        'action'=>$action, 
                        'faqurl'=>$backUrl, 
                        'icon'=>$formIcon, 
                        'button'=>$buttonValue));
    }

    public function deleteCategoryAction($id=0){
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
                $faqCategory = $faqRepo->find($id); 
                $em->remove($faqCategory);
                $em->flush();
            }
        }
        return $this->redirect($this->generateUrl('admin_faq').'#categories');
    }
}
