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

	public function setFilter($filter){		
		if($filter)
			$this->filter = $filter;
	}
	
	public function getFilter(){
		return $this->filter;
	}
	
	public function loadUserByUsername($username)
	{
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

	public function refreshUser(UserInterface $user)
	{
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

	public function supportsClass($class)
	{
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
		$dql = $this->getDQL();	
		$query = $this->getEntityManager()->createQuery($dql);
		$users = $paginator->paginate($query, $page, 20);		
		$conn = $this->getEntityManager()->getConnection();				
		
		foreach ($users as $user){			
			$geoip->lookup($user->getUserip());
			
			$country = array( 
				'code' => $geoip->getCountryCode(),
				'name' => $geoip->getCountryName(),
				//'city' => $geoip->getCity(),
			);
			
			$user->setCountry($country);
			
			$sql = "SELECT userId FROM users WHERE userId = '" . $user->getUserid() . "' AND dbo.isUserPaing(userPrePaidPoints,userPaidStartDate,userPaidEndDate,getdate()) = 1";			
			$stmt = $conn->query($sql);
			$stmt->execute();			
			$user->setUserPaying(count($stmt->fetchAll()));
			
			$date = new \DateTime();
			$date = $date->format("Y-m-d h:i:s");
			
			$sql = "SELECT dbo.getAge(u.userBirthday, GETDATE()) as age FROM users u WHERE userId = '" . $user->getUserid() . "'";
			$stmt = $conn->query($sql);
			$stmt->execute();
			$result = $stmt->fetch();
			$user->setAge($result['age']);
		}		
		
		return $users;		
	}
	
	public function getStatistics(){		
		$sql = "EXEC admin_users_simpleStats";		
		$conn = $this->getEntityManager()->getConnection();
		$stmt = $conn->query($sql);
		$stmt->execute();
		
		$result = $stmt->fetchAll();
		$statistics['reports'] = $result[0];
				
		$stmt->nextRowset();		
		$result = $stmt->fetchAll();
		$statistics['filters'] = $result[0];
		
		return $statistics;
	}
	
	public function search($data){
		$sql = "EXEC admin_users_search_sa ";
	
		$userid = (!empty($data['userid'])) ? $data['userid'] : 'null';
		$sql .=  $userid . ",";	
	
		//$notActivated = (!empty($data['usernotactivated'])) ? $data['usernotactivated'] : 'null';
		$sql .=  $data['usernotactivated'] . ",";
		$sql .=  $data['usernotcomlitedregistration'] . ",";
		$sql .=  $data['usernotapproved'] . ",";		
		$sql .=  $data['userfrozen'] . ",";
		$sql .=  $data['userblocked'] . ","; // 
		$sql .=  "null" . ","; // front page list
		$sql .=  "null" . ","; // show only images
		$sql .=  "null" . ","; // paing
		$sql .=  "null" . ","; // paid start 1
		$sql .=  "null" . ","; // paid start 2
		$sql .=  "null" . ","; // paid end 1
		$sql .=  "null" . ","; // paid end 2
		$sql .=  "null" . ","; // Reg date 1
		$sql .=  "null" . ","; // Reg date 2
		$sql .=  "null" . ","; // Last Visit 1
		$sql .=  "null" . ","; // Last Visit 2
		$sql .=  "null" . ","; // Birthday 1
		$sql .=  "null" . ","; // Birthday 2
		$sql .=  $data['useremail'] . ",";
		$sql .=  $data['usernic'] . ",";
		$sql .=  $data['userfname'] . ",";
		$sql .=  $data['userlname'] . ",";
		$sql .=  $data['userGender'] . ",";
		$sql .=  "null" . ","; //Age1
		$sql .=  "null" . ","; //Age2
		$sql .=  $data['maritalstatusid'] . ",";
		$sql .=  "null" . ","; //Children
		$sql .=  "null" . ","; // Origin country
		$sql .=  $data['languageid'] . ","; // Languages
		$sql .=  $data['100'] . ","; //Ethnic
		$sql .=  $data['100'] . ","; //Religion
		$sql .=  $data['100'] . ","; //Education
		$sql .=  $data['100'] . ","; //Occupation
		$sql .=  $data['100'] . ","; //Income
		$sql .=  $data['100'] . ","; //Health
		$sql .=  $data['100'] . ","; //Mobility
		$sql .=  $data['100'] . ","; // Looking For		
		$sql .=  $data['100'] . ","; // Smoking
		$sql .=  $data['100'] . ","; // Drinking
		$sql .=  $data['100'] . ","; // Appearence		
		$sql .=  $data['100'] . ","; // Hight 1
		$sql .=  $data['100'] . ","; // Hight 2		
		
		$sql .=  $data['100'] . ","; // Weight 1
		$sql .=  $data['100'] . ","; // Weight 2
		$sql .=  $data['100'] . ","; // Body Type
		$sql .=  $data['100'] . ","; // Hair Length
		$sql .=  $data['100'] . ","; // Hair Color
		$sql .=  $data['100'] . ","; // Eyes Color		
		$sql .=  $data['100'] . ","; // Characteristic
		$sql .=  $data['100'] . ","; // Hobbies
		$sql .=  $data['100'] . ","; // Sex Pref
		$sql .=  $data['100'] . ","; // User IP
		
		$sql .=  $data['100'] . ","; // Affiliate Id
		$sql .=  $data['100'] . ","; // Country Code
		$sql .=  $data['100'] . ","; // Region Code
		$sql .=  $data['100'] . ","; // City Name
		$sql .=  $data['100'] . ","; // longitude_1
		$sql .=  $data['100'] . ","; // latitude_1
		$sql .=  $data['100'] . ","; // latitude_h
		$sql .=  $data['100'] . ","; // longitude_h
		$sql .=  $data['100'] . ","; // Per Page
		$sql .=  $data['100'] . ","; // page
		
		//echo $sql;	
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
		$conn = $this->getEntityManager()->getConnection();
		
		if($action == 'delete' or $action == 'blockAndDelete'){
			$blockAndDelete = ($action == 'blockAndDelete') ? 1 : 0;			
			$sql = "EXEC admin_users_de_all ?,?";			
			$stmt = $conn->prepare($sql);
			$stmt->bindParam(1, $usersIdsString);
			$stmt->bindParam(2, $blockAndDelete);
		}
		else{			
			$actionArr = explode("_", $action);
			$field = $actionArr[0];
			$value = $actionArr[1];			
			$pageName = null;			
			$sql = "EXEC admin_users_setBitStatus ?,?,?,?";			
			$stmt = $conn->prepare($sql);
			$stmt->bindParam(1, $usersIdsString);
			$stmt->bindParam(2, $field);
			$stmt->bindParam(3, $value);
			$stmt->bindParam(4, $pageName);
		}
		
		$stmt->execute();
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
		
		$conn = $this->getEntityManager()->getConnection();		
		$stmt = $conn->query($sql);
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

}









