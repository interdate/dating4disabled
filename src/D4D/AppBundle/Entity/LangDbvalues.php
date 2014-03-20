<?php

namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LangDbvalues
 */
class LangDbvalues
{
    /**
     * @var string
     */
    private $tablename;

    /**
     * @var integer
     */
    private $valueid;

    /**
     * @var string
     */
    private $valuename;

    /**
     * @var \D4D\AppBundle\Entity\LangLanguages
     */
    private $langid;


    /**
     * Set tablename
     *
     * @param string $tablename
     * @return LangDbvalues
     */
    public function setTablename($tablename)
    {
        $this->tablename = $tablename;

        return $this;
    }

    /**
     * Get tablename
     *
     * @return string 
     */
    public function getTablename()
    {
        return $this->tablename;
    }

    /**
     * Set valueid
     *
     * @param integer $valueid
     * @return LangDbvalues
     */
    public function setValueid($valueid)
    {
        $this->valueid = $valueid;

        return $this;
    }

    /**
     * Get valueid
     *
     * @return integer 
     */
    public function getValueid()
    {
        return $this->valueid;
    }

    /**
     * Set valuename
     *
     * @param string $valuename
     * @return LangDbvalues
     */
    public function setValuename($valuename)
    {
        $this->valuename = $valuename;

        return $this;
    }

    /**
     * Get valuename
     *
     * @return string 
     */
    public function getValuename()
    {
        return $this->valuename;
    }

    /**
     * Set langid
     *
     * @param \D4D\AppBundle\Entity\LangLanguages $langid
     * @return LangDbvalues
     */
    public function setLangid(\D4D\AppBundle\Entity\LangLanguages $langid = null)
    {
        $this->langid = $langid;

        return $this;
    }

    /**
     * Get langid
     *
     * @return \D4D\AppBundle\Entity\LangLanguages 
     */
    public function getLangid()
    {
        return $this->langid;
    }
}
