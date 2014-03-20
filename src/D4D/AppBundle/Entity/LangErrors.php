<?php

namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LangErrors
 */
class LangErrors
{
    /**
     * @var integer
     */
    private $langErrorid;

    /**
     * @var integer
     */
    private $langErrornum;

    /**
     * @var string
     */
    private $langErrorname;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $langid;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->langid = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get langErrorid
     *
     * @return integer 
     */
    public function getLangErrorid()
    {
        return $this->langErrorid;
    }

    /**
     * Set langErrornum
     *
     * @param integer $langErrornum
     * @return LangErrors
     */
    public function setLangErrornum($langErrornum)
    {
        $this->langErrornum = $langErrornum;

        return $this;
    }

    /**
     * Get langErrornum
     *
     * @return integer 
     */
    public function getLangErrornum()
    {
        return $this->langErrornum;
    }

    /**
     * Set langErrorname
     *
     * @param string $langErrorname
     * @return LangErrors
     */
    public function setLangErrorname($langErrorname)
    {
        $this->langErrorname = $langErrorname;

        return $this;
    }

    /**
     * Get langErrorname
     *
     * @return string 
     */
    public function getLangErrorname()
    {
        return $this->langErrorname;
    }

    /**
     * Add langid
     *
     * @param \D4D\AppBundle\Entity\LangLanguages $langid
     * @return LangErrors
     */
    public function addLangid(\D4D\AppBundle\Entity\LangLanguages $langid)
    {
        $this->langid[] = $langid;

        return $this;
    }

    /**
     * Remove langid
     *
     * @param \D4D\AppBundle\Entity\LangLanguages $langid
     */
    public function removeLangid(\D4D\AppBundle\Entity\LangLanguages $langid)
    {
        $this->langid->removeElement($langid);
    }

    /**
     * Get langid
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLangid()
    {
        return $this->langid;
    }
}
