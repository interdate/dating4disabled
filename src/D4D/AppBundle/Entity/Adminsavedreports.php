<?php

namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Adminsavedreports
 */
class Adminsavedreports
{
    /**
     * @var integer
     */
    private $savedreportid;

    /**
     * @var string
     */
    private $savedreportname;

    /**
     * @var string
     */
    private $savedreportlink;

    /**
     * @var boolean
     */
    private $isstats;

    /**
     * @var boolean
     */
    private $ishomepage;


    /**
     * Get savedreportid
     *
     * @return integer 
     */
    public function getSavedreportid()
    {
        return $this->savedreportid;
    }

    /**
     * Set savedreportname
     *
     * @param string $savedreportname
     * @return Adminsavedreports
     */
    public function setSavedreportname($savedreportname)
    {
        $this->savedreportname = $savedreportname;

        return $this;
    }

    /**
     * Get savedreportname
     *
     * @return string 
     */
    public function getSavedreportname()
    {
        return $this->savedreportname;
    }

    /**
     * Set savedreportlink
     *
     * @param string $savedreportlink
     * @return Adminsavedreports
     */
    public function setSavedreportlink($savedreportlink)
    {
        $this->savedreportlink = $savedreportlink;

        return $this;
    }

    /**
     * Get savedreportlink
     *
     * @return string 
     */
    public function getSavedreportlink()
    {
        return $this->savedreportlink;
    }

    /**
     * Set isstats
     *
     * @param boolean $isstats
     * @return Adminsavedreports
     */
    public function setIsstats($isstats)
    {
        $this->isstats = $isstats;

        return $this;
    }

    /**
     * Get isstats
     *
     * @return boolean 
     */
    public function getIsstats()
    {
        return $this->isstats;
    }

    /**
     * Set ishomepage
     *
     * @param boolean $ishomepage
     * @return Adminsavedreports
     */
    public function setIshomepage($ishomepage)
    {
        $this->ishomepage = $ishomepage;

        return $this;
    }

    /**
     * Get ishomepage
     *
     * @return boolean 
     */
    public function getIshomepage()
    {
        return $this->ishomepage;
    }
}
