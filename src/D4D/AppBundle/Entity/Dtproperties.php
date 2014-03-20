<?php

namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Dtproperties
 */
class Dtproperties
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $property;

    /**
     * @var integer
     */
    private $objectid;

    /**
     * @var string
     */
    private $value;

    /**
     * @var string
     */
    private $uvalue;

    /**
     * @var string
     */
    private $lvalue;

    /**
     * @var integer
     */
    private $version;


    /**
     * Set id
     *
     * @param integer $id
     * @return Dtproperties
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set property
     *
     * @param string $property
     * @return Dtproperties
     */
    public function setProperty($property)
    {
        $this->property = $property;

        return $this;
    }

    /**
     * Get property
     *
     * @return string 
     */
    public function getProperty()
    {
        return $this->property;
    }

    /**
     * Set objectid
     *
     * @param integer $objectid
     * @return Dtproperties
     */
    public function setObjectid($objectid)
    {
        $this->objectid = $objectid;

        return $this;
    }

    /**
     * Get objectid
     *
     * @return integer 
     */
    public function getObjectid()
    {
        return $this->objectid;
    }

    /**
     * Set value
     *
     * @param string $value
     * @return Dtproperties
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set uvalue
     *
     * @param string $uvalue
     * @return Dtproperties
     */
    public function setUvalue($uvalue)
    {
        $this->uvalue = $uvalue;

        return $this;
    }

    /**
     * Get uvalue
     *
     * @return string 
     */
    public function getUvalue()
    {
        return $this->uvalue;
    }

    /**
     * Set lvalue
     *
     * @param string $lvalue
     * @return Dtproperties
     */
    public function setLvalue($lvalue)
    {
        $this->lvalue = $lvalue;

        return $this;
    }

    /**
     * Get lvalue
     *
     * @return string 
     */
    public function getLvalue()
    {
        return $this->lvalue;
    }

    /**
     * Set version
     *
     * @param integer $version
     * @return Dtproperties
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Get version
     *
     * @return integer 
     */
    public function getVersion()
    {
        return $this->version;
    }
}
