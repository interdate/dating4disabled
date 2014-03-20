<?php

namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Favoritelist
 */
class Favoritelist
{
    /**
     * @var integer
     */
    private $listmemberid;

    /**
     * @var \DateTime
     */
    private $memberadddate;

    /**
     * @var boolean
     */
    private $showinprofile;

    /**
     * @var \D4D\AppBundle\Entity\Users
     */
    private $listownerid;


    /**
     * Set listmemberid
     *
     * @param integer $listmemberid
     * @return Favoritelist
     */
    public function setListmemberid($listmemberid)
    {
        $this->listmemberid = $listmemberid;

        return $this;
    }

    /**
     * Get listmemberid
     *
     * @return integer 
     */
    public function getListmemberid()
    {
        return $this->listmemberid;
    }

    /**
     * Set memberadddate
     *
     * @param \DateTime $memberadddate
     * @return Favoritelist
     */
    public function setMemberadddate($memberadddate)
    {
        $this->memberadddate = $memberadddate;

        return $this;
    }

    /**
     * Get memberadddate
     *
     * @return \DateTime 
     */
    public function getMemberadddate()
    {
        return $this->memberadddate;
    }

    /**
     * Set showinprofile
     *
     * @param boolean $showinprofile
     * @return Favoritelist
     */
    public function setShowinprofile($showinprofile)
    {
        $this->showinprofile = $showinprofile;

        return $this;
    }

    /**
     * Get showinprofile
     *
     * @return boolean 
     */
    public function getShowinprofile()
    {
        return $this->showinprofile;
    }

    /**
     * Set listownerid
     *
     * @param \D4D\AppBundle\Entity\Users $listownerid
     * @return Favoritelist
     */
    public function setListownerid(\D4D\AppBundle\Entity\Users $listownerid = null)
    {
        $this->listownerid = $listownerid;

        return $this;
    }

    /**
     * Get listownerid
     *
     * @return \D4D\AppBundle\Entity\Users 
     */
    public function getListownerid()
    {
        return $this->listownerid;
    }
}
