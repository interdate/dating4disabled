<?php

namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Income
 */
class Income
{
    /**
     * @var integer
     */
    private $incomeid;

    /**
     * @var string
     */
    private $incomename;


    /**
     * Get incomeid
     *
     * @return integer 
     */
    public function getIncomeid()
    {
        return $this->incomeid;
    }

    /**
     * Set incomename
     *
     * @param string $incomename
     * @return Income
     */
    public function setIncomename($incomename)
    {
        $this->incomename = $incomename;

        return $this;
    }

    /**
     * Get incomename
     *
     * @return string 
     */
    public function getIncomename()
    {
        return $this->incomename;
    }
}
