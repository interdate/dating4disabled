<?php 

namespace D4D\AppBundle\Services\Messenger;

use Symfony\Component\HttpFoundation\JsonResponse;

class Messenger{ 
	
	public $db;
	public $config;
	public $isNewMessage = false;
	
	public function __construct(){
		$this->config = Config::getInstance();
		$this->config = $this->arrayToObject($this->config);
		$this->db = Database::getInstance($this->config->database);
		//$this->db = $db;
		//date_default_timezone_set('Asia/Jerusalem');
	}
	
	public function response($array) {
		return new JsonResponse($array);
	}
	
	public function arrayToObject($array){
		$json = json_encode($array);
		return json_decode($json);
	}
	
	public function isNewMessage(){
		return $this->isNewMessage;		
	}
	
	public function openChat($options){
		$userAttributes = new userAttributes();
		
		$chatSession = $userAttributes->get($this->config->messengerSession, array($options['userId'], $options['contactId']));
		if(count($chatSession) == 0){
			$userAttributes->post($this->config->messengerSession, array($options['userId'], $options['contactId']));
			return true;
		}
		 
		return false;
	}
	
	public function closeChat($options){		
		$sql = "DELETE FROM " . $this->config->messengerSession->table . " WHERE userId = ? AND contactId = ?";
		$stmt = $this->db->prepare($sql);
		$stmt->bindParam(1, $options['userId'], \PDO::PARAM_INT);
		$stmt->bindParam(2, $options['contactId'], \PDO::PARAM_INT);
		$success = ($stmt->execute()) ? true : false;
		return $this->response(array('success' => $success));		
	}
	
	public function getActiveChats($options){   
		$userAttributes = new userAttributes();
		$activeChats = array();
		
		$sql = "
			SELECT
				s.contactId, u.userNic FROM " . $this->config->messengerSession->table . " s
			JOIN
				" . $this->config->users->table . " u
			ON
				( s.contactId = u.userId)
			WHERE
				s.userId = ?";
		
		$stmt = $this->db->prepare($sql);
		$stmt->bindParam(1, $options['userId'], \PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetchAll();
		
		foreach ($result as $row){
			
			$activeChats[] = array(
				'id' => $row['contactId'],
				'name' => $row['userNic'] 	
			); 
			
		}
		
		return $activeChats;
	}
		
	public function checkActiveChatsNewMessages($options){
		$result = array();
		$dateTime = array();
		$userAttributes = new userAttributes();		
		
		$allChats = $userAttributes->get($this->config->messengerSession, array($options['userId']));		
		$startTime = time();
		while(time() - $startTime < 10) {
			
			foreach ($allChats as $chatOptions){
				$chat = new Chat($chatOptions);
				$newMessages = $chat->getNewMessages();
				
				if(count($newMessages) > 0){			
					foreach ($newMessages as $message){
						$this->isNewMessage = true;						
						$messageDateObject = new \DateTime($message['date']);
						$timestamp = $messageDateObject->getTimestamp();
						$date = date("d/m/Y", $timestamp);
						$time = date("h:i", $timestamp);
						
						$result[] = array(
							"id" => $message['messageId'],
							"from" => $chat->contact()->getId(),						
							"text" => urldecode($message['message']),  								
							"dateTime" => $date . ' ' . $time, 
							"userImage" => $chat->contact()->getImage(),
							"userName" => $chat->contact()->getNickName()
						);

						
					}
				}	
			}
			
			if($this->isNewMessage()){
				$timestamp = time();
				$time = date("i:s", $timestamp);
				$dateTime[] = $time;
				
				foreach($result as $message){
					$chat->setMessageAsDelivered($message['id']);
				}
								
				//return $this->response(array("newMessages" => $result, "MinSec" => $dateTime));
				//exit(0);
				return array("newMessages" => $result, "MinSec" => $dateTime);
								
			}
		
			usleep(500);  
		} 
		   
		$timestamp = time();
		$time = date("i:s", $timestamp);
		$dateTime[] = $time;
		//return $this->response(array("newMessages" => $result, "MinSec" => $dateTime));
		return array("newMessages" => $result, "MinSec" => $dateTime);
	}	
	
	
	public function checkNewMessages($options){
		
		$users = array();
		
		$sql = "
			SELECT 
				m.fromUser, m.message, m.isRead, m.isDelivered, u.userNic FROM " . $this->config->messenger->table . " m
			JOIN 					 
				" . $this->config->users->table . " u 
			ON
				( m.fromUser = u.userId)					
			WHERE 
				m.toUser = ? AND m.isDelivered = 0 AND m.isRead = 0";
		
		$stmt = $this->db->prepare($sql);
		$stmt->bindParam(1, $options['userId'], \PDO::PARAM_INT);		
		$stmt->execute();
		$result = $stmt->fetchAll();
		
		foreach ($result as $row){
			
			$user = array(
				"id" => $row['fromUser'], 
				"name" => $row['userNic'],
				"isDelivered" => $row['isDelivered'],
				"isRead" => $row['isRead'],
				"text"=> urldecode($row['message']) 	
			);
			
			if(!in_array($user, $users)){
				$users[] = $user;
			}	
		}
				
		return $this->response(array("fromUsers" => $users));
	}
	
	public function checkDialogNewMessages($options){
		$result = array();
		$dateTime = array();
		$startTime = time();
		
		while(time() - $startTime < 10) {
			
			$dialog = new Dialog($options);
			$newMessages = $dialog->getNewMessages();
			
			//return $this->response(array("newMessages" => $newMessages, "MinSec" => $dateTime));
			//die();
		
			if(count($newMessages) > 0){
				foreach ($newMessages as $message){
					$this->isNewMessage = true;
					$messageDateObject = new \DateTime($message['date']);
					$timestamp = $messageDateObject->getTimestamp();
					$date = date("d.m.Y", $timestamp);
					$time = date("h:i", $timestamp);
		
					$result[] = array(
						"id" => $message['messageId'],
						"from" => $dialog->contact()->getId(),
						"text" => urldecode($message['message']),
						"dateTime" => $date . ' ' . $time,
						"userImage" => $dialog->contact()->getImage(),
						"userName" => $dialog->contact()->getNickName()
					);
				}
			}			
				
			if($this->isNewMessage()){
				$timestamp = time();
				$time = date("i:s", $timestamp);
				$dateTime[] = $time;
		
				foreach($result as $message){
					$dialog->setMessageAsDelivered($message['id']);
				}
				
				//return $this->response(array("newMessages" => $result, "MinSec" => $dateTime));
				//exit(0);
				return array("newMessages" => $result, "MinSec" => $dateTime);
			}
		
			usleep(500);
		}
		 
		$timestamp = time();
		$time = date("i:s", $timestamp);
		$dateTime[] = $time;
		//return $this->response(array("newMessages" => $result, "MinSec" => $dateTime));
		return array("newMessages" => $result, "MinSec" => $dateTime);
	}
	
}
