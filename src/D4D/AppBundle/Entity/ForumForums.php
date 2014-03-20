<?php

namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ForumForums
 */
class ForumForums
{
    /**
     * @var integer
     */
    private $forumid;

    /**
     * @var string
     */
    private $forumname;

    /**
     * @var string
     */
    private $forumdesc;

    /**
     * @var integer
     */
    private $forumorderby;


    /**
     * Get forumid
     *
     * @return integer 
     */
    public function getForumid()
    {
        return $this->forumid;
    }

    /**
     * Set forumname
     *
     * @param string $forumname
     * @return ForumForums
     */
    public function setForumname($forumname)
    {
        $this->forumname = $forumname;

        return $this;
    }

    /**
     * Get forumname
     *
     * @return string 
     */
    public function getForumname()
    {
        return $this->forumname;
    }

    /**
     * Set forumdesc
     *
     * @param string $forumdesc
     * @return ForumForums
     */
    public function setForumdesc($forumdesc)
    {
        $this->forumdesc = $forumdesc;

        return $this;
    }

    /**
     * Get forumdesc
     *
     * @return string 
     */
    public function getForumdesc()
    {
        return $this->forumdesc;
    }

    /**
     * Set forumorderby
     *
     * @param integer $forumorderby
     * @return ForumForums
     */
    public function setForumorderby($forumorderby)
    {
        $this->forumorderby = $forumorderby;

        return $this;
    }

    /**
     * Get forumorderby
     *
     * @return integer 
     */
    public function getForumorderby()
    {
        return $this->forumorderby;
    }
}
