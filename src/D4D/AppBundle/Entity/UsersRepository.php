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
	protected $filter = false;
	
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
	
	public function setUserGeoData($user, $geoip){		
		$geoip->lookup($user->getUserip());		
		$country = array(
			'code' => $geoip->getCountryCode(),
			'name' => $geoip->getCountryName(),
			'city' => $geoip->getCity(),
		);
				
		return $user->setCountry($country);		
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

	public function getSearchSettings(){
				
		$settings = array();
		
		switch ($this->filter){			
			case 'male':
				$settings['usergender'] = 0;
				break;
		
			case 'female':
				$settings['usergender'] = 1;
				break;
		
			case 'flagged':
				break;
		
			case 'withPhotos':
				$settings['withPhotos'] = 1;
				break;
		
			case 'inactive':
				$settings['usernotactivated'] = 1;
				$settings['userfrozen'] = 1;
				$settings['userblocked'] = 1;
				$settings['usernotapproved'] = 1;
				break;
					
			case 'notCompletedRegistration':				
				$settings['usernotcomlitedregistration'] = 1;
				break;
		
			case 'notActivated':				
				$settings['usernotactivated'] = 1;
				break;
		
			case 'notApproved':
				$settings['usernotapproved'] = 1;
				break;
		
			case 'frozen':
				$settings['userfrozen'] = 1;
				break;
		
			case 'blocked':			
				$settings['userblocked'] = 1;
				break;
		
			case 'paying':
				$settings['userPaying'] = 1;
				break;
		}
		
		return $settings;
	}
	
	
	public function search($settings, $page, $geoip, $perPage = 20){
	
		$sql = "EXEC admin_users_search_sa ";
		
		
		
		$settings['usernotactivated'] = (isset($settings['usernotactivated'])) ? $settings['usernotactivated'] : 'null';
		$settings['usernotcomlitedregistration'] = (isset($settings['usernotcomlitedregistration'])) ? $settings['usernotcomlitedregistration'] : 'null';
		$settings['usernotapproved'] = (isset($settings['usernotapproved'])) ? $settings['usernotapproved'] : 'null';
		$settings['userfrozen'] = (isset($settings['userfrozen'])) ? $settings['userfrozen'] : 'null';
		$settings['userblocked'] = (isset($settings['userblocked'])) ? $settings['userblocked'] : 'null';
		$settings['userPaying'] = (isset($settings['userPaying'])) ? $settings['userPaying'] : 'null';
		$settings['usergender'] = (isset($settings['usergender'])) ? $settings['usergender'] : 'null';
		$settings['children'] = (isset($settings['children'])) ? $settings['children'] : 'null';
		$settings['countrycode'] = (isset($settings['countrycode'])) ? $settings['countrycode'] : 'null';
		$settings['maritalstatusid'] = (isset($settings['maritalstatusid'])) ? "'" . implode(",", $settings['maritalstatusid']) . "'" : 'null';
		$settings['languageid'] = (isset($settings['languageid'])) ? "'" . implode(",", $settings['languageid']) . "'" : 'null';
		$settings['ethnicoriginid'] = (isset($settings['ethnicoriginid'])) ? "'" . implode(",", $settings['ethnicoriginid']) . "'" : 'null';	
		$settings['religionid'] = (isset($settings['religionid'])) ? "'" . implode(",", $settings['religionid']) . "'" : 'null';
		$settings['educationid'] = (isset($settings['educationid'])) ? "'" . implode(",", $settings['educationid']) . "'" : 'null';
		$settings['occupationid'] = (isset($settings['occupationid'])) ? "'" . implode(",", $settings['occupationid']) . "'" : 'null';
		$settings['incomeid'] = (isset($settings['incomeid'])) ? "'" . implode(",", $settings['incomeid']) . "'" : 'null';
		$settings['healthid'] = (isset($settings['healthid'])) ? "'" . implode(",", $settings['healthid']) . "'" : 'null';
		$settings['mobilityid'] = (isset($settings['mobilityid'])) ? "'" . implode(",", $settings['mobilityid']) . "'" : 'null';
		$settings['lookingforid'] = (isset($settings['lookingforid'])) ? "'" . implode(",", $settings['lookingforid']) . "'" : 'null';
		$settings['smokingid'] = (isset($settings['smokingid'])) ? "'" . implode(",", $settings['smokingid']) . "'" : 'null';
		$settings['drinkingid'] = (isset($settings['drinkingid'])) ? "'" . implode(",", $settings['drinkingid']) . "'" : 'null';
		$settings['appearanceid'] = (isset($settings['appearanceid'])) ? "'" . implode(",", $settings['appearanceid']) . "'" : 'null';
		$settings['bodytypeid'] = (isset($settings['bodytypeid'])) ? "'" . implode(",", $settings['bodytypeid']) . "'" : 'null';
		$settings['hairlengthid'] = (isset($settings['hairlengthid'])) ? "'" . implode(",", $settings['hairlengthid']) . "'" : 'null';
		$settings['haircolorid'] = (isset($settings['haircolorid'])) ? "'" . implode(",", $settings['haircolorid']) . "'" : 'null';
		$settings['eyescolorid'] = (isset($settings['eyescolorid'])) ? "'" . implode(",", $settings['eyescolorid']) . "'" : 'null';	
		$settings['characteristicid'] = (isset($settings['characteristicid'])) ? implode(",", $settings['characteristicid']) : 'null';
		$settings['hobbyid'] = (isset($settings['hobbyid'])) ? "'" . implode(",", $settings['hobbyid']) . "'" : 'null';
		$settings['sexprefid'] = (isset($settings['sexprefid'])) ? "'" . implode(",", $settings['sexprefid']) . "'" : 'null';	
		
		$settings['userid'] = (!empty($settings['userid'])) ? $settings['userid'] : 'null';
		$settings['paymentStartDateFrom'] = (!empty($settings['paymentStartDateFrom'])) ? "'" . $settings['paymentStartDateFrom'] . "'" : 'null';
		$settings['paymentStartDateTo'] = (!empty($settings['paymentStartDateTo'])) ? "'" . $settings['paymentStartDateTo'] . "'" : 'null';
		$settings['paymentEndDateFrom'] = (!empty($settings['paymentEndDateFrom'])) ? "'" . $settings['paymentEndDateFrom'] . "'" : 'null';
		$settings['paymentEndDateTo'] = (!empty($settings['paymentEndDateTo'])) ? "'" . $settings['paymentEndDateTo'] . "'" : 'null';
		$settings['registrationDateFrom'] = (!empty($settings['registrationDateFrom'])) ? "'" . $settings['registrationDateFrom'] . "'" : 'null';
		$settings['registrationDateTo'] = (!empty($settings['registrationDateTo'])) ? "'" . $settings['registrationDateTo'] . "'" : 'null';
		$settings['lastVisitDateFrom'] = (!empty($settings['lastVisitDateFrom'])) ? "'" . $settings['lastVisitDateFrom'] . "'" : 'null';
		$settings['lastVisitDateTo'] = (!empty($settings['lastVisitDateTo'])) ? "'" . $settings['lastVisitDateTo'] . "'" : 'null';	
		$settings['useremail'] = (!empty($settings['useremail'])) ? "'" . $settings['useremail'] . "'" : 'null';
		$settings['usernic'] = (!empty($settings['usernic'])) ? "'" . $settings['usernic'] . "'" : 'null';
		$settings['userfname'] = (!empty($settings['userfname'])) ? "'" . $settings['userfname'] . "'" : 'null';
		$settings['userlname'] = (!empty($settings['userlname'])) ? "'" . $settings['userlname'] . "'" : 'null';	
		$settings['userBirthdayFrom'] = (!empty($settings['userBirthdayFrom'])) ? "'" . $settings['userBirthdayFrom'] . "'" : 'null';
		$settings['userBirthdayTo'] = (!empty($settings['userBirthdayTo'])) ? "'" . $settings['userBirthdayTo'] . "'" : 'null';		
		$settings['ageFrom'] = (!empty($settings['ageFrom'])) ? "'" . $settings['ageFrom'] . "'" : 'null';
		$settings['ageTo'] = (!empty($settings['ageTo'])) ? "'" . $settings['ageTo'] . "'" : 'null';	
	
		if(!$this->filter)			
			$settings['countrycode'] = ($settings['countrycode'] != '--' ) ? "'" . $settings['countrycode'] . "'" : 'null';
		
		$settings = str_replace('_null', 'null', $settings);
		
		//$settings['withPhotos'] = (isset($settings['withPhotos'])) ? $settings['withPhotos'] : 'null';
		$settings['withPhotos'] = 1;
	
		$sql .=  $settings['userid'] . ",";
		$sql .=  $settings['usernotactivated'] . ",";
		$sql .=  $settings['usernotcomlitedregistration'] . ",";
		$sql .=  $settings['usernotapproved'] . ",";
		$sql .=  $settings['userfrozen'] . ",";
		$sql .=  $settings['userblocked'] . ","; //
		$sql .=  "null" . ","; // front page list
		$sql .=  $settings['withPhotos'] . ","; // show only images
		$sql .=  $settings['userPaying'] . ","; // paing
		$sql .=  "null" . ","; // prepaid points
		$sql .=  $settings['paymentStartDateFrom'] . ","; // paid start 1
		$sql .=  $settings['paymentStartDateTo'] . ","; // paid start 2
		$sql .=  $settings['paymentEndDateFrom'] . ","; // paid end 1
		$sql .=  $settings['paymentEndDateTo'] . ","; // paid end 2
		$sql .=  $settings['registrationDateFrom'] . ","; // Reg date 1
		$sql .=  $settings['registrationDateTo'] . ","; // Reg date 2
		$sql .=  $settings['lastVisitDateFrom'] . ","; // Last Visit 1
		$sql .=  $settings['lastVisitDateTo'] . ","; // Last Visit 2
		$sql .=  $settings['userBirthdayFrom'] . ","; // Birthday 1
		$sql .=  $settings['userBirthdayTo'] . ","; // Birthday 2
		$sql .=  $settings['useremail'] . ",";
		$sql .=  $settings['usernic'] . ",";
		$sql .=  $settings['userfname'] . ",";
		$sql .=  $settings['userlname'] . ",";
		$sql .=  $settings['usergender'] . ",";
		$sql .=  $settings['ageFrom'] . ","; //Age1
		$sql .=  $settings['ageTo'] . ","; //Age2
		$sql .=  $settings['maritalstatusid'] . ",";
		$sql .=  $settings['children'] . ","; //Children
		$sql .=  "null" . ","; // Origin country
		$sql .=  $settings['languageid'] . ","; // Languages
		$sql .=  $settings['ethnicoriginid'] . ","; //Ethnic
		$sql .=  $settings['religionid'] . ","; //Religion
		$sql .=  $settings['educationid'] . ","; //Education
		$sql .=  $settings['occupationid'] . ","; //Occupation
		$sql .=  $settings['incomeid'] . ","; //Income
		$sql .=  $settings['healthid'] . ","; //Health
		$sql .=  $settings['mobilityid'] . ","; //Mobility
		$sql .=  $settings['lookingforid'] . ","; // Looking For
		$sql .=  $settings['smokingid'] . ","; // Smoking
		$sql .=  $settings['drinkingid'] . ","; // Drinking
		$sql .=  $settings['appearanceid'] . ","; // Appearance
		$sql .=  "null" . ","; // Hight 1
		$sql .=  "null" . ","; // Hight 2	
		$sql .=  "null" . ","; // Weight 1
		$sql .=  "null" . ","; // Weight 2
		$sql .=  $settings['bodytypeid'] . ","; // Body Type
		$sql .=  $settings['hairlengthid'] . ","; // Hair Length
		$sql .=  $settings['haircolorid'] . ","; // Hair Color
		$sql .=  $settings['eyescolorid'] . ","; // Eyes Color
		$sql .=  $settings['characteristicid'] . ","; // Characteristic
		$sql .=  $settings['hobbyid'] . ","; // Hobbies
		$sql .=  $settings['sexprefid'] . ","; // Sex Pref
		$sql .=  "null" . ","; // User IP	
		$sql .=  "null" . ","; // Affiliate Id
		$sql .=  $settings['countrycode'] . ","; // Country Code
		$sql .=  "null" . ","; // Region Code
		$sql .=  "null" . ","; // City Name
		$sql .=  "null" . ","; // longitude_1
		$sql .=  "null" . ","; // latitude_1
		$sql .=  "null" . ","; // latitude_h
		$sql .=  "null" . ","; // longitude_h
		$sql .=  $perPage . ","; // Per Page
		$sql .=  $page . ","; // page
	
		$sql .= ' "AND" ';	
				
		$this->connection = $this->getEntityManager()->getConnection();
		$stmt = $this->connection->query($sql);

		$users['itemsNumber'] = 0;
		$users['items'] = array();
	
		$result = $stmt->fetchAll();
	
		$users['itemsNumber'] = $result[0][""];
				
		$stmt->nextRowset();
	
		$result = $stmt->fetchAll();
			
		if(count($result)){
			foreach ($result as $row){
				$user = $this->find($row['userId']);
				$user->setUserPaying($row['isUserPaying']);				
				$user->setAge($row['userAge']);
				$users['items'][] = $this->setUserGeoData($user, $geoip);
			}
		}
	
		return $users;
	}
	
	public function changeUserGroup($groupName, $userOwnerId, $userMemberId, $act){
		//$act  0 - delete, 1 - insert
		$sql = "EXEC site_lists_do " . $groupName . ", " . $userOwnerId . ", " . $userMemberId . ", " . $act;
		$this->connection = $this->getEntityManager()->getConnection();
		$stmt = $this->connection->query($sql);
		$stmt->nextRowset();
		if($act == '1') $stmt->nextRowset();
		$result = $stmt->fetchAll();

		return ($act == '1') ? $result[0]['addedMsg'] : $result[0]['removedMsg'];
	}

	public function  getUsersByGroup($userId, $groupName, $page, $perPage, $geoip){
				
		$sql = "EXEC site_lists_sa " . $userId . ", " . $groupName . ", " . $page . ", " . $perPage;
		$this->connection = $this->getEntityManager()->getConnection();
		$stmt = $this->connection->query($sql);
		$result = $stmt->fetchAll();
		
		//print_r($result);
		//var_dump($result);die;
		
		$users['items'] = array();		
		$users['itemsNumber'] = (isset($result[0][""])) ? $result[0][""] : $result[0]["countUsers"];
		
		if($users['itemsNumber'] > 0){
			$stmt->nextRowset();
			$result = $stmt->fetchAll();
			
			//print_r($result);
			//die;
			
			foreach ($result as $row){ 
				//echo $row['userId'] . '<br>';				
				$user = $this->find($row['userId']);
				$user->setUserPaying($row['isUserPaying']);				
				$user->setAge($row['userAge']);
				$photosRepo = $this->getEntityManager()->getRepository('D4DAppBundle:Images');
				$mainPhoto = $photosRepo->findOneBy(array(
    				'userid' => $user->getUserid(),
    				'imgmain' => true,    						
    			));    			    			 
    			if($mainPhoto instanceof Images && is_file($mainPhoto->getAbsolutePath())){
    				$user->setMainPhoto( $mainPhoto );
    			}
				$users['items'][] = $this->setUserGeoData($user, $geoip);
				
				
			}
		}
		
		
		return $users;
	}
	
	public function getUserData($userId){
		$sql = "EXEC site_userEnter " . $userId . ", 1";
		$this->connection = $this->getEntityManager()->getConnection();
		$stmt = $this->connection->query($sql);
		
		$result = $stmt->fetchAll();		
		$stmt->nextRowset();		
		$result = $stmt->fetchAll();

		return array(
			'statistics' => array(
				'favorites' => $result[0]['fav'],
				'blackList' => $result[0]['blackList'],
				'lookedAtMe' => $result[0]['atme'],
				'contacted' => $result[0]['contacted'],
				'contactedMe' => $result[0]['contactedMe'],
				'addedMeToFavorites' => $result[0]['favMe'],
			)
		);
		
		/*
		$stmt->nextRowset();		
		$result = $stmt->fetchAll();
		$stmt->nextRowset();
		*/
		
	}
	
	public function getGroupHeaderByGroupName($groupName){
		
		switch ($groupName) {
			case 'favi':
				return 'Friends';
			
			case 'coni': 
				return 'People I contacted';

			case 'favme':
				return 'Added You To Friends';

			case 'atme':
				return 'Viewed Your Profile';
				
			case 'black':
				return 'Black Listed';		
					
		}
		
	}
	
	public function getViewTypeDataByCurrentRoute($currentRoute){
		
		switch ($currentRoute) {			
			case 'user_search_advanced':
				$name = 'Gallery';
				$route = 'user_search_advanced_gallery';
				$cssClass = 'gallery';
				break;
					
			case 'user_users_group':
				$name = 'Gallery';
				$route = 'user_users_group_gallery';
				$cssClass = 'gallery';				
				break;
				
			case 'user_search_advanced_gallery':
				$name = 'Listing';
				$route = 'user_search_advanced';
				$cssClass = 'listing';
				break;
						
			case 'user_users_group_gallery':
				$name = 'Listing';
				$route = 'user_users_group';
				$cssClass = 'listing';
				break;		
		}
		
		
		//echo $route;
		//die();
		
		return
			array(
	    		'name' => $name,
	    		'route' => $route,
				'cssClass' => $cssClass,
    		);
				
	}
	

}



/*

public function getUsers($paginator, $page, $geoip){
$users = array();
$this->connection = $this->getEntityManager()->getConnection();
$dql = $this->getDQL();
$query = $this->getEntityManager()->createQuery($dql);
$users['items'] = $paginator->paginate($query, $page, 20);
$users['itemsNumber'] = $users['items']->getTotalItemCount();
foreach ($users['items'] as $user){
$this->setUserGeoData($user, $geoip);
}
return $users;
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
*/









