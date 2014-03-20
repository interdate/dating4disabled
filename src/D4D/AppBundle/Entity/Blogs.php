<?php

namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Blogs
 */
class Blogs
{
    /**
     * @var integer
     */
    private $blogid;

    /**
     * @var integer
     */
    private $blogcategoryid;

    /**
     * @var string
     */
    private $blogname;

    /**
     * @var string
     */
    private $blogdesc;

    /**
     * @var \D4D\AppBundle\Entity\Users
     */
    private $userid;


    /**
     * Get blogid
     *
     * @return integer 
     */
    public function getBlogid()
    {
        return $this->blogid;
    }

    /**
     * Set blogcategoryid
     *
     * @param integer $blogcategoryid
     * @return Blogs
     */
    public function setBlogcategoryid($blogcategoryid)
    {
        $this->blogcategoryid = $blogcategoryid;

        return $this;
    }

    /**
     * Get blogcategoryid
     *
     * @return integer 
     */
    public function getBlogcategoryid()
    {
        return $this->blogcategoryid;
    }

    /**
     * Set blogname
     *
     * @param string $blogname
     * @return Blogs
     */
    public function setBlogname($blogname)
    {
        $this->blogname = $blogname;

        return $this;
    }

    /**
     * Get blogname
     *
     * @return string 
     */
    public function getBlogname()
    {
        return $this->blogname;
    }

    /**
     * Set blogdesc
     *
     * @param string $blogdesc
     * @return Blogs
     */
    public function setBlogdesc($blogdesc)
    {
        $this->blogdesc = $blogdesc;

        return $this;
    }

    /**
     * Get blogdesc
     *
     * @return string 
     */
    public function getBlogdesc()
    {
        return $this->blogdesc;
    }

    /**
     * Set userid
     *
     * @param \D4D\AppBundle\Entity\Users $userid
     * @return Blogs
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
