<?php

namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Occupation
 */
class Occupation
{
    /**
     * @var integer
     */
    private $occupationid;

    /**
     * @var string
     */
    private $occupationname;


    /**
     * Get occupationid
     *
     * @return integer 
     */
    public function getOccupationid()
    {
        return $this->occupationid;
    }

    /**
     * Set occupationname
     *
     * @param string $occupationname
     * @return Occupation
     */
    public function setOccupationname($occupationname)
    {
        $this->occupationname = $occupationname;

        return $this;
    }

    /**
     * Get occupationname
     *
     * @return string 
     */
    public function getOccupationname()
    {
        return $this->occupationname;
    }
}
