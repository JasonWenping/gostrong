<?php

namespace Gost\Bundle\SiteManagerBundle\Repository;

use Gost\Common\Utils\ArrayUtils;
use Gost\Bundle\BaseBundle\Component\BaseEntityRepository;
use Gost\Bundle\SiteManagerBundle\Entity\MPermission;
use Gost\Bundle\SiteManagerBundle\Entity\MFunc;
use Gost\Bundle\SiteManagerBundle\Entity\MUser;
use Gost\Bundle\SiteManagerBundle\Entity\MRole;

/**
 * 权限对象数据仓库类
 *
 * @author devy
 *        
 */
class MPermissionRepository extends BaseEntityRepository {

	/**
	 * 获取用户权限
	 * @param MUser $user
	 * @param mixed $functions
	 * @param mixed $scope
	 *
	 * @return MPermission[]
	 */
	public function findUserPermission(MUser $user, $functions = null, $scope = null) {
		$user_roles = array();
		foreach ($user->getUserRoles() as $role) {
			if ($role instanceof MRole)
				$user_roles[] = $role->getId() ;
		}
		$qb = $this->getEntityManager()->createQueryBuilder()
				->select('p,f')
				->from('GostSiteManagerBundle:MPermission', 'p')
				->leftJoin('p.function', 'f')
				->where('p.targetType = :type_user AND p.targetId = :user_id')
				->setParameters(array('type_user' => MPermission::TARGET_TYPE_USER, 'user_id' => $user->getId()));
		if (count($user_roles) > 1) {
			$qb->orWhere('p.targetType = :type_role AND p.targetId IN (:role_ids)')
					->setParameter('type_role', MPermission::TARGET_TYPE_ROLE)
					->setParameter('role_ids', ArrayUtils::a2s($user_roles));
		} elseif (count($user_roles) === 1) {
			$qb->orWhere('p.targetType = :type_role AND p.targetId = :role_id')
					->setParameter('type_role', MPermission::TARGET_TYPE_ROLE)
					->setParameter('role_id', $user_roles[0]);
		}
	
		if ($functions instanceof MFunc) {
			$qb->andWhere('f.id = :func')->setParameter('func', $functions->getId());
		} elseif (is_string($functions)) {
			$qb->andWhere('f.key LIKE :func')->setParameter('func', $functions);
		} elseif (is_array($functions)) {
			$func_keys = array();
			foreach ($functions as $func) {
				if ($func instanceof MFunc) {
					array_push($func_keys, $func->getKey());
				} elseif (is_string($func)) {
					array_push($func_keys, $func);
				}
			}
			$qb->andWhere('f.key IN (:func)')->setParameter('func', ArrayUtils::a2s($func_keys));
		}
	
		if (!is_null($scope)) {
			$qb->andWhere('p.scope = :scope')->setParameter('scope', $scope);
		}
		return $qb->getQuery()->getResult();
	}
	
	/**
	 * 获取角色权限
	 * @param mixed $roles
	 * @param mixed $functions
	 * @param mixed $scope
	 *
	 * @return MPermission[]
	 */
	public function findRolePermission($roles, $functions = null, $scope = null) {
		$role_ids = array();
	
		if ($roles instanceof MRole) {
			$role_ids[] = $roles->getId();
		} elseif (is_string($roles)
				&& ($role = $this->getEntityManager()
						->getRepository('GostSiteManagerBundle:MRole')
						->findBy(array('name'=>$roles)))
				&& ($role instanceof MRole)) {
			$role_ids[] = $role->getId();
		} elseif (is_array($roles)) {
			foreach ($roles as $role) {
				if ($role instanceof MRole) {
					$role_ids[] = $role->getId();
				} elseif (is_string($role)
						&& ($r = $this->getEntityManager()
								->getRepository('GostSiteManagerBundle:MRole')
								->findBy(array('name'=>$role)))
						&& ($r instanceof MRole)) {
					$role_ids[] = $r->getId();
				}
			}
		}
	
		$qb = $this->getEntityManager()->createQueryBuilder()
				->select('p,f')
				->from('GostSiteManagerBundle:MPermission', 'p')
				->leftJoin('p.function', 'f')
				->where('p.targetType = :type_role AND p.targetId IN (:role_ids)')
				->setParameters(array('type_role' => MPermission::TARGET_TYPE_ROLE, 'role_ids' => ArrayUtils::a2s($role_ids)));
	
		if ($functions instanceof MFunc) {
			$qb->andWhere('f.id = :func')->setParameter('func', $functions->getId());
		} elseif (is_string($functions)) {
			$qb->andWhere('f.key = :func')->setParameter('func', $functions);
		} elseif (is_array($functions)) {
			$func_keys = array();
			foreach ($functions as $func) {
				if ($func instanceof MFunc) {
					array_push($func_keys, $func->getKey());
				} elseif (is_string($func)) {
					array_push($func_keys, $func);
				}
			}
			$qb->andWhere('f.key IN (:func)')->setParameter('func', ArrayUtils::a2s($func_keys));
		}
	
		if (!is_null($scope)) {
			$qb->andWhere('p.scope = :scope')->setParameter('scope', $scope);
		}
	
		return $qb->getQuery()->getResult();
	}
}