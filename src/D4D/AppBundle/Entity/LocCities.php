<?php

namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LocCities
 */
class LocCities
{
    /**
     * @var integer
     */
    private $id;

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
    private $cityname;

    /**
     * @var float
     */
    private $latitude;

    /**
     * @var float
     */
    private $longitude;

    /**
     * @var string
     */
    private $zipcode;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set countrycode
     *
     * @param string $countrycode
     * @return LocCities
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
     * @return LocCities
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
     * Set cityname
     *
     * @param string $cityname
     * @return LocCities
     */
    public function setCityname($cityname)
    {
        $this->cityname = $cityname;

        return $this;
    }

    /**
     * Get cityname
     *
     * @return string 
     */
    public function getCityname()
    {
        return $this->cityname;
    }

    /**
     * Set latitude
     *
     * @param float $latitude
     * @return LocCities
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return float 
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param float $longitude
     * @return LocCities
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return float 
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set zipcode
     *
     * @param string $zipcode
     * @return LocCities
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    /**
     * Get zipcode
     *
     * @return string 
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }
}
