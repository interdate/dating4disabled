<?php 

namespace D4D\AppBundle\Services\Messenger;

class Config {
	
	private static $instance;
		
	private function __construct(){}
	
	public static function getInstance(){
		if(empty( self::$instance )){			
			self::$instance = IniStructure::parse('config.ini', true);
		}		
		return self::$instance;
	}	
}