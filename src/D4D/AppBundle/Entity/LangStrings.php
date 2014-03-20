<?php

namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LangStrings
 */
class LangStrings
{
    /**
     * @var integer
     */
    private $langStringid;

    /**
     * @var string
     */
    private $langStringname;

    /**
     * @var \D4D\AppBundle\Entity\LangPage
     */
    private $langPageid;

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
     * Get langStringid
     *
     * @return integer 
     */
    public function getLangStringid()
    {
        return $this->langStringid;
    }

    /**
     * Set langStringname
     *
     * @param string $langStringname
     * @return LangStrings
     */
    public function setLangStringname($langStringname)
    {
        $this->langStringname = $langStringname;

        return $this;
    }

    /**
     * Get langStringname
     *
     * @return string 
     */
    public function getLangStringname()
    {
        return $this->langStringname;
    }

    /**
     * Set langPageid
     *
     * @param \D4D\AppBundle\Entity\LangPage $langPageid
     * @return LangStrings
     */
    public function setLangPageid(\D4D\AppBundle\Entity\LangPage $langPageid = null)
    {
        $this->langPageid = $langPageid;

        return $this;
    }

    /**
     * Get langPageid
     *
     * @return \D4D\AppBundle\Entity\LangPage 
     */
    public function getLangPageid()
    {
        return $this->langPageid;
    }

    /**
     * Add langid
     *
     * @param \D4D\AppBundle\Entity\LangLanguages $langid
     * @return LangStrings
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
