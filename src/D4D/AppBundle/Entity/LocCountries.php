<?php

namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LocCountries
 */
class LocCountries
{
    /**
     * @var string
     */
    private $countrycode;

    /**
     * @var string
     */
    private $countryname;


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
     * Set countryname
     *
     * @param string $countryname
     * @return LocCountries
     */
    public function setCountryname($countryname)
    {
        $this->countryname = $countryname;

        return $this;
    }

    /**
     * Get countryname
     *
     * @return string 
     */
    public function getCountryname()
    {
        return $this->countryname;
    }
}
