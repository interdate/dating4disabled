<?php

namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LocContinents
 */
class LocContinents
{
    /**
     * @var string
     */
    private $countrycode;

    /**
     * @var string
     */
    private $continentcode;


    /**
     * Set countrycode
     *
     * @param string $countrycode
     * @return LocContinents
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
     * Set continentcode
     *
     * @param string $continentcode
     * @return LocContinents
     */
    public function setContinentcode($continentcode)
    {
        $this->continentcode = $continentcode;

        return $this;
    }

    /**
     * Get continentcode
     *
     * @return string 
     */
    public function getContinentcode()
    {
        return $this->continentcode;
    }
}
