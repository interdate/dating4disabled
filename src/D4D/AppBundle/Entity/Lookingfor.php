<?php

namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Lookingfor
 */
class Lookingfor
{
    /**
     * @var integer
     */
    private $lookingforid;

    /**
     * @var string
     */
    private $lookingforname;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $userid;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->userid = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get lookingforid
     *
     * @return integer 
     */
    public function getLookingforid()
    {
        return $this->lookingforid;
    }

    /**
     * Set lookingforname
     *
     * @param string $lookingforname
     * @return Lookingfor
     */
    public function setLookingforname($lookingforname)
    {
        $this->lookingforname = $lookingforname;

        return $this;
    }

    /**
     * Get lookingforname
     *
     * @return string 
     */
    public function getLookingforname()
    {
        return $this->lookingforname;
    }

    /**
     * Add userid
     *
     * @param \D4D\AppBundle\Entity\Users $userid
     * @return Lookingfor
     */
    public function addUserid(\D4D\AppBundle\Entity\Users $userid)
    {
        $this->userid[] = $userid;

        return $this;
    }

    /**
     * Remove userid
     *
     * @param \D4D\AppBundle\Entity\Users $userid
     */
    public function removeUserid(\D4D\AppBundle\Entity\Users $userid)
    {
        $this->userid->removeElement($userid);
    }

    /**
     * Get userid
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUserid()
    {
        return $this->userid;
    }
}
