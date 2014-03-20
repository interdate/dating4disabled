<?php

namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bodytype
 */
class Bodytype
{
    /**
     * @var integer
     */
    private $bodytypeid;

    /**
     * @var string
     */
    private $bodytypename;


    /**
     * Get bodytypeid
     *
     * @return integer 
     */
    public function getBodytypeid()
    {
        return $this->bodytypeid;
    }

    /**
     * Set bodytypename
     *
     * @param string $bodytypename
     * @return Bodytype
     */
    public function setBodytypename($bodytypename)
    {
        $this->bodytypename = $bodytypename;

        return $this;
    }

    /**
     * Get bodytypename
     *
     * @return string 
     */
    public function getBodytypename()
    {
        return $this->bodytypename;
    }
}
