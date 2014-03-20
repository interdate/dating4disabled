<?php

namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ethnicorigin
 */
class Ethnicorigin
{
    /**
     * @var integer
     */
    private $ethnicoriginid;

    /**
     * @var string
     */
    private $ethnicoriginname;


    /**
     * Get ethnicoriginid
     *
     * @return integer 
     */
    public function getEthnicoriginid()
    {
        return $this->ethnicoriginid;
    }

    /**
     * Set ethnicoriginname
     *
     * @param string $ethnicoriginname
     * @return Ethnicorigin
     */
    public function setEthnicoriginname($ethnicoriginname)
    {
        $this->ethnicoriginname = $ethnicoriginname;

        return $this;
    }

    /**
     * Get ethnicoriginname
     *
     * @return string 
     */
    public function getEthnicoriginname()
    {
        return $this->ethnicoriginname;
    }
}
