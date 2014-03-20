<?php

namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sexpref
 */
class Sexpref
{
    /**
     * @var integer
     */
    private $sexprefid;

    /**
     * @var string
     */
    private $sexprefname;


    /**
     * Get sexprefid
     *
     * @return integer 
     */
    public function getSexprefid()
    {
        return $this->sexprefid;
    }

    /**
     * Set sexprefname
     *
     * @param string $sexprefname
     * @return Sexpref
     */
    public function setSexprefname($sexprefname)
    {
        $this->sexprefname = $sexprefname;

        return $this;
    }

    /**
     * Get sexprefname
     *
     * @return string 
     */
    public function getSexprefname()
    {
        return $this->sexprefname;
    }
}
