<?php

namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mobility
 */
class Mobility
{
    /**
     * @var integer
     */
    private $mobilityid;

    /**
     * @var string
     */
    private $mobilityname;


    /**
     * Get mobilityid
     *
     * @return integer 
     */
    public function getMobilityid()
    {
        return $this->mobilityid;
    }

    /**
     * Set mobilityname
     *
     * @param string $mobilityname
     * @return Mobility
     */
    public function setMobilityname($mobilityname)
    {
        $this->mobilityname = $mobilityname;

        return $this;
    }

    /**
     * Get mobilityname
     *
     * @return string 
     */
    public function getMobilityname()
    {
        return $this->mobilityname;
    }
}
