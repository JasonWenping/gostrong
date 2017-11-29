<?php

namespace Gost\Bundle\SiteManagerBundle\Controller;

use Gost\Bundle\SiteManagerBundle\Component\MBaseController;
use Gost\Bundle\BaseBundle\Entity\Navigation;

/**
 * 网站导航管理控制器
 *
 * @author devylee
 *        
 */
class NavigationController extends MBaseController {
	
	/**
	 * @see \Gost\Bundle\SiteManagerBundle\Component\MBaseController::getCurrentFunc()
	 */
	public function getCurrentFunc() {
		return 'site_navigation';
	}
	
	/**
	 * 导航管理
	 */
	public function navigationsAction() {
		$navs = $this->getDoctrine()->getManager()
				->getRepository('GostBaseBundle:Navigation')
				->findAll();
		
		return $this->smartRender('GostSiteManagerBundle:Navigation:navigations.html.twig', '导航管理', array(
				'tab_id' => $this->getCurrentFunc(),
				'navigations' => $navs
		));
	}
	
	/**
	 * 导航位
	 * @param string $register
	 * @param string $id
	 * @param string $delete
	 */
	public function navigationAction($register = true, $id = null, $delete = false) {
		// TODO
	}
	
	/**
	 * 菜单
	 * @param string $register
	 * @param string $id
	 * @param string $delete
	 */
	public function menuAction($register = true, $id = null, $delete = false) {
		// TODO
	}
	
	/**
	 * 菜单参数
	 * @param string $register
	 * @param string $id
	 * @param string $delete
	 */
	public function parameterAction($register = true, $id = null, $delete = false) {
		// TODO
	}
}