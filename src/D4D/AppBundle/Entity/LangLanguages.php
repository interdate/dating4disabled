<?php

namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LangLanguages
 */
class LangLanguages
{
    /**
     * @var integer
     */
    private $langid;

    /**
     * @var string
     */
    private $langnameenglish;

    /**
     * @var string
     */
    private $langnamenative;

    /**
     * @var string
     */
    private $langcodepage;

    /**
     * @var string
     */
    private $langcode;

    /**
     * @var string
     */
    private $langdir;

    /**
     * @var integer
     */
    private $langstatus;

    /**
     * @var boolean
     */
    private $langdefault;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $pageid;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $langErrorid;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $langStringid;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->pageid = new \Doctrine\Common\Collections\ArrayCollection();
        $this->langErrorid = new \Doctrine\Common\Collections\ArrayCollection();
        $this->langStringid = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get langid
     *
     * @return integer 
     */
    public function getLangid()
    {
        return $this->langid;
    }

    /**
     * Set langnameenglish
     *
     * @param string $langnameenglish
     * @return LangLanguages
     */
    public function setLangnameenglish($langnameenglish)
    {
        $this->langnameenglish = $langnameenglish;

        return $this;
    }

    /**
     * Get langnameenglish
     *
     * @return string 
     */
    public function getLangnameenglish()
    {
        return $this->langnameenglish;
    }

    /**
     * Set langnamenative
     *
     * @param string $langnamenative
     * @return LangLanguages
     */
    public function setLangnamenative($langnamenative)
    {
        $this->langnamenative = $langnamenative;

        return $this;
    }

    /**
     * Get langnamenative
     *
     * @return string 
     */
    public function getLangnamenative()
    {
        return $this->langnamenative;
    }

    /**
     * Set langcodepage
     *
     * @param string $langcodepage
     * @return LangLanguages
     */
    public function setLangcodepage($langcodepage)
    {
        $this->langcodepage = $langcodepage;

        return $this;
    }

    /**
     * Get langcodepage
     *
     * @return string 
     */
    public function getLangcodepage()
    {
        return $this->langcodepage;
    }

    /**
     * Set langcode
     *
     * @param string $langcode
     * @return LangLanguages
     */
    public function setLangcode($langcode)
    {
        $this->langcode = $langcode;

        return $this;
    }

    /**
     * Get langcode
     *
     * @return string 
     */
    public function getLangcode()
    {
        return $this->langcode;
    }

    /**
     * Set langdir
     *
     * @param string $langdir
     * @return LangLanguages
     */
    public function setLangdir($langdir)
    {
        $this->langdir = $langdir;

        return $this;
    }

    /**
     * Get langdir
     *
     * @return string 
     */
    public function getLangdir()
    {
        return $this->langdir;
    }

    /**
     * Set langstatus
     *
     * @param integer $langstatus
     * @return LangLanguages
     */
    public function setLangstatus($langstatus)
    {
        $this->langstatus = $langstatus;

        return $this;
    }

    /**
     * Get langstatus
     *
     * @return integer 
     */
    public function getLangstatus()
    {
        return $this->langstatus;
    }

    /**
     * Set langdefault
     *
     * @param boolean $langdefault
     * @return LangLanguages
     */
    public function setLangdefault($langdefault)
    {
        $this->langdefault = $langdefault;

        return $this;
    }

    /**
     * Get langdefault
     *
     * @return boolean 
     */
    public function getLangdefault()
    {
        return $this->langdefault;
    }

    /**
     * Add pageid
     *
     * @param \D4D\AppBundle\Entity\LangDyncpages $pageid
     * @return LangLanguages
     */
    public function addPageid(\D4D\AppBundle\Entity\LangDyncpages $pageid)
    {
        $this->pageid[] = $pageid;

        return $this;
    }

    /**
     * Remove pageid
     *
     * @param \D4D\AppBundle\Entity\LangDyncpages $pageid
     */
    public function removePageid(\D4D\AppBundle\Entity\LangDyncpages $pageid)
    {
        $this->pageid->removeElement($pageid);
    }

    /**
     * Get pageid
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPageid()
    {
        return $this->pageid;
    }

    /**
     * Add langErrorid
     *
     * @param \D4D\AppBundle\Entity\LangErrors $langErrorid
     * @return LangLanguages
     */
    public function addLangErrorid(\D4D\AppBundle\Entity\LangErrors $langErrorid)
    {
        $this->langErrorid[] = $langErrorid;

        return $this;
    }

    /**
     * Remove langErrorid
     *
     * @param \D4D\AppBundle\Entity\LangErrors $langErrorid
     */
    public function removeLangErrorid(\D4D\AppBundle\Entity\LangErrors $langErrorid)
    {
        $this->langErrorid->removeElement($langErrorid);
    }

    /**
     * Get langErrorid
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLangErrorid()
    {
        return $this->langErrorid;
    }

    /**
     * Add langStringid
     *
     * @param \D4D\AppBundle\Entity\LangStrings $langStringid
     * @return LangLanguages
     */
    public function addLangStringid(\D4D\AppBundle\Entity\LangStrings $langStringid)
    {
        $this->langStringid[] = $langStringid;

        return $this;
    }

    /**
     * Remove langStringid
     *
     * @param \D4D\AppBundle\Entity\LangStrings $langStringid
     */
    public function removeLangStringid(\D4D\AppBundle\Entity\LangStrings $langStringid)
    {
        $this->langStringid->removeElement($langStringid);
    }

    /**
     * Get langStringid
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLangStringid()
    {
        return $this->langStringid;
    }
}
