<?php

namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Maritalstatus
 */
class Maritalstatus
{
    /**
     * @var integer
     */
    private $maritalstatusid;

    /**
     * @var string
     */
    private $maritalstatusname;


    /**
     * Get maritalstatusid
     *
     * @return integer 
     */
    public function getMaritalstatusid()
    {
        return $this->maritalstatusid;
    }

    /**
     * Set maritalstatusname
     *
     * @param string $maritalstatusname
     * @return Maritalstatus
     */
    public function setMaritalstatusname($maritalstatusname)
    {
        $this->maritalstatusname = $maritalstatusname;

        return $this;
    }

    /**
     * Get maritalstatusname
     *
     * @return string 
     */
    public function getMaritalstatusname()
    {
        return $this->maritalstatusname;
    }
}
