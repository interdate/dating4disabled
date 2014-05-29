<?php 

namespace D4D\AppBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\Tools\Pagination\Paginator;

class UsersRepository extends EntityRepository implements UserProviderInterface
{	
	protected $filter;
	
	protected $connection; 

	public function setFilter($filter){		
		if($filter)
			$this->filter = $filter;
	}
	
	public function getFilter(){
		return $this->filter;
	}
	
	public function loadUserByUsername($username){
		$q = $this
		->createQueryBuilder('u')
		->where('u.username = :username')		
		->setParameter('username', $username)
		->getQuery()
		;

		try {
			// The Query::getSingleResult() method throws an exception
			// if there is no record matching the criteria.
			$user = $q->getSingleResult();
		} catch (NoResultException $e) {
			$message = sprintf(
					'Unable to find an active admin D4DAppBundle:Users object identified by "%s".',
					$username
			);
			throw new UsernameNotFoundException($message, 0, $e);
		}

		return $user;
	}

	public function refreshUser(UserInterface $user){
		$class = get_class($user);
		if (!$this->supportsClass($class)) {
			throw new UnsupportedUserException(
				sprintf(
					'Instances of "%s" are not supported.',
					$class
				)
			);
		}

		return $this->find($user->getUserId());
	}

	public function supportsClass($class){
		return $this->getEntityName() === $class
		|| is_subclass_of($class, $this->getEntityName());
	}
	
	
	public function findCustomersByName($name){
		$query = $this->createQueryBuilder('c')
			->where('c.firstName LIKE :firstName')
			->orWhere('c.lastName LIKE :lastName')
			->setParameter('firstName', '%' . $name . '%')
			->setParameter('lastName', '%' . $name . '%')
			->getQuery();
		
		return $query->getResult();
	} 

	public function getUsers($paginator, $page, $geoip){		
		$users = array();
		$this->connection = $this->getEntityManager()->getConnection();
		$dql = $this->getDQL();
		$query = $this->getEntityManager()->createQuery($dql);
		$users['items'] = $paginator->paginate($query, $page, 20);
		$users['itemsNumber'] = $users['items']->getTotalItemCount();
		foreach ($users['items'] as $user){
			$this->completeUser($user, $geoip);
		}		
		return $users;		
	}
	
	public function getStatistics(){		
		$sql = "EXEC admin_users_simpleStats";		
		$this->connection = $this->getEntityManager()->getConnection();
		$stmt = $this->connection->query($sql);
		$stmt->execute();
		
		$result = $stmt->fetchAll();
		$statistics['reports'] = $result[0];
				
		$stmt->nextRowset();		
		$result = $stmt->fetchAll();
		$statistics['filters'] = $result[0];
		
		return $statistics;
	}
	
	public function completeUser($user, $geoip){
		$geoip->lookup($user->getUserip());
		
		$country = array(
			'code' => $geoip->getCountryCode(),
			'name' => $geoip->getCountryName(),
			//'city' => $geoip->getCity(),
		);
		
		$user->setCountry($country);
		
		/*
		$sql = "SELECT userId FROM users WHERE userId = '" . $user->getUserid() . "' AND dbo.isUserPaing(userPrePaidPoints,userPaidStartDate,userPaidEndDate,getdate()) = 1";
		$stmt = $this->connection->query($sql);
		$stmt->execute();
		$user->setUserPaying(count($stmt->fetchAll()));
		*/		
		$user->setUserPaying(1);
		
		/*
		$date = new \DateTime();
		$date = $date->format("Y-m-d h:i:s");
		
		$sql = "SELECT dbo.getAge(u.userBirthday, GETDATE()) as age FROM users u WHERE userId = '" . $user->getUserid() . "'";
		$stmt = $this->connection->query($sql);
		$stmt->execute();
		$result = $stmt->fetch();
		$user->setAge($result['age']);
		*/
		$user->setAge(1);
		
		return $user;
	}
	
	public function getDQL(){
		
		switch ($this->filter){
			case 'total':
				$dql   = "SELECT u FROM D4DAppBundle:Users u";
				break;
		
			case 'male':
				$dql   = "SELECT u FROM D4DAppBundle:Users u WHERE u.usergender = 0";
				break;
		
			case 'female':
				$dql   = "SELECT u FROM D4DAppBundle:Users u WHERE u.usergender = 1";
				break;
				
			case 'flagged':
				$dql   = "SELECT u FROM D4DAppBundle:Users u WHERE u.useradminmarked = 1";
				break;
				
			case 'withPhotos':
				$dql   = "SELECT u FROM D4DAppBundle:Users u WHERE  u.userid IN (SELECT DISTINCT IDENTITY(i.userid) FROM D4DAppBundle:Images i)";
				break;
				
			case 'inactive':
				$dql   = "SELECT u FROM D4DAppBundle:Users u WHERE u.usernotactivated = 1 OR u.userfrozen = 1 OR u.userblocked = 1 OR u.usernotapproved = 1";
				break;
					
			case 'notCompletedRegistration':
				$dql   = "SELECT u FROM D4DAppBundle:Users u WHERE u.usernotcomlitedregistration = 1";				
				break;
				
			case 'notActivated':
				$dql   = "SELECT u FROM D4DAppBundle:Users u WHERE u.usernotactivated = 1";
				break;
				
			case 'notApproved':
				$dql   = "SELECT u FROM D4DAppBundle:Users u WHERE u.usernotapproved = 1";
				break;
				
			case 'frozen':
				$dql   = "SELECT u FROM D4DAppBundle:Users u WHERE u.userfrozen = 1";
				break;
				
			case 'blocked':
				$dql   = "SELECT u FROM D4DAppBundle:Users u WHERE u.userblocked = 1";
				break;
				
			case 'paying':
				$date = new \DateTime();
				$date = $date->format("Y-m-d h:i:s");
				$dql = "
					SELECT u 
						FROM D4DAppBundle:Users u 
						WHERE
							(u.userprepaidpoints  > 0 AND u.userpaidstartdate > '" . $date . "')
						OR 
							(u.userprepaidpoints > 0 AND u.userpaidstartdate <= '" . $date . "' AND u.userpaidstartdate >= '"  . $date . "')					
						OR
							(u.userpaidstartdate <= '" . $date . "' AND u.userpaidenddate >= '" . $date . "')												
									
				";
				
				//@prePaidPoints>0 and @paidStartDate>@date and @paidStartDate<=@paidEndDate
				//$sql = "SELECT u.userId, u.userNic, dbo.ifUserPaing(u.userPrePaidPoints, u.userPaidStartDate, u.userPaidEndDate, GETDATE()) as PAYING FROM users u";
				
				break;
		}
		
		return $dql;
	}

	public function execute($action, $usersIds){
		
		if(!$action or !$usersIds)
			return false;
		
		$usersIdsString = implode(",", $usersIds);
		$this->connection = $this->getEntityManager()->getConnection();
		
		if($action == 'delete' or $action == 'blockAndDelete'){
			$blockAndDelete = ($action == 'blockAndDelete') ? 1 : 0;			
			$sql = "EXEC admin_users_de_all ?,?";			
			$stmt = $this->connection->prepare($sql);
			$stmt->bindParam(1, $usersIdsString);
			$stmt->bindParam(2, $blockAndDelete);
		}
		else{			
			$actionArr = explode("_", $action);
			$field = $actionArr[0];
			$value = $actionArr[1];			
			$pageName = null;			
			$sql = "EXEC admin_users_setBitStatus ?,?,?,?";			
			$stmt = $this->connection->prepare($sql);
			$stmt->bindParam(1, $usersIdsString);
			$stmt->bindParam(2, $field);
			$stmt->bindParam(3, $value);
			$stmt->bindParam(4, $pageName);
		}
		
		$stmt->execute();
	}	
	
	
	public function search($data, $page, $geoip){
	
		$sql = "EXEC admin_users_search_sa ";
	
		$userid = (!empty($data['userid'])) ? $data['userid'] : 'null';
		$data['maritalstatusid'] = (isset($data['maritalstatusid'])) ? "'" . implode(",", $data['maritalstatusid']) . "'" : 'null';
		$data['languageid'] = (isset($data['languageid'])) ? "'" . implode(",", $data['languageid']) . "'" : 'null';
		$data['ethnicoriginid'] = (isset($data['ethnicoriginid'])) ? "'" . implode(",", $data['ethnicoriginid']) . "'" : 'null';
	
		//$data['ethnicoriginid'] = (isset($data['ethnicoriginid'])) ? "'" . implode(",", $data['sexprefid']) . "'" : 'null';
	
		$data['religionid'] = (isset($data['religionid'])) ? "'" . implode(",", $data['religionid']) . "'" : 'null';
		$data['educationid'] = (isset($data['educationid'])) ? "'" . implode(",", $data['educationid']) . "'" : 'null';
		$data['occupationid'] = (isset($data['occupationid'])) ? "'" . implode(",", $data['occupationid']) . "'" : 'null';
		$data['incomeid'] = (isset($data['incomeid'])) ? "'" . implode(",", $data['incomeid']) . "'" : 'null';
		$data['healthid'] = (isset($data['healthid'])) ? "'" . implode(",", $data['healthid']) . "'" : 'null';
		$data['mobilityid'] = (isset($data['mobilityid'])) ? "'" . implode(",", $data['mobilityid']) . "'" : 'null';
		$data['lookingforid'] = (isset($data['lookingforid'])) ? "'" . implode(",", $data['lookingforid']) . "'" : 'null';
		$data['smokingid'] = (isset($data['smokingid'])) ? "'" . implode(",", $data['smokingid']) . "'" : 'null';
		$data['drinkingid'] = (isset($data['drinkingid'])) ? "'" . implode(",", $data['drinkingid']) . "'" : 'null';
		$data['appearanceid'] = (isset($data['appearanceid'])) ? "'" . implode(",", $data['appearanceid']) . "'" : 'null';
		$data['bodytypeid'] = (isset($data['bodytypeid'])) ? "'" . implode(",", $data['bodytypeid']) . "'" : 'null';
		$data['hairlengthid'] = (isset($data['hairlengthid'])) ? "'" . implode(",", $data['hairlengthid']) . "'" : 'null';
		$data['haircolorid'] = (isset($data['haircolorid'])) ? "'" . implode(",", $data['haircolorid']) . "'" : 'null';
		$data['eyescolorid'] = (isset($data['eyescolorid'])) ? "'" . implode(",", $data['eyescolorid']) . "'" : 'null';
	
		$data['characteristicid'] = (isset($data['characteristicid'])) ? implode(",", $data['characteristicid']) : 'null';
		$data['hobbyid'] = (isset($data['hobbyid'])) ? "'" . implode(",", $data['hobbyid']) . "'" : 'null';
		$data['sexprefid'] = (isset($data['sexprefid'])) ? "'" . implode(",", $data['sexprefid']) . "'" : 'null';
	
	
		$data['paymentStartDateFrom'] = (!empty($data['paymentStartDateFrom'])) ? "'" . $data['paymentStartDateFrom'] . "'" : 'null';
		$data['paymentStartDateTo'] = (!empty($data['paymentStartDateTo'])) ? "'" . $data['paymentStartDateTo'] . "'" : 'null';
		$data['paymentEndDateFrom'] = (!empty($data['paymentEndDateFrom'])) ? "'" . $data['paymentEndDateFrom'] . "'" : 'null';
		$data['paymentEndDateTo'] = (!empty($data['paymentEndDateTo'])) ? "'" . $data['paymentEndDateTo'] . "'" : 'null';
		$data['registrationDateFrom'] = (!empty($data['registrationDateFrom'])) ? "'" . $data['registrationDateFrom'] . "'" : 'null';
		$data['registrationDateTo'] = (!empty($data['registrationDateTo'])) ? "'" . $data['registrationDateTo'] . "'" : 'null';
		$data['lastVisitDateFrom'] = (!empty($data['lastVisitDateFrom'])) ? "'" . $data['lastVisitDateFrom'] . "'" : 'null';
		$data['lastVisitDateTo'] = (!empty($data['lastVisitDateTo'])) ? "'" . $data['lastVisitDateTo'] . "'" : 'null';
	
	
		$data['useremail'] = (!empty($data['useremail'])) ? "'" . $data['useremail'] . "'" : 'null';
		$data['usernic'] = (!empty($data['usernic'])) ? "'" . $data['usernic'] . "'" : 'null';
		$data['userfname'] = (!empty($data['userfname'])) ? "'" . $data['userfname'] . "'" : 'null';
		$data['userlname'] = (!empty($data['userlname'])) ? "'" . $data['userlname'] . "'" : 'null';
	
		$data['userBirthdayFrom'] = (!empty($data['userBirthdayFrom'])) ? "'" . $data['userBirthdayFrom'] . "'" : 'null';
		$data['userBirthdayTo'] = (!empty($data['userBirthdayTo'])) ? "'" . $data['userBirthdayTo'] . "'" : 'null';
	
	
		$data['countrycode'] = ($data['countrycode'] != '--' ) ? "'" . $data['countrycode'] . "'" : 'null';
		$data = str_replace('_null', 'null', $data);
		
		$data['withPhotos'] = (isset($data['withPhotos'])) ? "'" . $data['withPhotos'] . "'" : 'null';
		
	
		$sql .=  $userid . ",";
		$sql .=  $data['usernotactivated'] . ",";
		$sql .=  $data['usernotcomlitedregistration'] . ",";
		$sql .=  $data['usernotapproved'] . ",";
		$sql .=  $data['userfrozen'] . ",";
		$sql .=  $data['userblocked'] . ","; //
		$sql .=  "null" . ","; // front page list
		$sql .=  $data['withPhotos'] . ","; // show only images
		$sql .=  $data['userPaying'] . ","; // paing
		$sql .=  "null" . ","; // prepaid points
		$sql .=  $data['paymentStartDateFrom'] . ","; // paid start 1
		$sql .=  $data['paymentStartDateTo'] . ","; // paid start 2
		$sql .=  $data['paymentEndDateFrom'] . ","; // paid end 1
		$sql .=  $data['paymentEndDateTo'] . ","; // paid end 2
		$sql .=  $data['registrationDateFrom'] . ","; // Reg date 1
		$sql .=  $data['registrationDateTo'] . ","; // Reg date 2
		$sql .=  $data['lastVisitDateFrom'] . ","; // Last Visit 1
		$sql .=  $data['lastVisitDateTo'] . ","; // Last Visit 2
		$sql .=  $data['userBirthdayFrom'] . ","; // Birthday 1
		$sql .=  $data['userBirthdayTo'] . ","; // Birthday 2
		$sql .=  $data['useremail'] . ",";
		$sql .=  $data['usernic'] . ",";
				$sql .=  $data['userfname'] . ",";
				$sql .=  $data['userlname'] . ",";
				$sql .=  $data['usergender'] . ",";
				$sql .=  "null" . ","; //Age1
		$sql .=  "null" . ","; //Age2
		$sql .=  $data['maritalstatusid'] . ",";
		$sql .=  $data['children'] . ","; //Children
		$sql .=  "null" . ","; // Origin country
		$sql .=  $data['languageid'] . ","; // Languages
		$sql .=  $data['ethnicoriginid'] . ","; //Ethnic
		$sql .=  $data['religionid'] . ","; //Religion
		$sql .=  $data['educationid'] . ","; //Education
		$sql .=  $data['occupationid'] . ","; //Occupation
		$sql .=  $data['incomeid'] . ","; //Income
		$sql .=  $data['healthid'] . ","; //Health
		$sql .=  $data['mobilityid'] . ","; //Mobility
		$sql .=  $data['lookingforid'] . ","; // Looking For
				$sql .=  $data['smokingid'] . ","; // Smoking
				$sql .=  $data['drinkingid'] . ","; // Drinking
				$sql .=  $data['appearanceid'] . ","; // Appearance
						$sql .=  "null" . ","; // Hight 1
						$sql .=  "null" . ","; // Hight 2
	
						$sql .=  "null" . ","; // Weight 1
						$sql .=  "null" . ","; // Weight 2
						$sql .=  $data['bodytypeid'] . ","; // Body Type
						$sql .=  $data['hairlengthid'] . ","; // Hair Length
						$sql .=  $data['haircolorid'] . ","; // Hair Color
						$sql .=  $data['eyescolorid'] . ","; // Eyes Color
						$sql .=  $data['characteristicid'] . ","; // Characteristic
						$sql .=  $data['hobbyid'] . ","; // Hobbies
						$sql .=  $data['sexprefid'] . ","; // Sex Pref
						$sql .=  "null" . ","; // User IP
	
						$sql .=  "null" . ","; // Affiliate Id
						$sql .=  $data['countrycode'] . ","; // Country Code
		$sql .=  "null" . ","; // Region Code
		$sql .=  "null" . ","; // City Name
		$sql .=  "null" . ","; // longitude_1
		$sql .=  "null" . ","; // latitude_1
		$sql .=  "null" . ","; // latitude_h
		$sql .=  "null" . ","; // longitude_h
			$sql .=  20 . ","; // Per Page
			$sql .=  $page . ","; // page
	
		$sql .= ' "AND" ';
	
				
			$this->connection = $this->getEntityManager()->getConnection();
			$stmt = $this->connection->query($sql);
			$stmt->execute();
	
			//$users = array();
			$users['itemsNumber'] = 0;
			$users['items'] = array();
	
			$result = $stmt->fetchAll();
	
			$users['itemsNumber'] = $result[0][""];
				
			$stmt->nextRowset();
	
			$result = $stmt->fetchAll();
	
			if(count($result)){
				foreach ($result as $row){
					$user = $this->find($row['userId']);
					$users['items'][] = $this->completeUser($user, $geoip);
				}
			}
	
			return $users;
	}
	
	public function test(){
		$sql = "EXEC admin_users_search_sa ";
		
		for ($i = 0; $i < 65; $i++){
			if($i == 62)
				$sql .= '20';
			
			elseif($i == 63)
				$sql .= '1';
			elseif($i == 64)
				$sql .= ' "AND" ';
			else
				$sql .= 'null';
				
			if($i < 64)
				$sql .= ",";
		}		
		
		echo $sql . '<br />';
		
		$this->connection = $this->getEntityManager()->getConnection();		
		$stmt = $this->connection->query($sql);
		$stmt->execute();
		
		$i = 0;
		
		do {
			$rowset = $stmt->fetchAll();
			//var_dump($rowset);			
			if($i == 1){
				return $rowset;
				
				foreach( $rowset as $row){
					//$user = new Users($row['userId']);
					$user = $this->find($row['userId']);
					$users[] = $user;
				}				
				return $users;				
			}				
			$i++; 
		} while ($stmt->nextRowset());
	}
        
        public function pay(){
               $sql = "EXEC admin_user_pay_ss ";
               $sql .= '23334,';
               for ($i = 0; $i < 7; $i++){
                               $sql .= 'null';                               
                       if($i < 6)
                               $sql .= ",";
               }                
               
               echo $sql . '<br />';
               
               
               $this->connection = $this->getEntityManager()->getConnection();                
               $stmt = $this->connection->query($sql);
//               $this->connection->prepare("SELECT @userPrePaidPoints");
               //var_dump();
//               $stmt->prepare("SELECT @userPrePaidPoints");
               //$this->connection->prepare("SELECT @userPrePaidPoints");
               $stmt->execute();
//               $this->connection->query("SELECT	@userPrePaidPoints as N'Points',
//                                                @userPaidStartDate_m as N'PaidStartDate_m',
//                                                @userPaidStartDate_d as N'PaidStartDate_d',
//                                                @userPaidStartDate_y as N'PaidStartDate_y',
//                                                @userPaidEndDate_m as N'PaidEndDate_m',
//                                                @userPaidEndDate_d as N'PaidEndDate_d',
//                                                @userPaidEndDate_y as N'PaidEndDate_y'");
               var_dump($stmt->fetchAll());
               
               //$rowset = $stmt->fetchColumn();
               $stmt->nextRowset();
               //$this->connection->query("SELECT @userPrePaidPoints");
               //var_dump($this->connection->query("SELECT @userPrePaidPoints"));
               $rowset = $stmt->fetchAll();               
               var_dump($rowset); 

               $i = 0;               
//               do {
//                       //$rowset = $stmt->fetchAll();
//                       var_dump($rowset);                        
////                       if($i == 1){
////                               return $rowset;
////                               
////                               foreach( $rowset as $row){
////                                       //$user = new Users($row['userId']);
////                                       $user = $this->find($row['userId']);
////                                       $users[] = $user;
////                               }                                
////                               return $users;                                
////                       }                                
//                       $i++; 
//               } while ($stmt->nextRowset());
       }
	

}









