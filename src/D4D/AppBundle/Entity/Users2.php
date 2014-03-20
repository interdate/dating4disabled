<?php

namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\userInterface;

use Doctrine\Common\Collections\ArrayCollection; 


/**
 * D4D\AppBundle\Entity
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="D4D\AppBundle\Entity\UsersRepository")
 */
class Users implements userInterface, \Serializable
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\userId
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $userid;

    /**
     * @var string
     */
    private $useremail;

    /**
     * @var string
     */
    private $userpass;

    /**
     * @var string
     */
    private $usernic;

    /**
     * @var boolean
     */
    private $usergender;

    /**
     * @var string
     */
    private $userfname;

    /**
     * @var string
     */
    private $userlname;

    /**
     * @var \DateTime
     */
    private $userbirthday;

    /**
     * @var integer
     */
    private $userchildren;

    /**
     * @var string
     */
    private $countrycode;

    /**
     * @var string
     */
    private $regioncode;

    /**
     * @var string
     */
    private $cityname;

    /**
     * @var string
     */
    private $zipcode;

    /**
     * @var string
     */
    private $usercityname;

    /**
     * @var float
     */
    private $latitude;

    /**
     * @var float
     */
    private $longitude;

    /**
     * @var string
     */
    private $countryoforigincode;

    /**
     * @var integer
     */
    private $userhight;

    /**
     * @var integer
     */
    private $userweight;

    /**
     * @var string
     */
    private $userhobbies;

    /**
     * @var string
     */
    private $useraboutme;

    /**
     * @var string
     */
    private $userlookingfor;

    /**
     * @var boolean
     */
    private $usernotcomlitedregistration;

    /**
     * @var \DateTime
     */
    private $userregistrationdate;

    /**
     * @var \DateTime
     */
    private $userlastvisitdate;

    /**
     * @var boolean
     */
    private $usernotactivated;

    /**
     * @var boolean
     */
    private $userfrozen;

    /**
     * @var boolean
     */
    private $userblocked;

    /**
     * @var string
     */
    private $userwhyfrozen;

    /**
     * @var integer
     */
    private $userprepaidpoints;

    /**
     * @var \DateTime
     */
    private $userpaidstartdate;

    /**
     * @var \DateTime
     */
    private $userpaidenddate;

    /**
     * @var string
     */
    private $userip;

    /**
     * @var boolean
     */
    private $usergetmsgtoemail;

    /**
     * @var boolean
     */
    private $userfrontpagelist;

    /**
     * @var boolean
     */
    private $userdontsavesentmsg;

    /**
     * @var string
     */
    private $useradmincomment;

    /**
     * @var boolean
     */
    private $useradminmarked;

    /**
     * @var string
     */
    private $usersavedsearch;

    /**
     * @var boolean
     */
    private $usernotapproved;

    /**
     * @var integer
     */
    private $affiliateid;

    /**
     * @var integer
     */
    private $useronlinestatus;

    /**
     * @var float
     */
    private $long;

    /**
     * @var float
     */
    private $lat;

    /**
     * @var string
     */
    private $apppushtoken;

    /**
     * @var string
     */
    private $salt;

    /**
     * @var \D4D\AppBundle\Entity\Maritalstatus
     */
    private $maritalstatusid;

    /**
     * @var \D4D\AppBundle\Entity\Ethnicorigin
     */
    private $ethnicoriginid;

    /**
     * @var \D4D\AppBundle\Entity\Religion
     */
    private $religionid;

    /**
     * @var \D4D\AppBundle\Entity\Education
     */
    private $educationid;

    /**
     * @var \D4D\AppBundle\Entity\Occupation
     */
    private $occupationid;

    /**
     * @var \D4D\AppBundle\Entity\Income
     */
    private $incomeid;

    /**
     * @var \D4D\AppBundle\Entity\Health
     */
    private $healthid;

    /**
     * @var \D4D\AppBundle\Entity\Mobility
     */
    private $mobilityid;

    /**
     * @var \D4D\AppBundle\Entity\Smoking
     */
    private $smokingid;

    /**
     * @var \D4D\AppBundle\Entity\Drinking
     */
    private $drinkingid;

    /**
     * @var \D4D\AppBundle\Entity\Appearance
     */
    private $appearanceid;

    /**
     * @var \D4D\AppBundle\Entity\Bodytype
     */
    private $bodytypeid;

    /**
     * @var \D4D\AppBundle\Entity\Hairlength
     */
    private $hairlengthid;

    /**
     * @var \D4D\AppBundle\Entity\Haircolor
     */
    private $haircolorid;

    /**
     * @var \D4D\AppBundle\Entity\Eyescolor
     */
    private $eyescolorid;

    /**
     * @var \D4D\AppBundle\Entity\Sexpref
     */
    private $sexprefid;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $characteristicid;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $hobbyid;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $languageid;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $lookingforid;
    
    
    /**
     * @OneToOne(targetEntity="Roles")
     * @JoinColumn(name="role_id", referencedColumnName="id")
     **/
    private $role;  
    

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->characteristicid = new ArrayCollection();
        $this->hobbyid = new ArrayCollection();
        $this->languageid = new ArrayCollection();
        $this->lookingforid = new ArrayCollection();
        
        $this->salt = md5(uniqid(null, true));       
        
    }

    /**
     * Get userid
     *
     * @return integer 
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * Set useremail
     *
     * @param string $useremail
     * @return Users
     */
    public function setUseremail($useremail)
    {
        $this->useremail = $useremail;

        return $this;
    }

    /**
     * Get useremail
     *
     * @return string 
     */
    public function getUseremail()
    {
        return $this->useremail;
    }

    /**
     * Set userpass
     *
     * @param string $userpass
     * @return Users
     */
    public function setUserpass($userpass)
    {
        $this->userpass = $userpass;

        return $this;
    }

    /**
     * Get userpass
     *
     * @return string 
     */
    public function getUserpass()
    {
        return $this->userpass;
    }

    /**
     * Set usernic
     *
     * @param string $usernic
     * @return Users
     */
    public function setUsernic($usernic)
    {
        $this->usernic = $usernic;

        return $this;
    }

    /**
     * Get usernic
     *
     * @return string 
     */
    public function getUsernic()
    {
        return $this->usernic;
    }

    /**
     * Set usergender
     *
     * @param boolean $usergender
     * @return Users
     */
    public function setUsergender($usergender)
    {
        $this->usergender = $usergender;

        return $this;
    }

    /**
     * Get usergender
     *
     * @return boolean 
     */
    public function getUsergender()
    {
        return $this->usergender;
    }

    /**
     * Set userfname
     *
     * @param string $userfname
     * @return Users
     */
    public function setUserfname($userfname)
    {
        $this->userfname = $userfname;

        return $this;
    }

    /**
     * Get userfname
     *
     * @return string 
     */
    public function getUserfname()
    {
        return $this->userfname;
    }

    /**
     * Set userlname
     *
     * @param string $userlname
     * @return Users
     */
    public function setUserlname($userlname)
    {
        $this->userlname = $userlname;

        return $this;
    }

    /**
     * Get userlname
     *
     * @return string 
     */
    public function getUserlname()
    {
        return $this->userlname;
    }

    /**
     * Set userbirthday
     *
     * @param \DateTime $userbirthday
     * @return Users
     */
    public function setUserbirthday($userbirthday)
    {
        $this->userbirthday = $userbirthday;

        return $this;
    }

    /**
     * Get userbirthday
     *
     * @return \DateTime 
     */
    public function getUserbirthday()
    {
        return $this->userbirthday;
    }

    /**
     * Set userchildren
     *
     * @param integer $userchildren
     * @return Users
     */
    public function setUserchildren($userchildren)
    {
        $this->userchildren = $userchildren;

        return $this;
    }

    /**
     * Get userchildren
     *
     * @return integer 
     */
    public function getUserchildren()
    {
        return $this->userchildren;
    }

    /**
     * Set countrycode
     *
     * @param string $countrycode
     * @return Users
     */
    public function setCountrycode($countrycode)
    {
        $this->countrycode = $countrycode;

        return $this;
    }

    /**
     * Get countrycode
     *
     * @return string 
     */
    public function getCountrycode()
    {
        return $this->countrycode;
    }

    /**
     * Set regioncode
     *
     * @param string $regioncode
     * @return Users
     */
    public function setRegioncode($regioncode)
    {
        $this->regioncode = $regioncode;

        return $this;
    }

    /**
     * Get regioncode
     *
     * @return string 
     */
    public function getRegioncode()
    {
        return $this->regioncode;
    }

    /**
     * Set cityname
     *
     * @param string $cityname
     * @return Users
     */
    public function setCityname($cityname)
    {
        $this->cityname = $cityname;

        return $this;
    }

    /**
     * Get cityname
     *
     * @return string 
     */
    public function getCityname()
    {
        return $this->cityname;
    }

    /**
     * Set zipcode
     *
     * @param string $zipcode
     * @return Users
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    /**
     * Get zipcode
     *
     * @return string 
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * Set usercityname
     *
     * @param string $usercityname
     * @return Users
     */
    public function setUsercityname($usercityname)
    {
        $this->usercityname = $usercityname;

        return $this;
    }

    /**
     * Get usercityname
     *
     * @return string 
     */
    public function getUsercityname()
    {
        return $this->usercityname;
    }

    /**
     * Set latitude
     *
     * @param float $latitude
     * @return Users
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return float 
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param float $longitude
     * @return Users
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return float 
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set countryoforigincode
     *
     * @param string $countryoforigincode
     * @return Users
     */
    public function setCountryoforigincode($countryoforigincode)
    {
        $this->countryoforigincode = $countryoforigincode;

        return $this;
    }

    /**
     * Get countryoforigincode
     *
     * @return string 
     */
    public function getCountryoforigincode()
    {
        return $this->countryoforigincode;
    }

    /**
     * Set userhight
     *
     * @param integer $userhight
     * @return Users
     */
    public function setUserhight($userhight)
    {
        $this->userhight = $userhight;

        return $this;
    }

    /**
     * Get userhight
     *
     * @return integer 
     */
    public function getUserhight()
    {
        return $this->userhight;
    }

    /**
     * Set userweight
     *
     * @param integer $userweight
     * @return Users
     */
    public function setUserweight($userweight)
    {
        $this->userweight = $userweight;

        return $this;
    }

    /**
     * Get userweight
     *
     * @return integer 
     */
    public function getUserweight()
    {
        return $this->userweight;
    }

    /**
     * Set userhobbies
     *
     * @param string $userhobbies
     * @return Users
     */
    public function setUserhobbies($userhobbies)
    {
        $this->userhobbies = $userhobbies;

        return $this;
    }

    /**
     * Get userhobbies
     *
     * @return string 
     */
    public function getUserhobbies()
    {
        return $this->userhobbies;
    }

    /**
     * Set useraboutme
     *
     * @param string $useraboutme
     * @return Users
     */
    public function setUseraboutme($useraboutme)
    {
        $this->useraboutme = $useraboutme;

        return $this;
    }

    /**
     * Get useraboutme
     *
     * @return string 
     */
    public function getUseraboutme()
    {
        return $this->useraboutme;
    }

    /**
     * Set userlookingfor
     *
     * @param string $userlookingfor
     * @return Users
     */
    public function setUserlookingfor($userlookingfor)
    {
        $this->userlookingfor = $userlookingfor;

        return $this;
    }

    /**
     * Get userlookingfor
     *
     * @return string 
     */
    public function getUserlookingfor()
    {
        return $this->userlookingfor;
    }

    /**
     * Set usernotcomlitedregistration
     *
     * @param boolean $usernotcomlitedregistration
     * @return Users
     */
    public function setUsernotcomlitedregistration($usernotcomlitedregistration)
    {
        $this->usernotcomlitedregistration = $usernotcomlitedregistration;

        return $this;
    }

    /**
     * Get usernotcomlitedregistration
     *
     * @return boolean 
     */
    public function getUsernotcomlitedregistration()
    {
        return $this->usernotcomlitedregistration;
    }

    /**
     * Set userregistrationdate
     *
     * @param \DateTime $userregistrationdate
     * @return Users
     */
    public function setUserregistrationdate($userregistrationdate)
    {
        $this->userregistrationdate = $userregistrationdate;

        return $this;
    }

    /**
     * Get userregistrationdate
     *
     * @return \DateTime 
     */
    public function getUserregistrationdate()
    {
        return $this->userregistrationdate;
    }

    /**
     * Set userlastvisitdate
     *
     * @param \DateTime $userlastvisitdate
     * @return Users
     */
    public function setUserlastvisitdate($userlastvisitdate)
    {
        $this->userlastvisitdate = $userlastvisitdate;

        return $this;
    }

    /**
     * Get userlastvisitdate
     *
     * @return \DateTime 
     */
    public function getUserlastvisitdate()
    {
        return $this->userlastvisitdate;
    }

    /**
     * Set usernotactivated
     *
     * @param boolean $usernotactivated
     * @return Users
     */
    public function setUsernotactivated($usernotactivated)
    {
        $this->usernotactivated = $usernotactivated;

        return $this;
    }

    /**
     * Get usernotactivated
     *
     * @return boolean 
     */
    public function getUsernotactivated()
    {
        return $this->usernotactivated;
    }

    /**
     * Set userfrozen
     *
     * @param boolean $userfrozen
     * @return Users
     */
    public function setUserfrozen($userfrozen)
    {
        $this->userfrozen = $userfrozen;

        return $this;
    }

    /**
     * Get userfrozen
     *
     * @return boolean 
     */
    public function getUserfrozen()
    {
        return $this->userfrozen;
    }

    /**
     * Set userblocked
     *
     * @param boolean $userblocked
     * @return Users
     */
    public function setUserblocked($userblocked)
    {
        $this->userblocked = $userblocked;

        return $this;
    }

    /**
     * Get userblocked
     *
     * @return boolean 
     */
    public function getUserblocked()
    {
        return $this->userblocked;
    }

    /**
     * Set userwhyfrozen
     *
     * @param string $userwhyfrozen
     * @return Users
     */
    public function setUserwhyfrozen($userwhyfrozen)
    {
        $this->userwhyfrozen = $userwhyfrozen;

        return $this;
    }

    /**
     * Get userwhyfrozen
     *
     * @return string 
     */
    public function getUserwhyfrozen()
    {
        return $this->userwhyfrozen;
    }

    /**
     * Set userprepaidpoints
     *
     * @param integer $userprepaidpoints
     * @return Users
     */
    public function setUserprepaidpoints($userprepaidpoints)
    {
        $this->userprepaidpoints = $userprepaidpoints;

        return $this;
    }

    /**
     * Get userprepaidpoints
     *
     * @return integer 
     */
    public function getUserprepaidpoints()
    {
        return $this->userprepaidpoints;
    }

    /**
     * Set userpaidstartdate
     *
     * @param \DateTime $userpaidstartdate
     * @return Users
     */
    public function setUserpaidstartdate($userpaidstartdate)
    {
        $this->userpaidstartdate = $userpaidstartdate;

        return $this;
    }

    /**
     * Get userpaidstartdate
     *
     * @return \DateTime 
     */
    public function getUserpaidstartdate()
    {
        return $this->userpaidstartdate;
    }

    /**
     * Set userpaidenddate
     *
     * @param \DateTime $userpaidenddate
     * @return Users
     */
    public function setUserpaidenddate($userpaidenddate)
    {
        $this->userpaidenddate = $userpaidenddate;

        return $this;
    }

    /**
     * Get userpaidenddate
     *
     * @return \DateTime 
     */
    public function getUserpaidenddate()
    {
        return $this->userpaidenddate;
    }

    /**
     * Set userip
     *
     * @param string $userip
     * @return Users
     */
    public function setUserip($userip)
    {
        $this->userip = $userip;

        return $this;
    }

    /**
     * Get userip
     *
     * @return string 
     */
    public function getUserip()
    {
        return $this->userip;
    }

    /**
     * Set usergetmsgtoemail
     *
     * @param boolean $usergetmsgtoemail
     * @return Users
     */
    public function setUsergetmsgtoemail($usergetmsgtoemail)
    {
        $this->usergetmsgtoemail = $usergetmsgtoemail;

        return $this;
    }

    /**
     * Get usergetmsgtoemail
     *
     * @return boolean 
     */
    public function getUsergetmsgtoemail()
    {
        return $this->usergetmsgtoemail;
    }

    /**
     * Set userfrontpagelist
     *
     * @param boolean $userfrontpagelist
     * @return Users
     */
    public function setUserfrontpagelist($userfrontpagelist)
    {
        $this->userfrontpagelist = $userfrontpagelist;

        return $this;
    }

    /**
     * Get userfrontpagelist
     *
     * @return boolean 
     */
    public function getUserfrontpagelist()
    {
        return $this->userfrontpagelist;
    }

    /**
     * Set userdontsavesentmsg
     *
     * @param boolean $userdontsavesentmsg
     * @return Users
     */
    public function setUserdontsavesentmsg($userdontsavesentmsg)
    {
        $this->userdontsavesentmsg = $userdontsavesentmsg;

        return $this;
    }

    /**
     * Get userdontsavesentmsg
     *
     * @return boolean 
     */
    public function getUserdontsavesentmsg()
    {
        return $this->userdontsavesentmsg;
    }

    /**
     * Set useradmincomment
     *
     * @param string $useradmincomment
     * @return Users
     */
    public function setUseradmincomment($useradmincomment)
    {
        $this->useradmincomment = $useradmincomment;

        return $this;
    }

    /**
     * Get useradmincomment
     *
     * @return string 
     */
    public function getUseradmincomment()
    {
        return $this->useradmincomment;
    }

    /**
     * Set useradminmarked
     *
     * @param boolean $useradminmarked
     * @return Users
     */
    public function setUseradminmarked($useradminmarked)
    {
        $this->useradminmarked = $useradminmarked;

        return $this;
    }

    /**
     * Get useradminmarked
     *
     * @return boolean 
     */
    public function getUseradminmarked()
    {
        return $this->useradminmarked;
    }

    /**
     * Set usersavedsearch
     *
     * @param string $usersavedsearch
     * @return Users
     */
    public function setUsersavedsearch($usersavedsearch)
    {
        $this->usersavedsearch = $usersavedsearch;

        return $this;
    }

    /**
     * Get usersavedsearch
     *
     * @return string 
     */
    public function getUsersavedsearch()
    {
        return $this->usersavedsearch;
    }

    /**
     * Set usernotapproved
     *
     * @param boolean $usernotapproved
     * @return Users
     */
    public function setUsernotapproved($usernotapproved)
    {
        $this->usernotapproved = $usernotapproved;

        return $this;
    }

    /**
     * Get usernotapproved
     *
     * @return boolean 
     */
    public function getUsernotapproved()
    {
        return $this->usernotapproved;
    }

    /**
     * Set affiliateid
     *
     * @param integer $affiliateid
     * @return Users
     */
    public function setAffiliateid($affiliateid)
    {
        $this->affiliateid = $affiliateid;

        return $this;
    }

    /**
     * Get affiliateid
     *
     * @return integer 
     */
    public function getAffiliateid()
    {
        return $this->affiliateid;
    }

    /**
     * Set useronlinestatus
     *
     * @param integer $useronlinestatus
     * @return Users
     */
    public function setUseronlinestatus($useronlinestatus)
    {
        $this->useronlinestatus = $useronlinestatus;

        return $this;
    }

    /**
     * Get useronlinestatus
     *
     * @return integer 
     */
    public function getUseronlinestatus()
    {
        return $this->useronlinestatus;
    }

    /**
     * Set long
     *
     * @param float $long
     * @return Users
     */
    public function setLong($long)
    {
        $this->long = $long;

        return $this;
    }

    /**
     * Get long
     *
     * @return float 
     */
    public function getLong()
    {
        return $this->long;
    }

    /**
     * Set lat
     *
     * @param float $lat
     * @return Users
     */
    public function setLat($lat)
    {
        $this->lat = $lat;

        return $this;
    }

    /**
     * Get lat
     *
     * @return float 
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * Set apppushtoken
     *
     * @param string $apppushtoken
     * @return Users
     */
    public function setApppushtoken($apppushtoken)
    {
        $this->apppushtoken = $apppushtoken;

        return $this;
    }

    /**
     * Get apppushtoken
     *
     * @return string 
     */
    public function getApppushtoken()
    {
        return $this->apppushtoken;
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return Users
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string 
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set maritalstatusid
     *
     * @param \D4D\AppBundle\Entity\Maritalstatus $maritalstatusid
     * @return Users
     */
    public function setMaritalstatusid(\D4D\AppBundle\Entity\Maritalstatus $maritalstatusid = null)
    {
        $this->maritalstatusid = $maritalstatusid;

        return $this;
    }

    /**
     * Get maritalstatusid
     *
     * @return \D4D\AppBundle\Entity\Maritalstatus 
     */
    public function getMaritalstatusid()
    {
        return $this->maritalstatusid;
    }

    /**
     * Set ethnicoriginid
     *
     * @param \D4D\AppBundle\Entity\Ethnicorigin $ethnicoriginid
     * @return Users
     */
    public function setEthnicoriginid(\D4D\AppBundle\Entity\Ethnicorigin $ethnicoriginid = null)
    {
        $this->ethnicoriginid = $ethnicoriginid;

        return $this;
    }

    /**
     * Get ethnicoriginid
     *
     * @return \D4D\AppBundle\Entity\Ethnicorigin 
     */
    public function getEthnicoriginid()
    {
        return $this->ethnicoriginid;
    }

    /**
     * Set religionid
     *
     * @param \D4D\AppBundle\Entity\Religion $religionid
     * @return Users
     */
    public function setReligionid(\D4D\AppBundle\Entity\Religion $religionid = null)
    {
        $this->religionid = $religionid;

        return $this;
    }

    /**
     * Get religionid
     *
     * @return \D4D\AppBundle\Entity\Religion 
     */
    public function getReligionid()
    {
        return $this->religionid;
    }

    /**
     * Set educationid
     *
     * @param \D4D\AppBundle\Entity\Education $educationid
     * @return Users
     */
    public function setEducationid(\D4D\AppBundle\Entity\Education $educationid = null)
    {
        $this->educationid = $educationid;

        return $this;
    }

    /**
     * Get educationid
     *
     * @return \D4D\AppBundle\Entity\Education 
     */
    public function getEducationid()
    {
        return $this->educationid;
    }

    /**
     * Set occupationid
     *
     * @param \D4D\AppBundle\Entity\Occupation $occupationid
     * @return Users
     */
    public function setOccupationid(\D4D\AppBundle\Entity\Occupation $occupationid = null)
    {
        $this->occupationid = $occupationid;

        return $this;
    }

    /**
     * Get occupationid
     *
     * @return \D4D\AppBundle\Entity\Occupation 
     */
    public function getOccupationid()
    {
        return $this->occupationid;
    }

    /**
     * Set incomeid
     *
     * @param \D4D\AppBundle\Entity\Income $incomeid
     * @return Users
     */
    public function setIncomeid(\D4D\AppBundle\Entity\Income $incomeid = null)
    {
        $this->incomeid = $incomeid;

        return $this;
    }

    /**
     * Get incomeid
     *
     * @return \D4D\AppBundle\Entity\Income 
     */
    public function getIncomeid()
    {
        return $this->incomeid;
    }

    /**
     * Set healthid
     *
     * @param \D4D\AppBundle\Entity\Health $healthid
     * @return Users
     */
    public function setHealthid(\D4D\AppBundle\Entity\Health $healthid = null)
    {
        $this->healthid = $healthid;

        return $this;
    }

    /**
     * Get healthid
     *
     * @return \D4D\AppBundle\Entity\Health 
     */
    public function getHealthid()
    {
        return $this->healthid;
    }

    /**
     * Set mobilityid
     *
     * @param \D4D\AppBundle\Entity\Mobility $mobilityid
     * @return Users
     */
    public function setMobilityid(\D4D\AppBundle\Entity\Mobility $mobilityid = null)
    {
        $this->mobilityid = $mobilityid;

        return $this;
    }

    /**
     * Get mobilityid
     *
     * @return \D4D\AppBundle\Entity\Mobility 
     */
    public function getMobilityid()
    {
        return $this->mobilityid;
    }

    /**
     * Set smokingid
     *
     * @param \D4D\AppBundle\Entity\Smoking $smokingid
     * @return Users
     */
    public function setSmokingid(\D4D\AppBundle\Entity\Smoking $smokingid = null)
    {
        $this->smokingid = $smokingid;

        return $this;
    }

    /**
     * Get smokingid
     *
     * @return \D4D\AppBundle\Entity\Smoking 
     */
    public function getSmokingid()
    {
        return $this->smokingid;
    }

    /**
     * Set drinkingid
     *
     * @param \D4D\AppBundle\Entity\Drinking $drinkingid
     * @return Users
     */
    public function setDrinkingid(\D4D\AppBundle\Entity\Drinking $drinkingid = null)
    {
        $this->drinkingid = $drinkingid;

        return $this;
    }

    /**
     * Get drinkingid
     *
     * @return \D4D\AppBundle\Entity\Drinking 
     */
    public function getDrinkingid()
    {
        return $this->drinkingid;
    }

    /**
     * Set appearanceid
     *
     * @param \D4D\AppBundle\Entity\Appearance $appearanceid
     * @return Users
     */
    public function setAppearanceid(\D4D\AppBundle\Entity\Appearance $appearanceid = null)
    {
        $this->appearanceid = $appearanceid;

        return $this;
    }

    /**
     * Get appearanceid
     *
     * @return \D4D\AppBundle\Entity\Appearance 
     */
    public function getAppearanceid()
    {
        return $this->appearanceid;
    }

    /**
     * Set bodytypeid
     *
     * @param \D4D\AppBundle\Entity\Bodytype $bodytypeid
     * @return Users
     */
    public function setBodytypeid(\D4D\AppBundle\Entity\Bodytype $bodytypeid = null)
    {
        $this->bodytypeid = $bodytypeid;

        return $this;
    }

    /**
     * Get bodytypeid
     *
     * @return \D4D\AppBundle\Entity\Bodytype 
     */
    public function getBodytypeid()
    {
        return $this->bodytypeid;
    }

    /**
     * Set hairlengthid
     *
     * @param \D4D\AppBundle\Entity\Hairlength $hairlengthid
     * @return Users
     */
    public function setHairlengthid(\D4D\AppBundle\Entity\Hairlength $hairlengthid = null)
    {
        $this->hairlengthid = $hairlengthid;

        return $this;
    }

    /**
     * Get hairlengthid
     *
     * @return \D4D\AppBundle\Entity\Hairlength 
     */
    public function getHairlengthid()
    {
        return $this->hairlengthid;
    }

    /**
     * Set haircolorid
     *
     * @param \D4D\AppBundle\Entity\Haircolor $haircolorid
     * @return Users
     */
    public function setHaircolorid(\D4D\AppBundle\Entity\Haircolor $haircolorid = null)
    {
        $this->haircolorid = $haircolorid;

        return $this;
    }

    /**
     * Get haircolorid
     *
     * @return \D4D\AppBundle\Entity\Haircolor 
     */
    public function getHaircolorid()
    {
        return $this->haircolorid;
    }

    /**
     * Set eyescolorid
     *
     * @param \D4D\AppBundle\Entity\Eyescolor $eyescolorid
     * @return Users
     */
    public function setEyescolorid(\D4D\AppBundle\Entity\Eyescolor $eyescolorid = null)
    {
        $this->eyescolorid = $eyescolorid;

        return $this;
    }

    /**
     * Get eyescolorid
     *
     * @return \D4D\AppBundle\Entity\Eyescolor 
     */
    public function getEyescolorid()
    {
        return $this->eyescolorid;
    }

    /**
     * Set sexprefid
     *
     * @param \D4D\AppBundle\Entity\Sexpref $sexprefid
     * @return Users
     */
    public function setSexprefid(\D4D\AppBundle\Entity\Sexpref $sexprefid = null)
    {
        $this->sexprefid = $sexprefid;

        return $this;
    }

    /**
     * Get sexprefid
     *
     * @return \D4D\AppBundle\Entity\Sexpref 
     */
    public function getSexprefid()
    {
        return $this->sexprefid;
    }
    
    /**
     * Set role
     *
     * @param \D4D\AppBundle\Entity\Roles $role
     * @return Users
     */
    public function setRole(\D4D\AppBundle\Entity\Roles $role = null)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return \D4D\AppBundle\Entity\Roles 
     */
    public function getRole()
    {
        return $this->role;
    }
    

    /**
     * Add characteristicid
     *
     * @param \D4D\AppBundle\Entity\Characteristic $characteristicid
     * @return Users
     */
    public function addCharacteristicid(\D4D\AppBundle\Entity\Characteristic $characteristicid)
    {
        $this->characteristicid[] = $characteristicid;

        return $this;
    }

    /**
     * Remove characteristicid
     *
     * @param \D4D\AppBundle\Entity\Characteristic $characteristicid
     */
    public function removeCharacteristicid(\D4D\AppBundle\Entity\Characteristic $characteristicid)
    {
        $this->characteristicid->removeElement($characteristicid);
    }

    /**
     * Get characteristicid
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCharacteristicid()
    {
        return $this->characteristicid;
    }

    /**
     * Add hobbyid
     *
     * @param \D4D\AppBundle\Entity\Hobby $hobbyid
     * @return Users
     */
    public function addHobbyid(\D4D\AppBundle\Entity\Hobby $hobbyid)
    {
        $this->hobbyid[] = $hobbyid;

        return $this;
    }

    /**
     * Remove hobbyid
     *
     * @param \D4D\AppBundle\Entity\Hobby $hobbyid
     */
    public function removeHobbyid(\D4D\AppBundle\Entity\Hobby $hobbyid)
    {
        $this->hobbyid->removeElement($hobbyid);
    }

    /**
     * Get hobbyid
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getHobbyid()
    {
        return $this->hobbyid;
    }

    /**
     * Add languageid
     *
     * @param \D4D\AppBundle\Entity\Language $languageid
     * @return Users
     */
    public function addLanguageid(\D4D\AppBundle\Entity\Language $languageid)
    {
        $this->languageid[] = $languageid;

        return $this;
    }

    /**
     * Remove languageid
     *
     * @param \D4D\AppBundle\Entity\Language $languageid
     */
    public function removeLanguageid(\D4D\AppBundle\Entity\Language $languageid)
    {
        $this->languageid->removeElement($languageid);
    }

    /**
     * Get languageid
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLanguageid()
    {
        return $this->languageid;
    }

    /**
     * Add lookingforid
     *
     * @param \D4D\AppBundle\Entity\Lookingfor $lookingforid
     * @return Users
     */
    public function addLookingforid(\D4D\AppBundle\Entity\Lookingfor $lookingforid)
    {
        $this->lookingforid[] = $lookingforid;

        return $this;
    }

    /**
     * Remove lookingforid
     *
     * @param \D4D\AppBundle\Entity\Lookingfor $lookingforid
     */
    public function removeLookingforid(\D4D\AppBundle\Entity\Lookingfor $lookingforid)
    {
        $this->lookingforid->removeElement($lookingforid);
    }

    /**
     * Get lookingforid
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLookingforid()
    {
        return $this->lookingforid;
    }
    
    /**
     * Set roleId
     *
     * @param integer $roleId
     * @return Users
     */
    public function setRoleId($roleId)
    {
    	$this->roleId = $roleId;
    
    	return $this;
    }
    
    /**
     * Get roleId
     *
     * @return integer
     */
    public function getRoleId()
    {
    	return $this->roleId;
    }
    
    
    
    
    
    
    /**
     * @inheritDoc
     */
    public function getUsername()
    {
    	return $this->usernic;
    }
    
    
    /**
    * @inheritDoc
    */
    public function getPassword()
    {
    	return $this->userpass;
    }
    
    
    
	public function getRoles()
    {
        //return array('ROLE_SUPER_ADMIN');
        return array($this->role->getRole());
    }
    
    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
    }
    
    /**
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
    	return serialize(array(
    			$this->userid,
    			$this->usernic,
    			$this->userpass,
    			// see section on salt below
    			// $this->salt,
    	));
    }
    
    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
    	list (
    			$this->userid,
    			$this->usernic,
    			$this->userpass,
    			// see section on salt below
    			// $this->salt
    	) = unserialize($serialized);
    }
    
    
    
    
    
}
