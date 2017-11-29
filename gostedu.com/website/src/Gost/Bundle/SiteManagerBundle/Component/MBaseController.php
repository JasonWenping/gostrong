<?php

namespace Gost\Bundle\SiteManagerBundle\Component;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * 后台控制器基类
 *
 * @author devy
 *        
 */
abstract class MBaseController extends Controller {

	/**
	 * @var MContext 程序上下文
	 */
	private $context;
	
	protected function getContext() {
		if (!($this->context instanceof MContext))
			$this->context = $this->container->get('gost_site_manager.context') ; // new MContext($this->container);
		return $this->context;
	}
	
	/**
	 * @see \Symfony\Component\DependencyInjection\ContainerAware::setContainer()
	 */
	public function setContainer(ContainerInterface $container = null) {
		parent::setContainer($container);
		if ($container instanceof ContainerInterface)
			$this->contaxt = $container->get('gost_site_manager.context'); // new MContext($container);
	}
	
	
	/**
	 * 获取当前控制器所属的功能
	 *
	 * @return string
	 */
	abstract public function getCurrentFunc();
	
	/**
	 * 判断当前用户是否对操作拥有授权
	 *
	 * @param integer $action
	 * @param mixed $function
	 *
	 * @return boolean
	*/
	protected function isAllowed($action, $function = null, $scope = null) {
		return $this->getContext()->isAllowed($function ?: $this->getCurrentFunc(), $action, $scope, $this->getContext()->getCurrentMUser());
	}
	
	/**
	 * 判断用户是否被授予指定角色
	 *
	 * @see \Symfony\Component\Security\Core\SecurityContext::isGranted()
	 */
	protected function isGranted($attributes, $object = null) {
		return $this->get('security.context')->isGranted($attributes, $object);
	}
	
	/**
	 * @see \Gost\Bundle\BaseBundle\Component\MContext::getAuthorizedFunctions()
	 */
	protected function getAuthorizedFunctions($user = null) {
		return $this->getContext()->getAuthorizedFunctions($user);
	}
	
	/**
	 * 是否是AJAX请求
	 * 
	 * @return boolean
	 */
	protected function isAjaxRequest() {
		if ($this->getRequest()->isXmlHttpRequest())
			return true;
		$request = array_merge($this->getRequest()->query->all(),
				$this->getRequest()->request->all());
		return isset($request['__requestmode'])
		&& (strtolower($request['__requestmode']) === 'ajax');
	}
	
	/**
	 * 以JSON格式输出
	 *
	 * @param mixed $data
	 * 
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 */
	protected function jsonRender($data) {
		return new JsonResponse($data);
	}
	
	/**
	 * 智能模板呈现
	 *
	 * @param string $tpl
	 * @param string $title
	 * @param array $data
	 * @param string $widget_only
	 * 
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	protected function smartRender($tpl, $title, $data,  $widget_only = false) {
	
		$widget_only = $widget_only ?: $this->isAjaxRequest();
		if (!$widget_only) {
			$data = array_merge(array(
					'tab_id' => $this->getCurrentFunc() ?: uniqid(),
					'tab_title' => $title,
					'tab_template' => $tpl),
					$data);
			$tpl = 'GostSiteManagerBundle::layout.html.twig';
		}
		return $this->render($tpl, $data);
	}
}