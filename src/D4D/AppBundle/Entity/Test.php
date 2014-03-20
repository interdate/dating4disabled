<?php

namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Test
 */
class Test
{
    /**
     * @var integer
     */
    private $testId;

    /**
     * @var string
     */
    private $val;


    /**
     * Get testId
     *
     * @return integer 
     */
    public function getTestId()
    {
        return $this->testId;
    }

    /**
     * Set val
     *
     * @param string $val
     * @return Test
     */
    public function setVal($val)
    {
        $this->val = $val;

        return $this;
    }

    /**
     * Get val
     *
     * @return string 
     */
    public function getVal()
    {
        return $this->val;
    }
}
