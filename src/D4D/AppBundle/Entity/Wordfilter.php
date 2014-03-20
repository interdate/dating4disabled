<?php

namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Wordfilter
 */
class Wordfilter
{
    /**
     * @var integer
     */
    private $wordfilterid;

    /**
     * @var string
     */
    private $wordfiltername;

    /**
     * @var boolean
     */
    private $isglobal;

    /**
     * @var boolean
     */
    private $ismessages;

    /**
     * @var boolean
     */
    private $ischat;

    /**
     * @var boolean
     */
    private $isforum;


    /**
     * Get wordfilterid
     *
     * @return integer 
     */
    public function getWordfilterid()
    {
        return $this->wordfilterid;
    }

    /**
     * Set wordfiltername
     *
     * @param string $wordfiltername
     * @return Wordfilter
     */
    public function setWordfiltername($wordfiltername)
    {
        $this->wordfiltername = $wordfiltername;

        return $this;
    }

    /**
     * Get wordfiltername
     *
     * @return string 
     */
    public function getWordfiltername()
    {
        return $this->wordfiltername;
    }

    /**
     * Set isglobal
     *
     * @param boolean $isglobal
     * @return Wordfilter
     */
    public function setIsglobal($isglobal)
    {
        $this->isglobal = $isglobal;

        return $this;
    }

    /**
     * Get isglobal
     *
     * @return boolean 
     */
    public function getIsglobal()
    {
        return $this->isglobal;
    }

    /**
     * Set ismessages
     *
     * @param boolean $ismessages
     * @return Wordfilter
     */
    public function setIsmessages($ismessages)
    {
        $this->ismessages = $ismessages;

        return $this;
    }

    /**
     * Get ismessages
     *
     * @return boolean 
     */
    public function getIsmessages()
    {
        return $this->ismessages;
    }

    /**
     * Set ischat
     *
     * @param boolean $ischat
     * @return Wordfilter
     */
    public function setIschat($ischat)
    {
        $this->ischat = $ischat;

        return $this;
    }

    /**
     * Get ischat
     *
     * @return boolean 
     */
    public function getIschat()
    {
        return $this->ischat;
    }

    /**
     * Set isforum
     *
     * @param boolean $isforum
     * @return Wordfilter
     */
    public function setIsforum($isforum)
    {
        $this->isforum = $isforum;

        return $this;
    }

    /**
     * Get isforum
     *
     * @return boolean 
     */
    public function getIsforum()
    {
        return $this->isforum;
    }
}
