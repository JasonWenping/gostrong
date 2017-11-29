<?php

namespace Gost\Bundle\SiteManagerBundle\Controller;

use Gost\Bundle\SiteManagerBundle\Component\MBaseController;

/**
 * 默认控制器
 * 
 * @author devy
 *
 */
class DefaultController extends MBaseController
{
	/**
	 * @see \Gost\Bundle\SiteManagerBundle\Component\MBaseController::getCurrentFunc()
	 */
	public function getCurrentFunc() {
		return 'default';
	}
	
    public function indexAction()
    {
        return $this->smartRender('GostSiteManagerBundle:Default:dashboard.html.twig', '首页', array(
        		'tab_id' => 'dashboard',
        ));
    }
}
