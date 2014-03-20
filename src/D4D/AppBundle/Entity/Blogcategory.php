<?php

namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Blogcategory
 */
class Blogcategory
{
    /**
     * @var integer
     */
    private $blogcategoryid;

    /**
     * @var string
     */
    private $blogcategoryname;


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
     * Set blogcategoryname
     *
     * @param string $blogcategoryname
     * @return Blogcategory
     */
    public function setBlogcategoryname($blogcategoryname)
    {
        $this->blogcategoryname = $blogcategoryname;

        return $this;
    }

    /**
     * Get blogcategoryname
     *
     * @return string 
     */
    public function getBlogcategoryname()
    {
        return $this->blogcategoryname;
    }
}
