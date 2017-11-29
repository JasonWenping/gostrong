<?php

namespace Gost\Bundle\SiteManagerBundle\Repository;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

use Gost\Common\Utils\Validator;
use Gost\Bundle\BaseBundle\Component\BaseEntityRepository;
use Gost\Bundle\SiteManagerBundle\Entity\MUser;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * 后台用户对象数据仓库类
 *
 * @author devy
 *        
 */
class MUserRepository extends BaseEntityRepository implements UserProviderInterface {
	
	/**
	 * 查找所属角色用户
	 *
	 * @param string $role
	 * @return ArrayCollection
	 */
	public function findUsersByRole($role) {
		return $this->createQueryBuilder('u')
				->leftJoin('u.userRoles', 'r')
				->select('u')
				->where('r.name = :role')
				->setParameter('role', $role)
				->getQuery()
				->getResult();
	}

	/**
	 * 获取用户
	 *
	 * @param string $username
	 * @return MUser|null
	 */
	public function findUser($username) {
		$qb = $this->createQueryBuilder('p')
				->select('p')
				->where('p.username LIKE :username')
				->setParameter('username', $username);
		if (Validator::is_email($username)) {
			$qb->orWhere('p.email LIKE :username');;
		}
		return $qb->getQuery()->getOneOrNullResult();
	}
	
	/**
	 * @see \Symfony\Component\Security\Core\User\UserProviderInterface::loadUserByUsername()
	 */
	public function loadUserByUsername($username) {
		$qb = $this->createQueryBuilder('p')
				->select('p')
				->where('p.isBlocked = :false')
				->setParameter('false', false);
		$where = 'p.username LIKE :username';
		if (Validator::is_email($username)) {
			$where .= ' OR p.email LIKE :username';
		}
		return $qb->andWhere($where)
				->setParameter('username', $username)
				->getQuery()
				->getOneOrNullResult();
	}
	
	/**
	 * @see \Symfony\Component\Security\Core\User\UserProviderInterface::refreshUser()
	 */
	public function refreshUser(UserInterface $user) {
		return $this->loadUserByUsername($user->getUsername());
	}
	
	/**
	 * @see \Symfony\Component\Security\Core\User\UserProviderInterface::supportsClass()
	 */
	public function supportsClass($class) {
		return $class === 'Gost\Bundle\SiteManagerBundle\Entity\MUser';
	}
}