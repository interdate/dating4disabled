<?php 

namespace D4D\AppBundle\Services\Messenger;

class Dialog extends Chat{
	
	
	public function __construct($options){	
		parent::__construct($options);
	}
	
	public function setMessageAsDelivered($messageId){
		$sql = "UPDATE " . $this->config->messenger->table . " SET isDelivered = 1, modified = ? WHERE messageId = ?";
		$stmt = $this->db->prepare($sql);
		$modified = date("Y-m-d h:i:s");
		$stmt->bindParam(1, $modified, \PDO::PARAM_INT);
		$stmt->bindParam(2, $messageId, \PDO::PARAM_INT);
		$stmt->execute();
	}
	
		
	public function getHistory($messagesNumber = 1000){
		
		$userId = $this->user->getId();
		$contactId = $this->contact->getId();
		$userImage = $this->user->getImage();
		$contactImage = $this->contact->getImage();
		$userNickName = $this->user->getNickName();
		$contactNickName = $this->contact->getNickName();
		$result = array();
		
		$sql = "SELECT TOP " . $messagesNumber . " 
					fromUser,toUser,message,date,isRead,messageId,isDelivered
				FROM
					" . $this->config->messenger->table . "
				WHERE
					(toUser = ? AND fromUser = ?)
				OR
					(toUser = ? AND fromUser = ?)
				ORDER BY 
					messageId 
				DESC";
		
		
		$stmt = $this->db->prepare($sql);
		$stmt->bindParam(1, $userId, \PDO::PARAM_INT);
		$stmt->bindParam(2, $contactId, \PDO::PARAM_INT);
		$stmt->bindParam(3, $contactId, \PDO::PARAM_INT);
		$stmt->bindParam(4, $userId, \PDO::PARAM_INT);
		$stmt->execute();
		$messages = $stmt->fetchAll();	
		$messages = array_reverse($messages);
		
		foreach ($messages as $message){		
			$messageDateObject = new \DateTime($message['date']);
			$timestamp = $messageDateObject->getTimestamp();
			$date = date("d.m.Y", $timestamp);
			$time = date("h:i", $timestamp);			
			$isRead = ($message['isRead'] == 0) ? false : true;			
			$image = ($userId == $message['fromUser']) ? $userImage : $contactImage;
			$username = ($userId == $message['fromUser']) ? $userNickName : $contactNickName; 
				
			$result[] = array(
				"id" => $message['messageId'],
				"from" => $message['fromUser'],
				"username" => $username,					
				"text" => urldecode($message['message']),
				"dateTime" => $date . ' ' . $time,
				"userImage" => $image,
				"isRead" => $isRead,
			);
			
			if($message['fromUser'] == $contactId and $message['isDelivered'] == 0){		
				$this->setMessageAsDelivered($message['messageId']);   
			}			
			
		}
		
		return $result;
	}	
	
}

?>