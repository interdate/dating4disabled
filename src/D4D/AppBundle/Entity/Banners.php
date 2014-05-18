<?php

namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Banners
 */
class Banners
{
    /**
     * @var integer
     */
    private $bannerid;

    /**
     * @var string
     */
    private $bannername;

    /**
     * @var string
     */
    private $bannerfileext;

    /**
     * @var string
     */
    private $bannerlink;

    /**
     * @var array $readAuthorisedRoles
     */
    private $bannerlocation;

    /**
     * @var boolean
     */
    private $banneractive;

    /**
     * @var integer
     */
    private $bannershowcount;

    /**
     * @var integer
     */
    private $bannerclickcount;

    /**
     * @var integer
     */
    private $bannerwidth;

    /**
     * @var integer
     */
    private $bannerheight;

    
    /**
     *
     * @access public
     */
    public function __construct()
    {        
        // your own logic
        $this->bannerlocation = array();
    }
    
    /**
     * Get bannerid
     *
     * @return integer 
     */
    public function getBannerid()
    {
        return $this->bannerid;
    }

    /**
     * Set bannername
     *
     * @param string $bannername
     * @return Banners
     */
    public function setBannername($bannername)
    {
        $this->bannername = $bannername;

        return $this;
    }

    /**
     * Get bannername
     *
     * @return string 
     */
    public function getBannername()
    {
        return $this->bannername;
    }

    /**
     * Set bannerfileext
     *
     * @param string $bannerfileext
     * @return Banners
     */
    public function setBannerfileext($bannerfileext)
    {
        $this->bannerfileext = $bannerfileext;

        return $this;
    }

    /**
     * Get bannerfileext
     *
     * @return string 
     */
    public function getBannerfileext()
    {
        return $this->bannerfileext;
    }

    /**
     * Set bannerlink
     *
     * @param string $bannerlink
     * @return Banners
     */
    public function setBannerlink($bannerlink)
    {
        $this->bannerlink = $bannerlink;

        return $this;
    }

    /**
     * Get bannerlink
     *
     * @return array 
     */
    public function getBannerlink()
    {
        return $this->bannerlink;
    }

    /**
     * Set bannerlocation
     *
     * @param array $bannerlocation
     * @return Banners
     */
    public function setBannerlocation(array $bannerlocation = null)
    {
        $this->bannerlocation = $bannerlocation;

        return $this;
    }

    /**
     * Get bannerlocation
     *
     * @return integer 
     */
    public function getBannerlocation()
    {
        return $this->bannerlocation;
    }

    /**
     * Set banneractive
     *
     * @param boolean $banneractive
     * @return Banners
     */
    public function setBanneractive($banneractive)
    {
        $this->banneractive = $banneractive;

        return $this;
    }

    /**
     * Get banneractive
     *
     * @return boolean 
     */
    public function getBanneractive()
    {
        return $this->banneractive;
    }

    /**
     * Set bannershowcount
     *
     * @param integer $bannershowcount
     * @return Banners
     */
    public function setBannershowcount($bannershowcount)
    {
        $this->bannershowcount = $bannershowcount;

        return $this;
    }

    /**
     * Get bannershowcount
     *
     * @return integer 
     */
    public function getBannershowcount()
    {
        return $this->bannershowcount;
    }

    /**
     * Set bannerclickcount
     *
     * @param integer $bannerclickcount
     * @return Banners
     */
    public function setBannerclickcount($bannerclickcount)
    {
        $this->bannerclickcount = $bannerclickcount;

        return $this;
    }

    /**
     * Get bannerclickcount
     *
     * @return integer 
     */
    public function getBannerclickcount()
    {
        return $this->bannerclickcount;
    }

    /**
     * Set bannerwidth
     *
     * @param integer $bannerwidth
     * @return Banners
     */
    public function setBannerwidth($bannerwidth)
    {
        $this->bannerwidth = $bannerwidth;

        return $this;
    }

    /**
     * Get bannerwidth
     *
     * @return integer 
     */
    public function getBannerwidth()
    {
        return $this->bannerwidth;
    }

    /**
     * Set bannerheight
     *
     * @param integer $bannerheight
     * @return Banners
     */
    public function setBannerheight($bannerheight)
    {
        $this->bannerheight = $bannerheight;

        return $this;
    }

    /**
     * Get bannerheight
     *
     * @return integer 
     */
    public function getBannerheight()
    {
        return $this->bannerheight;
    }
}
