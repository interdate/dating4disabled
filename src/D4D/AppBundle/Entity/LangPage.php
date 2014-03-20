<?php

namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LangPage
 */
class LangPage
{
    /**
     * @var integer
     */
    private $langPageid;

    /**
     * @var string
     */
    private $langPagename;

    /**
     * @var string
     */
    private $langPagedesc;


    /**
     * Get langPageid
     *
     * @return integer 
     */
    public function getLangPageid()
    {
        return $this->langPageid;
    }

    /**
     * Set langPagename
     *
     * @param string $langPagename
     * @return LangPage
     */
    public function setLangPagename($langPagename)
    {
        $this->langPagename = $langPagename;

        return $this;
    }

    /**
     * Get langPagename
     *
     * @return string 
     */
    public function getLangPagename()
    {
        return $this->langPagename;
    }

    /**
     * Set langPagedesc
     *
     * @param string $langPagedesc
     * @return LangPage
     */
    public function setLangPagedesc($langPagedesc)
    {
        $this->langPagedesc = $langPagedesc;

        return $this;
    }

    /**
     * Get langPagedesc
     *
     * @return string 
     */
    public function getLangPagedesc()
    {
        return $this->langPagedesc;
    }
}
