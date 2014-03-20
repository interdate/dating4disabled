<?php

namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ForumPosts
 */
class ForumPosts
{
    /**
     * @var integer
     */
    private $postid;

    /**
     * @var integer
     */
    private $rootid;

    /**
     * @var integer
     */
    private $parentid;

    /**
     * @var integer
     */
    private $userid;

    /**
     * @var string
     */
    private $postsubject;

    /**
     * @var string
     */
    private $postbody;

    /**
     * @var \DateTime
     */
    private $postdate;

    /**
     * @var \DateTime
     */
    private $groupdate;

    /**
     * @var \D4D\AppBundle\Entity\ForumForums
     */
    private $forumid;


    /**
     * Get postid
     *
     * @return integer 
     */
    public function getPostid()
    {
        return $this->postid;
    }

    /**
     * Set rootid
     *
     * @param integer $rootid
     * @return ForumPosts
     */
    public function setRootid($rootid)
    {
        $this->rootid = $rootid;

        return $this;
    }

    /**
     * Get rootid
     *
     * @return integer 
     */
    public function getRootid()
    {
        return $this->rootid;
    }

    /**
     * Set parentid
     *
     * @param integer $parentid
     * @return ForumPosts
     */
    public function setParentid($parentid)
    {
        $this->parentid = $parentid;

        return $this;
    }

    /**
     * Get parentid
     *
     * @return integer 
     */
    public function getParentid()
    {
        return $this->parentid;
    }

    /**
     * Set userid
     *
     * @param integer $userid
     * @return ForumPosts
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
     * Set postsubject
     *
     * @param string $postsubject
     * @return ForumPosts
     */
    public function setPostsubject($postsubject)
    {
        $this->postsubject = $postsubject;

        return $this;
    }

    /**
     * Get postsubject
     *
     * @return string 
     */
    public function getPostsubject()
    {
        return $this->postsubject;
    }

    /**
     * Set postbody
     *
     * @param string $postbody
     * @return ForumPosts
     */
    public function setPostbody($postbody)
    {
        $this->postbody = $postbody;

        return $this;
    }

    /**
     * Get postbody
     *
     * @return string 
     */
    public function getPostbody()
    {
        return $this->postbody;
    }

    /**
     * Set postdate
     *
     * @param \DateTime $postdate
     * @return ForumPosts
     */
    public function setPostdate($postdate)
    {
        $this->postdate = $postdate;

        return $this;
    }

    /**
     * Get postdate
     *
     * @return \DateTime 
     */
    public function getPostdate()
    {
        return $this->postdate;
    }

    /**
     * Set groupdate
     *
     * @param \DateTime $groupdate
     * @return ForumPosts
     */
    public function setGroupdate($groupdate)
    {
        $this->groupdate = $groupdate;

        return $this;
    }

    /**
     * Get groupdate
     *
     * @return \DateTime 
     */
    public function getGroupdate()
    {
        return $this->groupdate;
    }

    /**
     * Set forumid
     *
     * @param \D4D\AppBundle\Entity\ForumForums $forumid
     * @return ForumPosts
     */
    public function setForumid(\D4D\AppBundle\Entity\ForumForums $forumid = null)
    {
        $this->forumid = $forumid;

        return $this;
    }

    /**
     * Get forumid
     *
     * @return \D4D\AppBundle\Entity\ForumForums 
     */
    public function getForumid()
    {
        return $this->forumid;
    }
}
