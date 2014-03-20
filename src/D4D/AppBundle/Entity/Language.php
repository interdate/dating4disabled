<?php

namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Language
 */
class Language
{
    /**
     * @var integer
     */
    private $languageid;

    /**
     * @var string
     */
    private $languagename;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $userid;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->userid = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get languageid
     *
     * @return integer 
     */
    public function getLanguageid()
    {
        return $this->languageid;
    }

    /**
     * Set languagename
     *
     * @param string $languagename
     * @return Language
     */
    public function setLanguagename($languagename)
    {
        $this->languagename = $languagename;

        return $this;
    }

    /**
     * Get languagename
     *
     * @return string 
     */
    public function getLanguagename()
    {
        return $this->languagename;
    }

    /**
     * Add userid
     *
     * @param \D4D\AppBundle\Entity\Users $userid
     * @return Language
     */
    public function addUserid(\D4D\AppBundle\Entity\Users $userid)
    {
        $this->userid[] = $userid;

        return $this;
    }

    /**
     * Remove userid
     *
     * @param \D4D\AppBundle\Entity\Users $userid
     */
    public function removeUserid(\D4D\AppBundle\Entity\Users $userid)
    {
        $this->userid->removeElement($userid);
    }

    /**
     * Get userid
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUserid()
    {
        return $this->userid;
    }
}
