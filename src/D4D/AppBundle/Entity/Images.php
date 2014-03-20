<?php

namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Images
 */
class Images
{
    /**
     * @var integer
     */
    private $imgid;

    /**
     * @var boolean
     */
    private $imgmain;

    /**
     * @var boolean
     */
    private $imgvalidated;

    /**
     * @var \D4D\AppBundle\Entity\Users
     */
    private $userid;


    /**
     * Get imgid
     *
     * @return integer 
     */
    public function getImgid()
    {
        return $this->imgid;
    }

    /**
     * Set imgmain
     *
     * @param boolean $imgmain
     * @return Images
     */
    public function setImgmain($imgmain)
    {
        $this->imgmain = $imgmain;

        return $this;
    }

    /**
     * Get imgmain
     *
     * @return boolean 
     */
    public function getImgmain()
    {
        return $this->imgmain;
    }

    /**
     * Set imgvalidated
     *
     * @param boolean $imgvalidated
     * @return Images
     */
    public function setImgvalidated($imgvalidated)
    {
        $this->imgvalidated = $imgvalidated;

        return $this;
    }

    /**
     * Get imgvalidated
     *
     * @return boolean 
     */
    public function getImgvalidated()
    {
        return $this->imgvalidated;
    }

    /**
     * Set userid
     *
     * @param \D4D\AppBundle\Entity\Users $userid
     * @return Images
     */
    public function setUserid(\D4D\AppBundle\Entity\Users $userid = null)
    {
        $this->userid = $userid;

        return $this;
    }

    /**
     * Get userid
     *
     * @return \D4D\AppBundle\Entity\Users 
     */
    public function getUserid()
    {
        return $this->userid;
    }
}
