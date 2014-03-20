<?php

namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Adminproperties
 */
class Adminproperties
{
    /**
     * @var integer
     */
    private $propid;

    /**
     * @var string
     */
    private $propvalue;

    /**
     * @var string
     */
    private $propname;

    /**
     * @var string
     */
    private $propdesc;

    /**
     * @var string
     */
    private $propdisplaytype;

    /**
     * @var string
     */
    private $propvalueslist;

    /**
     * @var string
     */
    private $propappname;

    /**
     * @var boolean
     */
    private $changeable;

    /**
     * @var string
     */
    private $propgroup;


    /**
     * Get propid
     *
     * @return integer 
     */
    public function getPropid()
    {
        return $this->propid;
    }

    /**
     * Set propvalue
     *
     * @param string $propvalue
     * @return Adminproperties
     */
    public function setPropvalue($propvalue)
    {
        $this->propvalue = $propvalue;

        return $this;
    }

    /**
     * Get propvalue
     *
     * @return string 
     */
    public function getPropvalue()
    {
        return $this->propvalue;
    }

    /**
     * Set propname
     *
     * @param string $propname
     * @return Adminproperties
     */
    public function setPropname($propname)
    {
        $this->propname = $propname;

        return $this;
    }

    /**
     * Get propname
     *
     * @return string 
     */
    public function getPropname()
    {
        return $this->propname;
    }

    /**
     * Set propdesc
     *
     * @param string $propdesc
     * @return Adminproperties
     */
    public function setPropdesc($propdesc)
    {
        $this->propdesc = $propdesc;

        return $this;
    }

    /**
     * Get propdesc
     *
     * @return string 
     */
    public function getPropdesc()
    {
        return $this->propdesc;
    }

    /**
     * Set propdisplaytype
     *
     * @param string $propdisplaytype
     * @return Adminproperties
     */
    public function setPropdisplaytype($propdisplaytype)
    {
        $this->propdisplaytype = $propdisplaytype;

        return $this;
    }

    /**
     * Get propdisplaytype
     *
     * @return string 
     */
    public function getPropdisplaytype()
    {
        return $this->propdisplaytype;
    }

    /**
     * Set propvalueslist
     *
     * @param string $propvalueslist
     * @return Adminproperties
     */
    public function setPropvalueslist($propvalueslist)
    {
        $this->propvalueslist = $propvalueslist;

        return $this;
    }

    /**
     * Get propvalueslist
     *
     * @return string 
     */
    public function getPropvalueslist()
    {
        return $this->propvalueslist;
    }

    /**
     * Set propappname
     *
     * @param string $propappname
     * @return Adminproperties
     */
    public function setPropappname($propappname)
    {
        $this->propappname = $propappname;

        return $this;
    }

    /**
     * Get propappname
     *
     * @return string 
     */
    public function getPropappname()
    {
        return $this->propappname;
    }

    /**
     * Set changeable
     *
     * @param boolean $changeable
     * @return Adminproperties
     */
    public function setChangeable($changeable)
    {
        $this->changeable = $changeable;

        return $this;
    }

    /**
     * Get changeable
     *
     * @return boolean 
     */
    public function getChangeable()
    {
        return $this->changeable;
    }

    /**
     * Set propgroup
     *
     * @param string $propgroup
     * @return Adminproperties
     */
    public function setPropgroup($propgroup)
    {
        $this->propgroup = $propgroup;

        return $this;
    }

    /**
     * Get propgroup
     *
     * @return string 
     */
    public function getPropgroup()
    {
        return $this->propgroup;
    }
}
