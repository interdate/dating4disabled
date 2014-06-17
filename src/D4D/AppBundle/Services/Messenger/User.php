<?php 

namespace D4D\AppBundle\Services\Messenger;

class User extends Messenger{
	
	protected $id;
	protected $image;
	protected $nickName;
	protected $gender;
		
	public function __construct($id){
		parent::__construct();
		$this->id = $id;
		$this->setGender();				
		$this->setNickName();
		$this->setImage();
	}
	
	public function getId(){
		return $this->id;
	}
	
	public function getImage(){
		return $this->image;
	}
	
	public function getNickName(){
		return $this->nickName;
	}	
	
	public function setImage(){
		$sql = "SELECT imgId FROM images WHERE userId=:userId AND imgMain = 1 AND imgValidated = 1" ;
		$stmt = $this->db->prepare($sql);
		$stmt->bindParam("userId",$this->id);
		$stmt->execute();
		$row = $stmt->fetch();
		if(!empty ( $row['imgId'] )){
			$this->image = $this->config->users->storage->images . '/' . $row['imgId'] . '.jpg';
		}
		else{
			$this->image = ($this->gender == 0) ?  $this->config->users->noImage->male : $this->config->users->noImage->female;
		}
		
	}	
	
	public function setNickName(){
		$sql = "SELECT userNic FROM users WHERE userId=:userId" ;
		$stmt = $this->db->prepare($sql);
		$stmt->bindParam("userId",$this->id, \PDO::PARAM_INT);
		$stmt->execute();
		$row = $stmt->fetch();
		$this->nickName = (!empty ( $row['userNic'] ) ) ? $row['userNic'] : false;
	}
	
	public function setGender(){
		$sql = "SELECT userGender FROM users WHERE userId=:userId" ;
		$stmt = $this->db->prepare($sql);
		$stmt->bindParam("userId",$this->id, \PDO::PARAM_INT);
		$stmt->execute();
		$row = $stmt->fetch();
		$this->gender = $row['userGender'];
	}

	public function isOnline(){
		$sql = "
			SELECT				
				" . $this->config->users->dbFunc->isOnline . " as isOnline
			FROM
				users
			WHERE
				userId = :userId";
				   
		$stmt = $this->db->prepare($sql);
		$stmt->bindParam("userId", $this->id);
		$stmt->execute();
		$user = $stmt->fetch();
		return ($user['isOnline'] == 1) ? true : false;     
		//return $user['isOnline'];
	}
	
}

?>