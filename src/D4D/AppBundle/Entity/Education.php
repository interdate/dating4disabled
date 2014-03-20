<?php

namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Education
 */
class Education
{
    /**
     * @var integer
     */
    private $educationid;

    /**
     * @var string
     */
    private $educationname;


    /**
     * Get educationid
     *
     * @return integer 
     */
    public function getEducationid()
    {
        return $this->educationid;
    }

    /**
     * Set educationname
     *
     * @param string $educationname
     * @return Education
     */
    public function setEducationname($educationname)
    {
        $this->educationname = $educationname;

        return $this;
    }

    /**
     * Get educationname
     *
     * @return string 
     */
    public function getEducationname()
    {
        return $this->educationname;
    }
}
