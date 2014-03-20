<?php

namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ForumModerators
 */
class ForumModerators
{
    /**
     * @var integer
     */
    private $userid;

    /**
     * @var \D4D\AppBundle\Entity\ForumForums
     */
    private $forumid;


    /**
     * Set userid
     *
     * @param integer $userid
     * @return ForumModerators
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
     * Set forumid
     *
     * @param \D4D\AppBundle\Entity\ForumForums $forumid
     * @return ForumModerators
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
