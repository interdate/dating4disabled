<?php

namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Usersonline
 */
class Usersonline
{
    /**
     * @var integer
     */
    private $userid;

    /**
     * @var \DateTime
     */
    private $lasttime;


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
     * Set lasttime
     *
     * @param \DateTime $lasttime
     * @return Usersonline
     */
    public function setLasttime($lasttime)
    {
        $this->lasttime = $lasttime;

        return $this;
    }

    /**
     * Get lasttime
     *
     * @return \DateTime 
     */
    public function getLasttime()
    {
        return $this->lasttime;
    }
}
