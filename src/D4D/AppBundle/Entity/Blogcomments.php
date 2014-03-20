<?php

namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Blogcomments
 */
class Blogcomments
{
    /**
     * @var integer
     */
    private $commentid;

    /**
     * @var integer
     */
    private $blogid;

    /**
     * @var integer
     */
    private $parentcommentid;

    /**
     * @var integer
     */
    private $userid;

    /**
     * @var string
     */
    private $commentsubject;

    /**
     * @var string
     */
    private $commenttext;

    /**
     * @var \DateTime
     */
    private $commentdate;

    /**
     * @var integer
     */
    private $commentlevel;

    /**
     * @var \D4D\AppBundle\Entity\Blogentries
     */
    private $entryid;


    /**
     * Get commentid
     *
     * @return integer 
     */
    public function getCommentid()
    {
        return $this->commentid;
    }

    /**
     * Set blogid
     *
     * @param integer $blogid
     * @return Blogcomments
     */
    public function setBlogid($blogid)
    {
        $this->blogid = $blogid;

        return $this;
    }

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
     * Set parentcommentid
     *
     * @param integer $parentcommentid
     * @return Blogcomments
     */
    public function setParentcommentid($parentcommentid)
    {
        $this->parentcommentid = $parentcommentid;

        return $this;
    }

    /**
     * Get parentcommentid
     *
     * @return integer 
     */
    public function getParentcommentid()
    {
        return $this->parentcommentid;
    }

    /**
     * Set userid
     *
     * @param integer $userid
     * @return Blogcomments
     */
    public function setUserid($userid)
    {
        $this->userid = $userid;

        return $this;
    }

    /**
     * Get userid
     *
     * @return integer 
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * Set commentsubject
     *
     * @param string $commentsubject
     * @return Blogcomments
     */
    public function setCommentsubject($commentsubject)
    {
        $this->commentsubject = $commentsubject;

        return $this;
    }

    /**
     * Get commentsubject
     *
     * @return string 
     */
    public function getCommentsubject()
    {
        return $this->commentsubject;
    }

    /**
     * Set commenttext
     *
     * @param string $commenttext
     * @return Blogcomments
     */
    public function setCommenttext($commenttext)
    {
        $this->commenttext = $commenttext;

        return $this;
    }

    /**
     * Get commenttext
     *
     * @return string 
     */
    public function getCommenttext()
    {
        return $this->commenttext;
    }

    /**
     * Set commentdate
     *
     * @param \DateTime $commentdate
     * @return Blogcomments
     */
    public function setCommentdate($commentdate)
    {
        $this->commentdate = $commentdate;

        return $this;
    }

    /**
     * Get commentdate
     *
     * @return \DateTime 
     */
    public function getCommentdate()
    {
        return $this->commentdate;
    }

    /**
     * Set commentlevel
     *
     * @param integer $commentlevel
     * @return Blogcomments
     */
    public function setCommentlevel($commentlevel)
    {
        $this->commentlevel = $commentlevel;

        return $this;
    }

    /**
     * Get commentlevel
     *
     * @return integer 
     */
    public function getCommentlevel()
    {
        return $this->commentlevel;
    }

    /**
     * Set entryid
     *
     * @param \D4D\AppBundle\Entity\Blogentries $entryid
     * @return Blogcomments
     */
    public function setEntryid(\D4D\AppBundle\Entity\Blogentries $entryid = null)
    {
        $this->entryid = $entryid;

        return $this;
    }

    /**
     * Get entryid
     *
     * @return \D4D\AppBundle\Entity\Blogentries 
     */
    public function getEntryid()
    {
        return $this->entryid;
    }
}
