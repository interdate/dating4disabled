<?php

namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * News
 */
class News
{
    /**
     * @var integer
     */
    private $newsitemid;

    /**
     * @var string
     */
    private $newsitemsubject;

    /**
     * @var string
     */
    private $newsitembody;

    /**
     * @var \DateTime
     */
    private $newsitemdate;

    /**
     * @var \D4D\AppBundle\Entity\LangLanguages
     */
    private $langid;


    /**
     * Get newsitemid
     *
     * @return integer 
     */
    public function getNewsitemid()
    {
        return $this->newsitemid;
    }

    /**
     * Set newsitemsubject
     *
     * @param string $newsitemsubject
     * @return News
     */
    public function setNewsitemsubject($newsitemsubject)
    {
        $this->newsitemsubject = $newsitemsubject;

        return $this;
    }

    /**
     * Get newsitemsubject
     *
     * @return string 
     */
    public function getNewsitemsubject()
    {
        return $this->newsitemsubject;
    }

    /**
     * Set newsitembody
     *
     * @param string $newsitembody
     * @return News
     */
    public function setNewsitembody($newsitembody)
    {
        $this->newsitembody = $newsitembody;

        return $this;
    }

    /**
     * Get newsitembody
     *
     * @return string 
     */
    public function getNewsitembody()
    {
        return $this->newsitembody;
    }

    /**
     * Set newsitemdate
     *
     * @param \DateTime $newsitemdate
     * @return News
     */
    public function setNewsitemdate($newsitemdate)
    {
        $this->newsitemdate = $newsitemdate;

        return $this;
    }

    /**
     * Get newsitemdate
     *
     * @return \DateTime 
     */
    public function getNewsitemdate()
    {
        return $this->newsitemdate;
    }

    /**
     * Set langid
     *
     * @param \D4D\AppBundle\Entity\LangLanguages $langid
     * @return News
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
