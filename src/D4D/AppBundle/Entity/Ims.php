<?php

namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ims
 */
class Ims
{
    /**
     * @var integer
     */
    private $imfromid;

    /**
     * @var integer
     */
    private $imtoid;

    /**
     * @var string
     */
    private $imtext;

    /**
     * @var \DateTime
     */
    private $imlasttime;


    /**
     * Set imfromid
     *
     * @param integer $imfromid
     * @return Ims
     */
    public function setImfromid($imfromid)
    {
        $this->imfromid = $imfromid;

        return $this;
    }

    /**
     * Get imfromid
     *
     * @return integer 
     */
    public function getImfromid()
    {
        return $this->imfromid;
    }

    /**
     * Set imtoid
     *
     * @param integer $imtoid
     * @return Ims
     */
    public function setImtoid($imtoid)
    {
        $this->imtoid = $imtoid;

        return $this;
    }

    /**
     * Get imtoid
     *
     * @return integer 
     */
    public function getImtoid()
    {
        return $this->imtoid;
    }

    /**
     * Set imtext
     *
     * @param string $imtext
     * @return Ims
     */
    public function setImtext($imtext)
    {
        $this->imtext = $imtext;

        return $this;
    }

    /**
     * Get imtext
     *
     * @return string 
     */
    public function getImtext()
    {
        return $this->imtext;
    }

    /**
     * Set imlasttime
     *
     * @param \DateTime $imlasttime
     * @return Ims
     */
    public function setImlasttime($imlasttime)
    {
        $this->imlasttime = $imlasttime;

        return $this;
    }

    /**
     * Get imlasttime
     *
     * @return \DateTime 
     */
    public function getImlasttime()
    {
        return $this->imlasttime;
    }
}
