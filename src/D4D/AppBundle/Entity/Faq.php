<?php

namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Faq
 */
class Faq
{
    /**
     * @var integer
     */
    private $faqid;

    /**
     * @var string
     */
    private $faqq;

    /**
     * @var string
     */
    private $faqa;

    /**
     * @var \D4D\AppBundle\Entity\Faqcategory
     */
    private $faqcategoryid;


    /**
     * Get faqid
     *
     * @return integer 
     */
    public function getFaqid()
    {
        return $this->faqid;
    }

    /**
     * Set faqq
     *
     * @param string $faqq
     * @return Faq
     */
    public function setFaqq($faqq)
    {
        $this->faqq = $faqq;

        return $this;
    }

    /**
     * Get faqq
     *
     * @return string 
     */
    public function getFaqq()
    {
        return $this->faqq;
    }

    /**
     * Set faqa
     *
     * @param string $faqa
     * @return Faq
     */
    public function setFaqa($faqa)
    {
        $this->faqa = $faqa;

        return $this;
    }

    /**
     * Get faqa
     *
     * @return string 
     */
    public function getFaqa()
    {
        return $this->faqa;
    }

    /**
     * Set faqcategoryid
     *
     * @param \D4D\AppBundle\Entity\Faqcategory $faqcategoryid
     * @return Faq
     */
    public function setFaqcategoryid(\D4D\AppBundle\Entity\Faqcategory $faqcategoryid = null)
    {
        $this->faqcategoryid = $faqcategoryid;

        return $this;
    }

    /**
     * Get faqcategoryid
     *
     * @return \D4D\AppBundle\Entity\Faqcategory 
     */
    public function getFaqcategoryid()
    {
        return $this->faqcategoryid;
    }
}
