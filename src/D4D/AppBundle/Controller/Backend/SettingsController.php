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

use D4D\AppBundle\Form\Type\AdminpropertiesType;
use D4D\AppBundle\Entity\Adminproperties;


class SettingsController extends Controller{
    
    public function indexAction(){        
        $doctrine = $this->getDoctrine();
        $repository = $doctrine->getRepository('D4DAppBundle:Adminproperties');        
        $settings = $repository->findby(array('changeable' => '1'),array('propgroup' => 'ASC'));
        $settings = $repository->getValue($settings);
                
        return $this->render('D4DAppBundle:Backend/Settings:index.twig.html', array('settings' => $settings));
    }
    
    public function editAction($id = 0){ 
        $backUrl = $this->generateUrl('admin_settings');
        if ($id==0) return $this->redirect($backUrl);
        
        $doctrine = $this->getDoctrine();
        $repository = $doctrine->getRepository('D4DAppBundle:Adminproperties');        
        $setting = $repository->find($id);
                
        $form = $this->createForm(new AdminpropertiesType(), $setting);        
        $form = $repository->addFormField($form, $setting);                
        
        $request = $this->get('request');
        if ($request->isMethod('POST')) {                         
            $form->bind($request);
            if($form->isValid()){ 
                $em = $doctrine->getManager();                  
                $em->persist($setting);	    	
                $em->flush();
                return $this->redirect($backUrl);
            }
        }
        
        $formOptions['type'] = $setting->getPropdisplaytype();
        $formOptions['form'] = $form->createView();
        
        return $this->render('D4DAppBundle:Backend/Settings:edit.twig.html', $formOptions);
    }

}
