<?php

namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Hobby
 */
class Hobby
{
    /**
     * @var integer
     */
    private $hobbyid;

    /**
     * @var string
     */
    private $hobbyname;

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
     * Get hobbyid
     *
     * @return integer 
     */
    public function getHobbyid()
    {
        return $this->hobbyid;
    }

    /**
     * Set hobbyname
     *
     * @param string $hobbyname
     * @return Hobby
     */
    public function setHobbyname($hobbyname)
    {
        $this->hobbyname = $hobbyname;

        return $this;
    }

    /**
     * Get hobbyname
     *
     * @return string 
     */
    public function getHobbyname()
    {
        return $this->hobbyname;
    }

    /**
     * Add userid
     *
     * @param \D4D\AppBundle\Entity\Users $userid
     * @return Hobby
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
