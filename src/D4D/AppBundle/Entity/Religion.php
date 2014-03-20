<?php

namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Religion
 */
class Religion
{
    /**
     * @var integer
     */
    private $religionid;

    /**
     * @var string
     */
    private $religionname;


    /**
     * Get religionid
     *
     * @return integer 
     */
    public function getReligionid()
    {
        return $this->religionid;
    }

    /**
     * Set religionname
     *
     * @param string $religionname
     * @return Religion
     */
    public function setReligionname($religionname)
    {
        $this->religionname = $religionname;

        return $this;
    }

    /**
     * Get religionname
     *
     * @return string 
     */
    public function getReligionname()
    {
        return $this->religionname;
    }
}
