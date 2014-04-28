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

use D4D\AppBundle\Form\Type\BannersType;
use D4D\AppBundle\Entity\Banners;


class BannersController extends Controller{
    
    public function indexAction(){        
        $doctrine = $this->getDoctrine();
        $repository = $doctrine->getRepository('D4DAppBundle:Banners');
        
        $banners = $repository->findAllPagination($this);
        $page = $this->get('request')->query->get('page', 1);
        
        return $this->render('D4DAppBundle:Backend/Banners:index.twig.html', array('pagination' => $banners, 'page' => $page));
    }
    
    public function formAction($id = 0, $page = 1){
        $doctrine = $this->getDoctrine();
        $repository = $doctrine->getRepository('D4DAppBundle:Banners');        
        
        $banner = ($id > 0) ? $repository->find($id) : new Banners();
        $bannerfileext = ($id > 0) ? $banner->getBannerfileext() : false;
        $request = $this->get('request');
        $form = $this->createForm(new BannersType(), $banner);
        
        if($id > 0) $form->add('bannerfileext', 'file', array('label' => 'File','data' => '', 'required' => false));
        $formOptions = $repository->getFormOptions($id, $page, $this->get('router'));
        
        if ($request->isMethod('POST')) {                         
            $form->bind($request);
            if($form->isValid()){ 
                $save = $repository->saveBanner($banner, $request->files, $bannerfileext);
                if($save) return $this->redirect($formOptions['bannersUrl']);
            }
        }    
        
        $formOptions['form'] = $form->createView();
        return $this->render('D4DAppBundle:Backend/Banners:bannersForm.twig.html', $formOptions);
    }

    public function deleteAction($id = 0, $page = 1){
        if($id > 0) {
            $em = $this->getDoctrine()->getManager();
            $bannerRepo = $em->getRepository('D4DAppBundle:Banners');
            
            $banner = $bannerRepo->find($id);
            $parameters = ($page == 1) ? array() : array('page' => $page);
            
            if($banner) { 
                $image = $bannerRepo->getBannersPath($_SERVER['DOCUMENT_ROOT']) . $id . '.' . $banner->getBannerfileext();
                if(file_exists($image));
                    unlink($image);
                $em->remove($banner);
                $em->flush();                
            }
        }
        
        return $this->redirect($this->generateUrl('admin_banners',$parameters));
    }
}
