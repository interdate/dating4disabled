<?php

namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Globalblacklist
 */
class Globalblacklist
{
    /**
     * @var string
     */
    private $useremail;


    /**
     * Get useremail
     *
     * @return string 
     */
    public function getUseremail()
    {
        return $this->useremail;
    }
}
