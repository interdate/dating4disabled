<?php

namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Haircolor
 */
class Haircolor
{
    /**
     * @var integer
     */
    private $haircolorid;

    /**
     * @var string
     */
    private $haircolorname;


    /**
     * Get haircolorid
     *
     * @return integer 
     */
    public function getHaircolorid()
    {
        return $this->haircolorid;
    }

    /**
     * Set haircolorname
     *
     * @param string $haircolorname
     * @return Haircolor
     */
    public function setHaircolorname($haircolorname)
    {
        $this->haircolorname = $haircolorname;

        return $this;
    }

    /**
     * Get haircolorname
     *
     * @return string 
     */
    public function getHaircolorname()
    {
        return $this->haircolorname;
    }
}
