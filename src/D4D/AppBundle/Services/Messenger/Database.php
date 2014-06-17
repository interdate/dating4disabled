<?php 

namespace D4D\AppBundle\Services\Messenger;

class Database {
	
	private static $instance;
		
	private function __construct(){}
	
	public static function getInstance($dbConfig = false){
		if(empty( self::$instance )){			
			self::$instance = new \PDO("dblib:host=" . $dbConfig->server . ";port=1433;dbname=" . $dbConfig->name,$dbConfig->user,$dbConfig->password); 
			self::$instance->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);			
		}		
		return self::$instance;
	}
	
	
}