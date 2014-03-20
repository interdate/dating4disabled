<?php

namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Smoking
 */
class Smoking
{
    /**
     * @var integer
     */
    private $smokingid;

    /**
     * @var string
     */
    private $smokingname;


    /**
     * Get smokingid
     *
     * @return integer 
     */
    public function getSmokingid()
    {
        return $this->smokingid;
    }

    /**
     * Set smokingname
     *
     * @param string $smokingname
     * @return Smoking
     */
    public function setSmokingname($smokingname)
    {
        $this->smokingname = $smokingname;

        return $this;
    }

    /**
     * Get smokingname
     *
     * @return string 
     */
    public function getSmokingname()
    {
        return $this->smokingname;
    }
}
