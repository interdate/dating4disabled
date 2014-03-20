<?php

namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Faqcategory
 */
class Faqcategory
{
    /**
     * @var integer
     */
    private $faqcategoryid;

    /**
     * @var string
     */
    private $faqcategoryname;

    /**
     * @var \D4D\AppBundle\Entity\LangLanguages
     */
    private $langid;


    /**
     * Get faqcategoryid
     *
     * @return integer 
     */
    public function getFaqcategoryid()
    {
        return $this->faqcategoryid;
    }

    /**
     * Set faqcategoryname
     *
     * @param string $faqcategoryname
     * @return Faqcategory
     */
    public function setFaqcategoryname($faqcategoryname)
    {
        $this->faqcategoryname = $faqcategoryname;

        return $this;
    }

    /**
     * Get faqcategoryname
     *
     * @return string 
     */
    public function getFaqcategoryname()
    {
        return $this->faqcategoryname;
    }

    /**
     * Set langid
     *
     * @param \D4D\AppBundle\Entity\LangLanguages $langid
     * @return Faqcategory
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
