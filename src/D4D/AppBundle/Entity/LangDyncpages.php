<?php

namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LangDyncpages
 * @ORM\Entity(repositoryClass="D4D\AppBundle\Entity\LangDyncpagesRepository")
 */
class LangDyncpages
{
    /**
     * @var integer
     */
    private $pageid;

    /**
     * @var string
     */
    private $pagename;

    /**
     * @var string
     */
    private $pagetitle;

    /**
     * @var string
     */
    private $pagebody;

    /**
     * @var string
     */
    private $pagetype;

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
     * Get pageid
     *
     * @return integer 
     */
    public function getPageid()
    {
        return $this->pageid;
    }

    /**
     * Set pagename
     *
     * @param string $pagename
     * @return LangDyncpages
     */
    public function setPagename($pagename)
    {
        $this->pagename = $pagename;

        return $this;
    }

    /**
     * Get pagename
     *
     * @return string 
     */
    public function getPagename()
    {
        return $this->pagename;
    }

    /**
     * Set pagetitle
     *
     * @param string $pagetitle
     * @return LangDyncpages
     */
    public function setPagetitle($pagetitle)
    {
        $this->pagetitle = $pagetitle;

        return $this;
    }

    /**
     * Get pagetitle
     *
     * @return string 
     */
    public function getPagetitle()
    {
        return $this->pagetitle;
    }

    /**
     * Set pagebody
     *
     * @param string $pagebody
     * @return LangDyncpages
     */
    public function setPagebody($pagebody)
    {
        $this->pagebody = $pagebody;

        return $this;
    }

    /**
     * Get pagebody
     *
     * @return string 
     */
    public function getPagebody()
    {
        return $this->pagebody;
    }

    /**
     * Set pagetype
     *
     * @param string $pagetype
     * @return LangDyncpages
     */
    public function setPagetype($pagetype)
    {
        $this->pagetype = $pagetype;

        return $this;
    }

    /**
     * Get pagetype
     *
     * @return string 
     */
    public function getPagetype()
    {
        return $this->pagetype;
    }

    /**
     * Add langid
     *
     * @param \D4D\AppBundle\Entity\LangLanguages $langid
     * @return LangDyncpages
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
