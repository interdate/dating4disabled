<?php

namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Messages2
 */
class Messages2
{
    /**
     * @var integer
     */
    private $msgid;

    /**
     * @var \DateTime
     */
    private $msgdate;

    /**
     * @var integer
     */
    private $msgfromid;

    /**
     * @var integer
     */
    private $msgtoid;

    /**
     * @var boolean
     */
    private $msgread;

    /**
     * @var string
     */
    private $msgbody;

    /**
     * @var boolean
     */
    private $msgfromdel;

    /**
     * @var boolean
     */
    private $msgtodel;


    /**
     * Get msgid
     *
     * @return integer 
     */
    public function getMsgid()
    {
        return $this->msgid;
    }

    /**
     * Set msgdate
     *
     * @param \DateTime $msgdate
     * @return Messages2
     */
    public function setMsgdate($msgdate)
    {
        $this->msgdate = $msgdate;

        return $this;
    }

    /**
     * Get msgdate
     *
     * @return \DateTime 
     */
    public function getMsgdate()
    {
        return $this->msgdate;
    }

    /**
     * Set msgfromid
     *
     * @param integer $msgfromid
     * @return Messages2
     */
    public function setMsgfromid($msgfromid)
    {
        $this->msgfromid = $msgfromid;

        return $this;
    }

    /**
     * Get msgfromid
     *
     * @return integer 
     */
    public function getMsgfromid()
    {
        return $this->msgfromid;
    }

    /**
     * Set msgtoid
     *
     * @param integer $msgtoid
     * @return Messages2
     */
    public function setMsgtoid($msgtoid)
    {
        $this->msgtoid = $msgtoid;

        return $this;
    }

    /**
     * Get msgtoid
     *
     * @return integer 
     */
    public function getMsgtoid()
    {
        return $this->msgtoid;
    }

    /**
     * Set msgread
     *
     * @param boolean $msgread
     * @return Messages2
     */
    public function setMsgread($msgread)
    {
        $this->msgread = $msgread;

        return $this;
    }

    /**
     * Get msgread
     *
     * @return boolean 
     */
    public function getMsgread()
    {
        return $this->msgread;
    }

    /**
     * Set msgbody
     *
     * @param string $msgbody
     * @return Messages2
     */
    public function setMsgbody($msgbody)
    {
        $this->msgbody = $msgbody;

        return $this;
    }

    /**
     * Get msgbody
     *
     * @return string 
     */
    public function getMsgbody()
    {
        return $this->msgbody;
    }

    /**
     * Set msgfromdel
     *
     * @param boolean $msgfromdel
     * @return Messages2
     */
    public function setMsgfromdel($msgfromdel)
    {
        $this->msgfromdel = $msgfromdel;

        return $this;
    }

    /**
     * Get msgfromdel
     *
     * @return boolean 
     */
    public function getMsgfromdel()
    {
        return $this->msgfromdel;
    }

    /**
     * Set msgtodel
     *
     * @param boolean $msgtodel
     * @return Messages2
     */
    public function setMsgtodel($msgtodel)
    {
        $this->msgtodel = $msgtodel;

        return $this;
    }

    /**
     * Get msgtodel
     *
     * @return boolean 
     */
    public function getMsgtodel()
    {
        return $this->msgtodel;
    }
}
