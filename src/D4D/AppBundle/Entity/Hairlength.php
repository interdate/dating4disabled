<?php

namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Hairlength
 */
class Hairlength
{
    /**
     * @var integer
     */
    private $hairlengthid;

    /**
     * @var string
     */
    private $hairlengthname;


    /**
     * Get hairlengthid
     *
     * @return integer 
     */
    public function getHairlengthid()
    {
        return $this->hairlengthid;
    }

    /**
     * Set hairlengthname
     *
     * @param string $hairlengthname
     * @return Hairlength
     */
    public function setHairlengthname($hairlengthname)
    {
        $this->hairlengthname = $hairlengthname;

        return $this;
    }

    /**
     * Get hairlengthname
     *
     * @return string 
     */
    public function getHairlengthname()
    {
        return $this->hairlengthname;
    }
}
