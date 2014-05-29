<?php
namespace D4D\AppBundle\Entity;

//use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityRepository;

class ImagesRepository extends EntityRepository{
	
	public function execute($action, $photo){
		
		$em = $this->getEntityManager();
		$userId = $photo->getUserid();
		$photos = $this->findByUserid($userId);		
					
		switch ($action){
			case 'approve':
				$photo->setImgvalidated(1);
				$em->persist($photo);
				break;
	
			case 'setMain':
				foreach ($photos as $item){
					$item->setImgmain(0);
					$em->persist($item);
					$em->flush();
				}
					
				$photo->setImgmain(1);
				$em->persist($photo);
				break;
					
			case 'homepage':
				foreach ($photos as $item){
					$item->setHomepage(0);
					$em->persist($item);
					$em->flush();
				}
							
				$photo->setHomepage(1);
				$em->persist($photo);
				break;
				
			case 'unapproved':
				$photo->setImgvalidated(0);
				$em->persist($photo);
				break;

			case 'remove':
				$em->remove($photo);
				break;				
		}	
			
		$em->flush();
	}
	
	
	public function getUnapprovedPhotos(){
		$photos = array();				
		$sql = "EXEC admin_images_sa_notValidated";
		$connection = $this->getEntityManager()->getConnection();
		$stmt = $connection->query($sql);
		$stmt->execute();
		$result = $stmt->fetchAll();
			
		if(count($result)){		
			$photos['itemsNumber'] = count($result);
			//$usersRepo = $this->getEntityManager()->getRepository('D4DAppBundle:Users');		
			foreach ($result as $row){				
				//$users['items'][] = $this->completeUser($user, $geoip);
				$photo = $this->find($row['imgId']);				
				$photos['items'][] = $photo;
			}
		}
		
		return $photos;
	}
	
	public function approvePhotos($photosIdsString){
		//$photosIdsString = implode(",", $photosIds);
		$sql = "EXEC admin_images_setValidated ?";
		$connection = $this->getEntityManager()->getConnection();		
		$stmt = $connection->prepare($sql);
		$stmt->bindParam(1, $photosIdsString);		
		$stmt->execute();
		return $stmt->fetchAll();
	}
	
}