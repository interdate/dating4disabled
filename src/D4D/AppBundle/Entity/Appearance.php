<?php

namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Appearance
 */
class Appearance
{
    /**
     * @var integer
     */
    private $appearanceid;

    /**
     * @var string
     */
    private $appearancename;


    /**
     * Get appearanceid
     *
     * @return integer 
     */
    public function getAppearanceid()
    {
        return $this->appearanceid;
    }

    /**
     * Set appearancename
     *
     * @param string $appearancename
     * @return Appearance
     */
    public function setAppearancename($appearancename)
    {
        $this->appearancename = $appearancename;

        return $this;
    }

    /**
     * Get appearancename
     *
     * @return string 
     */
    public function getAppearancename()
    {
        return $this->appearancename;
    }
}
