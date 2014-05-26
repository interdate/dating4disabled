<?php
namespace D4D\AppBundle\Entity;

//use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityRepository;

class ImagesRepository extends EntityRepository{
	
	public function execute($action, $photo){
		
		$em = $this->getEntityManager();
		$userId = $photo->getUserid();
		$photos = $this->findByUserid($userId);
		
		if($action == 'remove'){
			
			return "success";
		}else{			
			switch ($action){
				case 'approve':
					$photo->setImgvalidated(1);
					break;
	
				case 'setMain':
					foreach ($photos as $item){
						$item->setImgmain(0);
						$em->persist($item);
						$em->flush();
					}
					
					$photo->setImgmain(1);
					break;
					
				case 'homepage':
					foreach ($photos as $item){
						$item->setHomepage(0);
						$em->persist($item);
						$em->flush();
					}
							
					$photo->setHomepage(1);
					break;
				
				case 'unapproved':
					$photo->setImgvalidated(0);
					break;				
			}			
					
			$em->persist($photo);
			$em->flush();
			
			return "success";		
		}
		
		
		return "fail";
		
	}
	
}