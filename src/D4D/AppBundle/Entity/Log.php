<?php

namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Log
 */
class Log
{
    /**
     * @var integer
     */
    private $logId;

    /**
     * @var string
     */
    private $log;

    /**
     * @var \DateTime
     */
    private $pdate;


    /**
     * Get logId
     *
     * @return integer 
     */
    public function getLogId()
    {
        return $this->logId;
    }

    /**
     * Set log
     *
     * @param string $log
     * @return Log
     */
    public function setLog($log)
    {
        $this->log = $log;

        return $this;
    }

    /**
     * Get log
     *
     * @return string 
     */
    public function getLog()
    {
        return $this->log;
    }

    /**
     * Set pdate
     *
     * @param \DateTime $pdate
     * @return Log
     */
    public function setPdate($pdate)
    {
        $this->pdate = $pdate;

        return $this;
    }

    /**
     * Get pdate
     *
     * @return \DateTime 
     */
    public function getPdate()
    {
        return $this->pdate;
    }
}
