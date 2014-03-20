<?php

namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Affiliate
 */
class Affiliate
{
    /**
     * @var integer
     */
    private $affiliateid;

    /**
     * @var string
     */
    private $affiliatename;

    /**
     * @var string
     */
    private $affiliatepass;

    /**
     * @var string
     */
    private $affiliatesite;

    /**
     * @var string
     */
    private $affiliatecontactname;

    /**
     * @var string
     */
    private $affiliatecontactinfo;

    /**
     * @var string
     */
    private $affiliatecomments;

    /**
     * @var integer
     */
    private $affiliatecount;


    /**
     * Get affiliateid
     *
     * @return integer 
     */
    public function getAffiliateid()
    {
        return $this->affiliateid;
    }

    /**
     * Set affiliatename
     *
     * @param string $affiliatename
     * @return Affiliate
     */
    public function setAffiliatename($affiliatename)
    {
        $this->affiliatename = $affiliatename;

        return $this;
    }

    /**
     * Get affiliatename
     *
     * @return string 
     */
    public function getAffiliatename()
    {
        return $this->affiliatename;
    }

    /**
     * Set affiliatepass
     *
     * @param string $affiliatepass
     * @return Affiliate
     */
    public function setAffiliatepass($affiliatepass)
    {
        $this->affiliatepass = $affiliatepass;

        return $this;
    }

    /**
     * Get affiliatepass
     *
     * @return string 
     */
    public function getAffiliatepass()
    {
        return $this->affiliatepass;
    }

    /**
     * Set affiliatesite
     *
     * @param string $affiliatesite
     * @return Affiliate
     */
    public function setAffiliatesite($affiliatesite)
    {
        $this->affiliatesite = $affiliatesite;

        return $this;
    }

    /**
     * Get affiliatesite
     *
     * @return string 
     */
    public function getAffiliatesite()
    {
        return $this->affiliatesite;
    }

    /**
     * Set affiliatecontactname
     *
     * @param string $affiliatecontactname
     * @return Affiliate
     */
    public function setAffiliatecontactname($affiliatecontactname)
    {
        $this->affiliatecontactname = $affiliatecontactname;

        return $this;
    }

    /**
     * Get affiliatecontactname
     *
     * @return string 
     */
    public function getAffiliatecontactname()
    {
        return $this->affiliatecontactname;
    }

    /**
     * Set affiliatecontactinfo
     *
     * @param string $affiliatecontactinfo
     * @return Affiliate
     */
    public function setAffiliatecontactinfo($affiliatecontactinfo)
    {
        $this->affiliatecontactinfo = $affiliatecontactinfo;

        return $this;
    }

    /**
     * Get affiliatecontactinfo
     *
     * @return string 
     */
    public function getAffiliatecontactinfo()
    {
        return $this->affiliatecontactinfo;
    }

    /**
     * Set affiliatecomments
     *
     * @param string $affiliatecomments
     * @return Affiliate
     */
    public function setAffiliatecomments($affiliatecomments)
    {
        $this->affiliatecomments = $affiliatecomments;

        return $this;
    }

    /**
     * Get affiliatecomments
     *
     * @return string 
     */
    public function getAffiliatecomments()
    {
        return $this->affiliatecomments;
    }

    /**
     * Set affiliatecount
     *
     * @param integer $affiliatecount
     * @return Affiliate
     */
    public function setAffiliatecount($affiliatecount)
    {
        $this->affiliatecount = $affiliatecount;

        return $this;
    }

    /**
     * Get affiliatecount
     *
     * @return integer 
     */
    public function getAffiliatecount()
    {
        return $this->affiliatecount;
    }
}
