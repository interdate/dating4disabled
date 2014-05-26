<?php 

namespace D4D\AppBundle\Entity;

use Symfony\Component\Config\Definition\stringNode;
class UsersSearch extends Users
{
	/**
	 * @var string
	 */
	private $userBirthdayFrom;	
	
	/**
	 * @var string
	 */
	private $userBirthdayTo;	
	
	/**
	 * @var string
	 */
	private $paymentStartDateFrom;
	
	/**
	 * @var string
	 */
	private $paymentStartDateTo;
	
	/**
	 * @var string
	 */
	private $paymentEndDateFrom;
	
	/**
	 * @var string
	 */
	private $paymentEndDateTo;
	
	/**
	 * @var string
	 */
	private $registrationDateFrom;
	
	/**
	 * @var string
	 */
	private $registrationDateTo;
	
	/**
	 * @var string
	 */
	private $lastVisitDateFrom;
	
	/**
	 * @var string
	 */
	private $lastVisitDateTo;
	
	
	
	/**
	 * Set userBirthdayFrom
	 *
	 * @param string $userBirthdayFrom
	 * @return UsersSearch
	 */
	public function setUserBirthdayFrom($userBirthdayFrom)
	{
		$this->userBirthdayFrom = $userBirthdayFrom;
	
		return $this;
	}
	
	/**
	 * Get userBirthdayFrom
	 *
	 * @return string
	 */
	public function getUserBirthdayFrom()
	{
		return $this->userBirthdayFrom;
	}
	
	
	/**
	 * Set userBirthdayTo
	 *
	 * @param string $userBirthdayTo
	 * @return UsersSearch
	 */
	public function setUserBirthdayTo($userBirthdayTo)
	{
		$this->userBirthdayTo = $userBirthdayTo;
	
		return $this;
	}
	
	/**
	 * Get userBirthdayTo
	 *
	 * @return string
	 */
	public function getUserBirthdayTo()
	{
		return $this->userBirthdayTo;
	}
	
	
	/**
	 * Set paymentStartDateFrom
	 *
	 * @param string $paymentStartDateFrom
	 * @return UsersSearch
	 */
	public function setPaymentStartDateFrom($paymentStartDateFrom)
	{
		$this->paymentStartDateFrom = $paymentStartDateFrom;
	
		return $this;
	}
	
	/**
	 * Get paymentStartDateFrom
	 *
	 * @return string
	 */
	public function getPaymentStartDateFrom()
	{
		return $this->paymentStartDateFrom;
	}
	
	/**
	 * Set paymentStartDateTo
	 *
	 * @param string $paymentStartDateTo
	 * @return UsersSearch
	 */
	public function setPaymentStartDateTo($paymentStartDateTo)
	{
		$this->paymentStartDateTo = $paymentStartDateTo;
	
		return $this;
	}
	
	/**
	 * Get paymentStartDateTo
	 *
	 * @return string
	 */
	public function getPaymentStartDateTo()
	{
		return $this->paymentStartDateTo;
	}
	
	
	/**
	 * Set paymentEndDateFrom
	 *
	 * @param string $paymentEndDateFrom
	 * @return UsersSearch
	 */
	public function setPaymentEndDateFrom($paymentEndDateFrom)
	{
		$this->paymentEndDateFrom = $paymentEndDateFrom;
	
		return $this;
	}
	
	/**
	 * Get paymentEndDateFrom
	 *
	 * @return string
	 */
	public function getPaymentEndDateFrom()
	{
		return $this->paymentEndDateFrom;
	}
	
	
	/**
	* Set paymentEndDateTo
	*
	* @param string $paymentEndDateTo
	* @return UsersSearch
	*/
	public function setPaymentEndDateTo($paymentEndDateTo)
	{
		$this->paymentEndDateTo = $paymentEndDateTo;
	
		return $this;
	}
	
	/**
	 * Get paymentEndDateTo
	 *
	 * @return string
	 */
	public function getPaymentEndDateTo()
	{
		return $this->paymentEndDateTo;
	}
	
	
	/**
	 * Set registrationDateFrom
	 *
	 * @param string $registrationDateFrom
	 * @return UsersSearch
	 */
	public function setRegistrationDateFrom($registrationDateFrom)
	{
		$this->registrationDateFrom = $registrationDateFrom;
	
		return $this;
	}
	
	/**
	 * Get registrationDateFrom
	 *
	 * @return string
	 */
	public function getRegistrationDateFrom()
	{
		return $this->registrationDateFrom;
	}
	
	
	
	/**
	 * Set registrationDateTo
	 *
	 * @param string $registrationDateTo
	 * @return UsersSearch
	 */
	public function setRegistrationDateTo($registrationDateTo)
	{
		$this->registrationDateTo = $registrationDateTo;
	
		return $this;
	}
	
	/**
	 * Get registrationDateTo
	 *
	 * @return string
	 */
	public function getRegistrationDateTo()
	{
		return $this->registrationDateTo;
	}
	
	
	
	
	/**
	 * Set lastVisitDateFrom
	 *
	 * @param string $lastVisitDateFrom
	 * @return UsersSearch
	 */
	public function setLastVisitDateFrom($lastVisitDateFrom)
	{
		$this->lastVisitDateFrom = $lastVisitDateFrom;
	
		return $this;
	}
	
	/**
	 * Get lastVisitDateFrom
	 *
	 * @return string
	 */
	public function getLastVisitDateFrom()
	{
		return $this->lastVisitDateFrom;
	}
	
	
	/**
	 * Set lastVisitDateTo
	 *
	 * @param string $lastVisitDateTo
	 * @return UsersSearch
	 */
	public function setLastVisitDateTo($lastVisitDateTo)
	{
		$this->lastVisitDateTo = $lastVisitDateTo;
	
		return $this;
	}
	
	/**
	 * Get lastVisitDateTo  
	 *
	 * @return string
	 */
	public function getLastVisitDateTo()
	{
		return $this->lastVisitDateTo;
	}
	
	
	
	
}