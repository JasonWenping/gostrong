<?php

namespace Gost\Bundle\SiteManagerBundle\Service;

use Gost\Bundle\BaseBundle\Service\NavigationService;
use Gost\Bundle\BaseBundle\Entity\Navigation;
use Gost\Bundle\BaseBundle\Entity\NavigationMenu;

/**
 * 导航管理服务类
 *
 * @author devylee
 *        
 */
class MNavigationService extends NavigationService {

	/**
	 * 创建导航
	 */
	public function createNavigation($key, $name) {
		$em = $this->getEntityManager();
		if ($em->getRepository('GostBaseBundle:Navigation')->exists(array('key'=>$key))) {
			throw new \Exception('导航位Key已存在');
		}
		$nav = new Navigation();
		$nav->setKey($key)
				->setName($name)
				->flush($em);
		return $nav;
	}

	/**
	 * 修改导航
	 */
	public function updateNavigation($id, $key, $name) {
		$em = $this->getEntityManager();
		if ($nav = $em->getRepository('GostBaseBundle:Navigation')->find($id)) {
			if (($key != $nav->getKey()) 
					&& $em->getRepository('GostBaseBundle:Navigation')->exists(array('key'=>$key))) {
				throw new \Exception('导航位Key已存在');
			}
			$nav->setKey($key)
					->setName($name)
					->flush($em);
			return $nav;
		} else {
			throw new \Exception('导航位不存在');
		}
	}

	/**
	 * 删除导航
	 */
	public function deleteNavigation($id) {
		$em = $this->getEntityManager();
		if ($nav = $em->getRepository('GostBaseBundle:Navigation')
				->find($id)) {
			$em->remove($nav);
			$em->flush();
		}
	}

	/**
	 * @todo
	 */
	public function createMenu() {
		//TODO
	}

	/**
	 * @todo
	 */
	public function updateMenu() {
		//TODO
	}

	/**
	 * 删除导航栏
	 */
	public function deleteMenu($id) {
		$em = $this->getEntityManager();
		if ($menu = $em->getRepository('GostBaseBundle:NavigationMenu')
				->find($id)) {
			$em->remove($menu);
			$em->flush();
		}
	}

	/**
	 * @todo
	 */
	public function createParameter() {
		//TODO
	}

	/**
	 * @todo
	 */
	public function updateParameter() {
		//TODO
	}

	/**
	 * @todo
	 */
	public function deleteParameter() {
		//TODO
	}
}