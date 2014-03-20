<?php

namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LocRegions
 */
class LocRegions
{
    /**
     * @var string
     */
    private $countrycode;

    /**
     * @var string
     */
    private $regioncode;

    /**
     * @var string
     */
    private $regionname;


    /**
     * Set countrycode
     *
     * @param string $countrycode
     * @return LocRegions
     */
    public function setCountrycode($countrycode)
    {
        $this->countrycode = $countrycode;

        return $this;
    }

    /**
     * Get countrycode
     *
     * @return string 
     */
    public function getCountrycode()
    {
        return $this->countrycode;
    }

    /**
     * Set regioncode
     *
     * @param string $regioncode
     * @return LocRegions
     */
    public function setRegioncode($regioncode)
    {
        $this->regioncode = $regioncode;

        return $this;
    }

    /**
     * Get regioncode
     *
     * @return string 
     */
    public function getRegioncode()
    {
        return $this->regioncode;
    }

    /**
     * Set regionname
     *
     * @param string $regionname
     * @return LocRegions
     */
    public function setRegionname($regionname)
    {
        $this->regionname = $regionname;

        return $this;
    }

    /**
     * Get regionname
     *
     * @return string 
     */
    public function getRegionname()
    {
        return $this->regionname;
    }
}
