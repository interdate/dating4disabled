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
	//public $filters = array('total', 'male', 'female');
	protected $filter = 'total';

	public function setFilter($filter){		
		if($filter)
			$this->filter = $filter;
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
					'Unable to find an active admin OkDealAdminBundle:User object identified by "%s".',
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
				$dql   = "SELECT u FROM D4DAppBundle:Users u WHERE u.usernotactivated = 1 OR u.userfrozen = 1 OR u.userblocked = 1 OR u.usernotapproved = 1";
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
				//$dql   = "SELECT u FROM D4DAppBundle:Users u WHERE u.userpaidstartdate <= '" . $date . "' AND u.userpaidenddate >= '" . $date . "'";
				
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
				
				/*
				$dql = "SELECT 
							u.userId, 
							u.userNic, 
							(SELECT dbo.ifUserPaing(u.userPrePaidPoints, u.userPaidStartDate, u.userPaidEndDate, GETDATE()) as PAYING) 
						FROM 
							D4DAppBundle:Users u";
				*/			
						
				
/*
				$sql = "SELECT u.userId, u.userNic, dbo.ifUserPaing(u.userPrePaidPoints, u.userPaidStartDate, u.userPaidEndDate, GETDATE()) as PAYING FROM users u";
				$conn = $this->getEntityManager()->getConnection();
				$stmt = $conn->prepare($sql);
				$stmt->execute();
				$res = $stmt->fetchAll();
				echo count($res) . "<br><br>";
				foreach ($res as $user){
					
					var_dump($user);
					echo "<br /><br />";
					
				}
				
				print_r($stmt->fetchAll());
				die();
				*/
				break;

				
				
					
					
		}
		
		return $dql;
	}

	public function execute($action){
		switch ($action){
			case 'activate':
				
				break;
				
			case 'deactivate':
				break;
		}
	}
	
	
	
	
	
	public function test(){
		
		
		$userGender = "0";
		$value = null;
		
		$sql = "EXEC admin_users_search_sa ";
		
		for ($i = 0; $i < 65; $i++){
			if($i == 25)
				$sql .= '1';
			elseif($i == 62)
				$sql .= '20';
			elseif($i == 63)
				$sql .= '1';
			else
				$sql .= 'null';
				
			if($i < 64)
				$sql .= ",";
		}
		
		
		echo $sql . '<br />';
		
		$conn = $this->getEntityManager()->getConnection();
		//$stmt = $conn->prepare($sql);
		/*
		for ($i = 1; $i <= 65; $i++){
				
			if($i == 25)
				$stmt->bindParam($i, $userGender);
			else
				$stmt->bindParam($i, $value);
				
		}
		*/
		
		$stmt = $conn->query($sql);
		$stmt->execute();
		//print_r($stmt->fetchAll());
		//die();
		
		$rowset = $stmt->fetchAll();
		var_dump($rowset);
		$stmt->nextRowset();
		
		$rowset = $stmt->fetchAll();
		var_dump($rowset);
		$stmt->nextRowset();
		
		$rowset = $stmt->fetchAll();
		var_dump($rowset);
		$stmt->nextRowset();
		
		$rowset = $stmt->fetchAll();
		var_dump($rowset);
		$stmt->nextRowset();
		
		$rowset = $stmt->fetchAll();
		var_dump($rowset);
		$stmt->nextRowset();
		
		$rowset = $stmt->fetchAll();
		var_dump($rowset);
		$stmt->nextRowset();
		
		$rowset = $stmt->fetchAll();
		var_dump($rowset);
		$stmt->nextRowset();
		
		$rowset = $stmt->fetchAll();
		var_dump($rowset);
		$stmt->nextRowset();
		
		
		$rowset = $stmt->fetchAll();
		var_dump($rowset);
		$stmt->nextRowset();
		
		
		$rowset = $stmt->fetchAll();
		var_dump($rowset);
		$stmt->nextRowset();
		
		
		$rowset = $stmt->fetchAll();
		var_dump($rowset);
		$stmt->nextRowset();
		
		$rowset = $stmt->fetchAll();
		var_dump($rowset);
		$stmt->nextRowset();
		
		
		
		
		do {			
			$rowset = $stmt->fetchAll();
			var_dump($rowset);			
		} while ($stmt->nextRowset());
		
		die();
			
		$i = 0;
		while($result = $stmt->fetch(\PDO::FETCH_ASSOC) or $i < 10) {
			var_dump($result);
			echo '<br />';
			$i++;
		}
		die();
	}
        
        public function pay(){
               $sql = "EXEC admin_user_pay_ss ";
               $sql .= '23334,';
               for ($i = 0; $i < 7; $i++){
//                       if($i == 62)
//                               $sql .= '20';
//                       
//                       elseif($i == 63)
//                               $sql .= '1';
//                       elseif($i == 64)
//                               $sql .= ' "AND" ';
//                       else
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
//               $stmt->nextRowset();
//               $rowset = $stmt->fetchColumn();
//               
//               var_dump($rowset); 
               $i = 0;
               
//               do {
//                   
//                       
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




/*
				$em = $this->getEntityManager();
				$conn = $em->getConnection();
				
				$userGender = "0";
				$value = false;
				
				$sql = "EXEC admin_users_search_sa";
				
				for ($i = 0; $i < 65; $i++){
					$sql .= "?";
					
					if($i < 64)
						$sql .= ",";
				}
				
				$stmt = $conn->prepare($sql);
				
				for ($i = 1; $i <= 65; $i++){
					
					if($i == 25)
						$stmt->bindParam($i, $userGender);					
					else
						$stmt->bindParam($i, $value);
					
				}
				
				
				//$stmt->bindParam(1, $userId);				
				$stmt->execute();
				print_r($stmt->fetchAll());
				
				die();
				 
				$i = 0;
				while($result = $stmt->fetch(\PDO::FETCH_ASSOC) or $i < 10) {
					var_dump($result);
					echo '<br />';
					$i++;
				}
				die();
  
  
*/






