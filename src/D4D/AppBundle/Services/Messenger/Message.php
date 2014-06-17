<?php

namespace D4D\AppBundle\Services\Messenger;

class Message{
	
	public $text;
	public $date;
	public $from;
	public $to;
	public $isRead;
	
	public function __construct($options){
		$this->to = $options['contactId'];
		$this->from = $options['userId'];		
		$this->text = $options['message'];
		$this->date = date("Y-m-d h:i:s");		
		$this->isRead = 0;
		$this->isDelivered = 0;
	}
	
}

?>