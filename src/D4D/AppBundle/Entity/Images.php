<?php

namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Images
 */
class Images
{
    /**
     * @var integer
     */
    private $imgid;

    /**
     * @var boolean
     */
    private $imgmain;

    /**
     * @var boolean
     */
    private $imgvalidated;
    
    /**
     * @var \D4D\AppBundle\Entity\Users
     */
    private $userid;
    
    /**
     * @var boolean
     */
    private $homepage;
    
    
    
    
    
    
    
    
    
    
    /**
     * Image path
     *
     * @var string
     *
     * @ORM\Column(type="text", length=255, nullable=false)
     */
    protected $path;
    
    
    /**
     * Image file
     *
     * @var File
     *
     * @Assert\File(
     *     maxSize = "5M",
     *     mimeTypes = {"image/jpeg", "image/gif", "image/png", "image/tiff"},
     *     maxSizeMessage = "The maxmimum allowed file size is 5MB.",
     *     mimeTypesMessage = "Only the filetypes image are allowed."
     * )
     */
    protected $file;
    
    
    
    
    
    
    
    


    /**
     * Get imgid
     *
     * @return integer 
     */
    public function getImgid()
    {
        return $this->imgid;
    }

    /**
     * Set imgmain
     *
     * @param boolean $imgmain
     * @return Images
     */
    public function setImgmain($imgmain)
    {
        $this->imgmain = $imgmain;

        return $this;
    }

    /**
     * Get imgmain
     *
     * @return boolean 
     */
    public function getImgmain()
    {
        return $this->imgmain;
    }

    /**
     * Set imgvalidated
     *
     * @param boolean $imgvalidated
     * @return Images
     */
    public function setImgvalidated($imgvalidated)
    {
        $this->imgvalidated = $imgvalidated;

        return $this;
    }

    /**
     * Get imgvalidated
     *
     * @return boolean 
     */
    public function getImgvalidated()
    {
        return $this->imgvalidated;
    }

    /**
     * Set userid
     *
     * @param \D4D\AppBundle\Entity\Users $userid
     * @return Images
     */
    public function setUserid(\D4D\AppBundle\Entity\Users $userid = null)
    {
        $this->userid = $userid;

        return $this;
    }

    /**
     * Get userid
     *
     * @return \D4D\AppBundle\Entity\Users 
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * Set homepage
     *
     * @param boolean $homepage
     * @return Images
     */
    public function setHomepage($homepage)
    {
        $this->homepage = $homepage;

        return $this;
    }

    /**
     * Get homepage
     *
     * @return boolean 
     */
    public function getHomepage()
    {
        return $this->homepage;
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
      
    
    
    
    /**
     * Called before saving the entity
     *
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
    	if (null !== $this->file) {
    		// do whatever you want to generate a unique name
    		$filename = sha1(uniqid(mt_rand(), true));
    		$this->path = $filename.'.'.$this->file->guessExtension();
    	}
    }
    
    
    /**
     * Called before entity removal
     *
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
    	if ($file = $this->getAbsolutePath()) {
    		unlink($file);
    	}
    }
    
    
    /**
     * Called after entity persistence
     *
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
    	// the file property can be empty if the field is not required
    	if (null === $this->file) {
    		return;
    	}
    
    	// use the original file name here but you should
    	// sanitize it at least to avoid any security issues
    
    	// move takes the target directory and then the
    	// target filename to move to
    	$this->file->move(
    			$this->getUploadRootDir(),
    			$this->path
    	);
    
    	// set the path property to the filename where you've saved the file
    	//$this->path = $this->file->getClientOriginalName();
    
    	// clean up the file property as you won't need it anymore
    	$this->file = null;
    }   
    
    
    /**
     * Set path
     *
     * @param string $path
     * @return Image
     */
    public function setPath($path)
    {
    	$this->path = $path;
    
    	return $this;
    }
    
    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
    	return $this->path;
    }
    
    
    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
    	$this->file = $file;
    }
    
    
    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
    	return $this->file;
    }
    
    
    
    
    
    
    
    public function getAbsolutePath()
    {
    	return null === $this->path
    	? null
    	: $this->getUploadRootDir().'/'.$this->path;
    }
    
    public function getWebPath()
    {
    	return null === $this->path
    	? null
    	: $this->getUploadDir().'/'.$this->path;
    }
    
    protected function getUploadRootDir()
    {
    	// the absolute directory path where uploaded
    	// documents should be saved
    	return __DIR__.'/../../../../uploads/'.$this->getUploadDir();
    }
    
    protected function getUploadDir()
    {
    	// get rid of the __DIR__ so it doesn't screw up
    	// when displaying uploaded doc/image in the view.
    	return 'userpics';
    }
    
    
    
    
    
    
    
    
    
    
    
    
}
