<?php

namespace D4D\AppBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


use D4D\AppBundle\Entity\Users;
use D4D\AppBundle\Entity\Images;

use D4D\AppBundle\Services\Messenger\Chat;

/*
use D4D\AppBundle\Services\Messenger\IniStructure;
use D4D\AppBundle\Services\Messenger\Config;
use D4D\AppBundle\Services\Messenger\Messenger;
use D4D\AppBundle\Services\Messenger\User;
use D4D\AppBundle\Services\Messenger\Chat;
use D4D\AppBundle\Services\Messenger\Message;
use D4D\AppBundle\Services\Messenger\UserAttributes;
*/


class MessengerController extends Controller{
	 
	public function openChatAction($userId, $contactId){
		$options['userId'] = $userId;
		$options['contactId'] = $contactId;
		
		$messenger = $this->get('messenger');		
		$openChat = $messenger->openChat($options);
		$chat = new Chat($options);
		$chatHistory = $chat->getHistory();		
		
		return $messenger->response(array("success" => $openChat, "chatHistory" => $chatHistory));
	}
	
	public function closeChatAction($userId, $contactId){
		$options['userId'] = $userId;
		$options['contactId'] = $contactId;		
		
		$messenger = $this->get('messenger');	
		return $messenger->closeChat($options);		
	}
	
	public function activeChatsAction($userId){
		$options['userId'] = $userId;				
		$messenger = $this->get('messenger');
		
		return $messenger->response(array("activeChats" => $messenger->getActiveChats($options)));
	}
	
	public function activeChatsNewMessagesAction($userId){
		$options['userId'] = $userId;				
		$messenger = $this->get('messenger');
		
		return $messenger->checkActiveChatsNewMessages($options);
	}
	
	public function newMessagesAction($userId){
		$options['userId'] = $userId;
		$messenger = $this->get('messenger');
		return $messenger->checkNewMessages($options);
	}
	
	public function sendMessageAction(Request $request, $userId, $contactId){
		$message = $request->request->get('message');				
		$options['message'] = strip_tags($message);
		$options['message'] = urlencode($message);
		$options['userId'] = $userId;
		$options['contactId'] = $contactId;		
		
		$chat = new Chat($options);
		$messageObj = $chat->sendMessage();
		
		if($messageObj)
			return $chat->response(array('success' => true, 'message' => $messageObj));
		else
			return $chat->response(array('success' => false));
	}
	
	public function readMessageAction($messageId, $userId, $contactId){
		$options['userId'] = $userId;
		$options['contactId'] = $contactId;
		
		$chat = new Chat($options);
		$result = $chat->setMessageAsRead($messageId);
		return $chat->response(array('success' => $result));
	}
		
}
