<?php 

namespace D4D\AppBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\Tools\Pagination\Paginator;

class UsersRepository extends EntityRepository implements UserProviderInterface
{
	public function loadUserByUsername($username)
	{
		$q = $this
		->createQueryBuilder('u')
		->where('u.username = :username')		
		->setParameter('username', $username)
		->getQuery()
		;

		try {
			// The Query::getSingleResult() method throws an exception
			// if there is no record matching the criteria.
			$user = $q->getSingleResult();
		} catch (NoResultException $e) {
			$message = sprintf(
					'Unable to find an active admin OkDealAdminBundle:User object identified by "%s".',
					$username
			);
			throw new UsernameNotFoundException($message, 0, $e);
		}

		return $user;
	}

	public function refreshUser(UserInterface $user)
	{
		$class = get_class($user);
		if (!$this->supportsClass($class)) {
			throw new UnsupportedUserException(
					sprintf(
							'Instances of "%s" are not supported.',
							$class
					)
			);
		}

		return $this->find($user->getId());
	}

	public function supportsClass($class)
	{
		return $this->getEntityName() === $class
		|| is_subclass_of($class, $this->getEntityName());
	}
	
	
	public function findCustomersByName($name){
		$query = $this->createQueryBuilder('c')
			->where('c.firstName LIKE :firstName')
			->orWhere('c.lastName LIKE :lastName')
			->setParameter('firstName', '%' . $name . '%')
			->setParameter('lastName', '%' . $name . '%')
			->getQuery();
		
		return $query->getResult();
	}

	public function findByFilter($filter, $paginator){
		if(!$filter)
			$filter = 'total';
		
		switch ($value){
			case 'total':
				
				$em    = $this->get('doctrine.orm.entity_manager');
				$dql   = "SELECT u FROM D4DAppBundle:Users u";
				$query = $em->createQuery($dql);
				 
				$paginator  = $this->get('knp_paginator');
				$users = $paginator->paginate(
					$query,
					$this->get('request')->query->get('page', 1), /*page number*/
					20 /*limit per page*/
				);				 
				 
				break;
		
			case 'male':
				break;
		}

		return $users;
		
	}
	
	
}