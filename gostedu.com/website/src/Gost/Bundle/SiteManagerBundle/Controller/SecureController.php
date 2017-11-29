<?php

namespace Gost\Bundle\SiteManagerBundle\Controller;

use Gost\Bundle\SiteManagerBundle\Component\MBaseController;
use Symfony\Component\Security\Core\SecurityContext;

/**
 * 安全认证控制器
 *
 * @author devy
 *        
 */
class SecureController extends MBaseController {
	
	/**
	 * @see \Gost\Bundle\SiteManagerBundle\Component\MBaseController::getCurrentFunc()
	 */
	public function getCurrentFunc() {
		return 'secure';
	}
	
	/**
	 * 登录页面
	 */
	public function loginAction() {
		$request = $this->getRequest();
		$session = $request->getSession();
		$error = null;
		
		if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
			$error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
		} else {
			$error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
			$session->remove(SecurityContext::AUTHENTICATION_ERROR);
		}
		
		if (!empty($error)) {
			$error = '请重新登录';
		}
		
		return $this->render('GostSiteManagerBundle:Secure:login.html.twig', 
				array('error'=>$error));
	}
}