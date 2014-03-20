<?php

namespace D4D\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PaymentsPayment
 */
class PaymentsPayment
{
    /**
     * @var integer
     */
    private $paymentid;

    /**
     * @var \DateTime
     */
    private $paymentdate;

    /**
     * @var integer
     */
    private $productid;

    /**
     * @var string
     */
    private $amount;

    /**
     * @var string
     */
    private $tranzilaindex;

    /**
     * @var integer
     */
    private $userid;

    /**
     * @var integer
     */
    private $numofmonths;


    /**
     * Get paymentid
     *
     * @return integer 
     */
    public function getPaymentid()
    {
        return $this->paymentid;
    }

    /**
     * Set paymentdate
     *
     * @param \DateTime $paymentdate
     * @return PaymentsPayment
     */
    public function setPaymentdate($paymentdate)
    {
        $this->paymentdate = $paymentdate;

        return $this;
    }

    /**
     * Get paymentdate
     *
     * @return \DateTime 
     */
    public function getPaymentdate()
    {
        return $this->paymentdate;
    }

    /**
     * Set productid
     *
     * @param integer $productid
     * @return PaymentsPayment
     */
    public function setProductid($productid)
    {
        $this->productid = $productid;

        return $this;
    }

    /**
     * Get productid
     *
     * @return integer 
     */
    public function getProductid()
    {
        return $this->productid;
    }

    /**
     * Set amount
     *
     * @param string $amount
     * @return PaymentsPayment
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return string 
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set tranzilaindex
     *
     * @param string $tranzilaindex
     * @return PaymentsPayment
     */
    public function setTranzilaindex($tranzilaindex)
    {
        $this->tranzilaindex = $tranzilaindex;

        return $this;
    }

    /**
     * Get tranzilaindex
     *
     * @return string 
     */
    public function getTranzilaindex()
    {
        return $this->tranzilaindex;
    }

    /**
     * Set userid
     *
     * @param integer $userid
     * @return PaymentsPayment
     */
    public function setUserid($userid)
    {
        $this->userid = $userid;

        return $this;
    }

    /**
     * Get userid
     *
     * @return integer 
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * Set numofmonths
     *
     * @param integer $numofmonths
     * @return PaymentsPayment
     */
    public function setNumofmonths($numofmonths)
    {
        $this->numofmonths = $numofmonths;

        return $this;
    }

    /**
     * Get numofmonths
     *
     * @return integer 
     */
    public function getNumofmonths()
    {
        return $this->numofmonths;
    }
}
