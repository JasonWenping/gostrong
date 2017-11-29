<?php

namespace Gost\Bundle\SiteManagerBundle\Repository;

use Gost\Common\Utils\ArrayUtils;
use Gost\Bundle\BaseBundle\Component\BaseEntityRepository;
use Gost\Bundle\SiteManagerBundle\Entity\MFuncGroup;
use Gost\Bundle\SiteManagerBundle\Entity\MFunc;

/**
 * 功能对象数据仓库类
 *
 * @author devy
 *        
 */
class MFuncRepository extends BaseEntityRepository {

	/**
	 * 获取功能分组
	 *
	 * @return MCFuncGroup[]
	 */
	public function findFuncGroups() {
		$qb = $this->getEntityManager()->createQueryBuilder()
				->select('p')
				->from('GostSiteManagerBundle:MFuncGroup', 'p')
				->orderBy('p.sortNo');
	
		return $qb->getQuery()->getResult();
	}
	
	/**
	 * 获取功能列表
	 * @param mixed $groups
	 * @return MFunc[]
	 */
	public function findFunctions($groups = null) {
		$qb = $this->getEntityManager()->createQueryBuilder()
				->select('p,g')
				->from('GostSiteManagerBundle:MFunc', 'p')
				->leftJoin('p.group', 'g')
				->orderBy('g.sortNo')
				->addGroupBy('p.sortNo');
	
		if ($groups instanceof MFuncGroup) {
			$qb->where('g.id = :group')
					->setParameter('group', $groups->getId());
		} elseif (is_string($groups)) {
			$qb->where('g.key LIKE :group')
					->setParameter('group', $groups);
		} elseif (is_array($groups)) {
			$group_ids = array();
			foreach ($groups as $group) {
				if ($group instanceof MFuncGroup) {
					$group_ids[] = $group->getId();
				} elseif (is_string($group)
						&& ($g = $this->getEntityManager()
								->getRepository('GostSiteManagerBundle:MFuncGroup')
								->findOneBy(array('key'=>$group)))
						&& ($g instanceof MFuncGroup)) {
					$group_ids[] = $g->getId();
				}
			}
			$qb->where('g.id IN (:groups)')
					->setParameters('groups', ArrayUtils::a2s($group_ids));
		}
	
		return $qb->getQuery()->getResult();
	}
	
	/**
	 * 获取功能操作列表
	 *
	 * @param mixed $functions
	 */
	public function findActions($functions = null) {
		$qb = $this->getEntityManager()->createQueryBuilder()
				->select('p,f,g')
				->from('GostSiteManagerBundle:MAction', 'p')
				->leftJoin('p.func', 'f')
				->leftJoin('f.group', 'g')
				->orderBy('g.sortNo')
				->addOrderBy('f.sortNo')
				->addOrderBy('p.code');
		if ($functions instanceof MFunc) {
			$qb->where('f.id = :func')
					->setParameter('func', $functions->getId());
		} elseif (is_string($functions)) {
			$qb->where('f.key = :func')
					->setParameter('func', $functions);
		} elseif (is_array($functions)) {
			$function_keys = array();
			foreach ($functions as $function) {
				if ($function instanceof MFunc) {
					array_push($function_keys, $function->getKey());
				} elseif (is_string($function)) {
					array_push($function_keys, $function);
				}
			}
			$qb->where('f.key IN (:func)')
					->setParameter('func', ArrayUtils::a2s($function_keys));
		}
		return $qb->getQuery()->getResult();
	}
}