<?php

namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Globalcontacts
 */
class Globalcontacts
{
    /**
     * @var integer
     */
    private $contacttoid;

    /**
     * @var \D4D\AppBundle\Entity\Users
     */
    private $contactfromid;


    /**
     * Set contacttoid
     *
     * @param integer $contacttoid
     * @return Globalcontacts
     */
    public function setContacttoid($contacttoid)
    {
        $this->contacttoid = $contacttoid;

        return $this;
    }

    /**
     * Get contacttoid
     *
     * @return integer 
     */
    public function getContacttoid()
    {
        return $this->contacttoid;
    }

    /**
     * Set contactfromid
     *
     * @param \D4D\AppBundle\Entity\Users $contactfromid
     * @return Globalcontacts
     */
    public function setContactfromid(\D4D\AppBundle\Entity\Users $contactfromid = null)
    {
        $this->contactfromid = $contactfromid;

        return $this;
    }

    /**
     * Get contactfromid
     *
     * @return \D4D\AppBundle\Entity\Users 
     */
    public function getContactfromid()
    {
        return $this->contactfromid;
    }
}
