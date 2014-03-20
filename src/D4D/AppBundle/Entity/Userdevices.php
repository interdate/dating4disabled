<?php

namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Userdevices
 */
class Userdevices
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $userid;

    /**
     * @var string
     */
    private $gcmdeviceid;

    /**
     * @var string
     */
    private $apndeviceid;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set userid
     *
     * @param integer $userid
     * @return Userdevices
     */
    public function setUserid($userid)
    {
        $this->userid = $userid;

        return $this;
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
     * Set gcmdeviceid
     *
     * @param string $gcmdeviceid
     * @return Userdevices
     */
    public function setGcmdeviceid($gcmdeviceid)
    {
        $this->gcmdeviceid = $gcmdeviceid;

        return $this;
    }

    /**
     * Get gcmdeviceid
     *
     * @return string 
     */
    public function getGcmdeviceid()
    {
        return $this->gcmdeviceid;
    }

    /**
     * Set apndeviceid
     *
     * @param string $apndeviceid
     * @return Userdevices
     */
    public function setApndeviceid($apndeviceid)
    {
        $this->apndeviceid = $apndeviceid;

        return $this;
    }

    /**
     * Get apndeviceid
     *
     * @return string 
     */
    public function getApndeviceid()
    {
        return $this->apndeviceid;
    }
}
