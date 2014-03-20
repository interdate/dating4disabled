<?php

namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Eyescolor
 */
class Eyescolor
{
    /**
     * @var integer
     */
    private $eyescolorid;

    /**
     * @var string
     */
    private $eyescolorname;


    /**
     * Get eyescolorid
     *
     * @return integer 
     */
    public function getEyescolorid()
    {
        return $this->eyescolorid;
    }

    /**
     * Set eyescolorname
     *
     * @param string $eyescolorname
     * @return Eyescolor
     */
    public function setEyescolorname($eyescolorname)
    {
        $this->eyescolorname = $eyescolorname;

        return $this;
    }

    /**
     * Get eyescolorname
     *
     * @return string 
     */
    public function getEyescolorname()
    {
        return $this->eyescolorname;
    }
}
