<?php

namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Chats
 */
class Chats
{
    /**
     * @var integer
     */
    private $chatfromid;

    /**
     * @var \DateTime
     */
    private $chatdate;

    /**
     * @var integer
     */
    private $chattoid;


    /**
     * Get chatfromid
     *
     * @return integer 
     */
    public function getChatfromid()
    {
        return $this->chatfromid;
    }

    /**
     * Set chatdate
     *
     * @param \DateTime $chatdate
     * @return Chats
     */
    public function setChatdate($chatdate)
    {
        $this->chatdate = $chatdate;

        return $this;
    }

    /**
     * Get chatdate
     *
     * @return \DateTime 
     */
    public function getChatdate()
    {
        return $this->chatdate;
    }

    /**
     * Set chattoid
     *
     * @param integer $chattoid
     * @return Chats
     */
    public function setChattoid($chattoid)
    {
        $this->chattoid = $chattoid;

        return $this;
    }

    /**
     * Get chattoid
     *
     * @return integer 
     */
    public function getChattoid()
    {
        return $this->chattoid;
    }
}
