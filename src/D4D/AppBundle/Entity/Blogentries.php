<?php

namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Blogentries
 */
class Blogentries
{
    /**
     * @var integer
     */
    private $entryid;

    /**
     * @var string
     */
    private $entrysubject;

    /**
     * @var string
     */
    private $entrytext;

    /**
     * @var \DateTime
     */
    private $entrydate;

    /**
     * @var \D4D\AppBundle\Entity\Blogs
     */
    private $blogid;


    /**
     * Get entryid
     *
     * @return integer 
     */
    public function getEntryid()
    {
        return $this->entryid;
    }

    /**
     * Set entrysubject
     *
     * @param string $entrysubject
     * @return Blogentries
     */
    public function setEntrysubject($entrysubject)
    {
        $this->entrysubject = $entrysubject;

        return $this;
    }

    /**
     * Get entrysubject
     *
     * @return string 
     */
    public function getEntrysubject()
    {
        return $this->entrysubject;
    }

    /**
     * Set entrytext
     *
     * @param string $entrytext
     * @return Blogentries
     */
    public function setEntrytext($entrytext)
    {
        $this->entrytext = $entrytext;

        return $this;
    }

    /**
     * Get entrytext
     *
     * @return string 
     */
    public function getEntrytext()
    {
        return $this->entrytext;
    }

    /**
     * Set entrydate
     *
     * @param \DateTime $entrydate
     * @return Blogentries
     */
    public function setEntrydate($entrydate)
    {
        $this->entrydate = $entrydate;

        return $this;
    }

    /**
     * Get entrydate
     *
     * @return \DateTime 
     */
    public function getEntrydate()
    {
        return $this->entrydate;
    }

    /**
     * Set blogid
     *
     * @param \D4D\AppBundle\Entity\Blogs $blogid
     * @return Blogentries
     */
    public function setBlogid(\D4D\AppBundle\Entity\Blogs $blogid = null)
    {
        $this->blogid = $blogid;

        return $this;
    }

    /**
     * Get blogid
     *
     * @return \D4D\AppBundle\Entity\Blogs 
     */
    public function getBlogid()
    {
        return $this->blogid;
    }
}
