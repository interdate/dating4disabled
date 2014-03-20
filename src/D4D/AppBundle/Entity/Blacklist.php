<?php

namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Blacklist
 */
class Blacklist
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
     * @var \D4D\AppBundle\Entity\Users
     */
    private $listownerid;


    /**
     * Set listmemberid
     *
     * @param integer $listmemberid
     * @return Blacklist
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
     * @return Blacklist
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
     * Set listownerid
     *
     * @param \D4D\AppBundle\Entity\Users $listownerid
     * @return Blacklist
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
