<?php 

namespace D4D\AppBundle\Services\Messenger;

class Chat extends Messenger{
	
	public $user;	
	public $contact;
	private $message;
	
	public function __construct($options){	
		parent::__construct();
		$this->user = (!empty($options['userId'])) ? new User($options['userId']) : null;
		$this->contact = (!empty($options['contactId'])) ? new User($options['contactId']) : null;
		$this->message = (isset($options['message']) and mb_strlen(trim($options['message'])) > 0) ? new Message($options) : false;		 						
	}
	
	public function getNewMessages(){		
		$sql = "SELECT 
					messageId,message,date 
				FROM 
					" . $this->config->messenger->table . " 
				WHERE 
					toUser = ? AND fromUser = ? AND isDelivered = 0 AND isRead = 0";
		
		//echo $this->contact->getId() . '<h1>5678789789789sfg srgtrs stsr tsrtrst srtsr</h1>';
		//die;
		$userId = $this->user->getId();
		$contactId = $this->contact->getId();
		$stmt = $this->db->prepare($sql);
		$stmt->bindParam(1, $userId, \PDO::PARAM_INT);
		$stmt->bindParam(2, $contactId, \PDO::PARAM_INT);
		$stmt->execute();		
		$result = $stmt->fetchAll();
		return $result;		
	}
	
	public function setMessageAsDelivered($messageId){		
		$userAttributes = new userAttributes();
		$userSession = $userAttributes->get($this->config->messengerSession, array($this->user->getId(), $this->contact->getId()));
		if(count($userSession) == 0){
			return false;
		}
				
		$sql = "UPDATE " . $this->config->messenger->table . " SET isDelivered = 1, modified = ? WHERE messageId = ?";
		$stmt = $this->db->prepare($sql);		
		$modified = date("Y-m-d h:i:s");		
		$stmt->bindParam(1, $modified, \PDO::PARAM_INT);
		$stmt->bindParam(2, $messageId, \PDO::PARAM_INT);
		$stmt->execute();		
	}
	
	public function setMessageAsRead($messageId){
		$sql = "UPDATE " . $this->config->messenger->table . " SET isRead = 1 WHERE messageId = ? AND toUser = ? AND fromUser = ? AND isRead = 0";
		$stmt = $this->db->prepare($sql);
		$userId = $this->user->getId();
		$contactId = $this->contact->getId();
		$stmt->bindParam(1, $messageId, \PDO::PARAM_INT);
		$stmt->bindParam(2, $userId, \PDO::PARAM_INT);
		$stmt->bindParam(3, $contactId, \PDO::PARAM_INT);		
		if($stmt->execute())
			return true;
		
		return false;
	}
	
	public function contact(){
		return $this->contact;		
	}
	
	public function user(){
		return $this->user;		
	}
	
	public function sendMessage(){

		if($this->message){
		
			$userAttributes = new userAttributes();
			$userAttributes->post($this->config->messenger,
				array(					
					$this->message->from, 
					$this->message->to,
					//iconv("windows-1255", "utf-8", $this->message->text), 
					$this->message->text,
					$this->message->date,
					$this->message->isRead,
					$this->message->isDelivered,
					//null,
				)
			);
			
			$messageDateObject = new \DateTime($this->message->date);
			$timestamp = $messageDateObject->getTimestamp();
			$date = date("d/m/Y", $timestamp);
			$time = date("h:i", $timestamp);
			
			return array(
				"id" => $userAttributes->getLastId(),	
				"from" => $this->message->from,
				"to" => $this->message->to,
				"text" => $this->message->text,
				"dateTime" => $date . " " . $time,
				"contactIsOnline" => $this->contact->isOnline()				
			);
		
		}
		else return false; 
		
		
	}
	
	public function getHistory(){
		
		$userId = $this->user->getId();
		$contactId = $this->contact->getId();
		$userImage = $this->user->getImage();
		$contactImage = $this->contact->getImage();
		$result = array();
		
		$sql = "SELECT TOP 30 
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
			$date = date("d/m/Y", $timestamp);
			$time = date("h:i", $timestamp);			
			$isRead = ($message['isRead'] == 0) ? false : true;			
			$image = ($userId == $message['fromUser']) ? $userImage : $contactImage;
				
			$result[] = array(
					"id" => $message['messageId'],
					"from" => $message['fromUser'],					
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