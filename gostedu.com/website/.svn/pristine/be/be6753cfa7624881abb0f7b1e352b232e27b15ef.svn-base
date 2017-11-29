<?php

namespace Gost\Bundle\SiteManagerBundle\Controller;

use Gost\Bundle\SiteManagerBundle\Component\MBaseController;

/**
 *
 * @author devylee
 *        
 */
class WidgetController extends MBaseController {
	
	/**
	 * @see \Gost\Bundle\SiteManagerBundle\Component\MBaseController::getCurrentFunc()
	 */
	public function getCurrentFunc() {
		return 'widget';
	}
	
	/**
	 * 主菜单
	 */
	public function menuAction() {
		return $this->render('GostSiteManagerBundle:Widget:menu.html.twig',
				array('menu'=>$this->getAuthorizedFunctions()));
	}
}