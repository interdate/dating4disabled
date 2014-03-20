<?php

namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Health
 */
class Health
{
    /**
     * @var integer
     */
    private $healthid;

    /**
     * @var string
     */
    private $healthname;


    /**
     * Get healthid
     *
     * @return integer 
     */
    public function getHealthid()
    {
        return $this->healthid;
    }

    /**
     * Set healthname
     *
     * @param string $healthname
     * @return Health
     */
    public function setHealthname($healthname)
    {
        $this->healthname = $healthname;

        return $this;
    }

    /**
     * Get healthname
     *
     * @return string 
     */
    public function getHealthname()
    {
        return $this->healthname;
    }
}
