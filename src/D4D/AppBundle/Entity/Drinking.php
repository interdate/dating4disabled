<?php

namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Drinking
 */
class Drinking
{
    /**
     * @var integer
     */
    private $drinkingid;

    /**
     * @var string
     */
    private $drinkingname;


    /**
     * Get drinkingid
     *
     * @return integer 
     */
    public function getDrinkingid()
    {
        return $this->drinkingid;
    }

    /**
     * Set drinkingname
     *
     * @param string $drinkingname
     * @return Drinking
     */
    public function setDrinkingname($drinkingname)
    {
        $this->drinkingname = $drinkingname;

        return $this;
    }

    /**
     * Get drinkingname
     *
     * @return string 
     */
    public function getDrinkingname()
    {
        return $this->drinkingname;
    }
}
