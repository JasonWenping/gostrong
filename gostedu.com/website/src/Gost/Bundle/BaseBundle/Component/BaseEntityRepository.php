<?php
namespace Gost\Bundle\BaseBundle\Component;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\Entity;

/**
 * 实体数据仓库基础类
 * 
 * @author devy
 *
 */
class BaseEntityRepository extends EntityRepository {

	/**
	 * 根据指定条件判断实体数据是否存在
	 * 
	 * @param array $criteria
	 * 
	 * @return boolean
	 */
	public function exists($criteria = array(), &$obj = null) {
		if (($obj = $this->findOneBy($criteria))
				&& ($cls = $this->getClassName())
				&& ($obj instanceof $cls)) {
			return true;
		}
		return false;
	}
}
