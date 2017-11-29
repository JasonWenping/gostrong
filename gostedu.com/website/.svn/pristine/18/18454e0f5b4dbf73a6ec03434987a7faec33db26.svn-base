<?php

namespace Gost\Bundle\SiteManagerBundle\Component;

use Symfony\Component\DependencyInjection\ContainerInterface;

use Gost\Bundle\BaseBundle\Component\BaseContext;
use Gost\Bundle\SiteManagerBundle\Entity\MUser;
use Gost\Bundle\SiteManagerBundle\Service\MPermissionService;
use Gost\Bundle\SiteManagerBundle\Entity\MPermission;
use Gost\Bundle\SiteManagerBundle\Entity\MFuncGroup;
use Gost\Bundle\SiteManagerBundle\Entity\MFunc;

/**
 * 后台程序上下文对象
 *
 * @author devy
 *        
 */
class MContext extends BaseContext {

	/**
	 * @var MContext
	 */
	static private $_instance;
	
	/**
	 * @var array
	 */
	private $_config;
	
	/**
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container) {
		parent::__construct($container);
		$this->_config = $container->getParameter('gost_site_manager');
		self::$_instance = $this;
	}
	
	/**
	 * @param ContainerInterface $container
	 * @return \Gost\Bundle\BaseBundle\Component\MContext
	 */
	static public function getInstance(ContainerInterface $container = null) {
		if (!self::$_instance instanceof MContext) {
			self::$_instance = new MContext($container);
		}
		return self::$_instance;
	}
	
	/**
	 * 获取当前登录后台用户
	 *
	 * @param boolean $raw
	 *
	 * @return MUser|null
	 */
	public function getCurrentMUser($raw = false) {
		if (($user = $this->getCurrentUser())
				&& ($user instanceof MUser/*UserInterface*/)) {
			if ($raw) {
				return $this->getEntityManager()
						->getRepository('GostSiteManagerBundle:MUser')
						->find($user->getId());
			}
	
			$flash_key = 'user_id_' . $user->getId();
						
			if (($muser = $this->getFlashData($flash_key))
					&& ($muser instanceof MUser))
				return $muser;
			
			if (($muser = $this->getEntityManager()
							->getRepository('GostSiteManagerBundle:MUser')
							->find($user->getId()))
					&& ($muser instanceof MUser)) {
				$this->setFlashData($flash_key, $muser);
				return $muser;
			}
		}
		return null;
	}
	
	/**
	 * 获取当前请求网址
	 */
	public function getCurrentRequestUri() {
		$request = $this->container->get('request');
		$params = $request->query->all();
		foreach ($params as $key=>$value) {
			if (in_array($key, array('_', '__timestamp', '__requestmode'))) {
				unset($params[$key]);
			}
		}
		return $request->getPathInfo() .(count($params) > 0 ? '?' . http_build_query($params) : '');
	}
	
	/**
	 * 获取授权的功能
	 * 
	 * @param MUser $user
	 */
	public function getAuthorizedFunctions(MUser $user = null, $raw = false) {
		if (($user = $user ?: $this->getCurrentMUser(true))
				&& ($user instanceof MUser)) {
			$flash_key = 'authorized_functions_for_user_' . $user->getId();
			if ($raw || (($authorized_functions = $this->getFlashData($flash_key) === null))) {
				if (($permission_service = $this->container->get('gost_site_manager.permission_service'))
						&& ($permission_service instanceof MPermissionService)) {
	
					$authorized_funcids = array();
					$authorized_functions = array();
										
					$user_permissons = $permission_service->getUserPermissions($user);
										
					foreach ($user_permissons as $permission) {
						if (($permission instanceof MPermission) && $permission->getPermissions() > 0) {
							array_push($authorized_funcids, $permission->getFunction()->getId());
						}
					}
										
					$authorized_funcids = array_unique($authorized_funcids);
										
					$groups = $permission_service->getFuncGroups();
										
					foreach ($groups as $group) {
						if ($group instanceof MFuncGroup) {
							foreach ($group->getFunctions() as $function) {
								if (($function instanceof MFunc) && in_array($function->getId(), $authorized_funcids)) {
									if (!isset($authorized_functions[$group->getId()])) {
										$authorized_functions[$group->getId()] = array(
												'key' => $group->getKey(),
												'title' => $group->getTitle(),
												'functions' => array()
										);
									}
									array_push($authorized_functions[$group->getId()]['functions'], $function);
								}
							}
						}
					}
				}
				$this->setFlashData($flash_key, $authorized_functions);
			}
		}
		return isset($authorized_functions) ? $authorized_functions : null;
	}
	
	/**
	 * 判断用户是否拥有操作的授权
	 *
	 * @param mixed $function
	 * @param integer $action
	 * @param integer|null $scope
	 * @param MUser $user
	 *
	 * @return bool
	 */
	public function isAllowed($function, $action, $scope = null, MUser $user = null, $raw = false) {
		if (($user = $user ?: $this->getCurrentMUser(true))
				&& ($user instanceof MUser)) {
			$flash_key = 'is_allowed_user_' . $user->getId()
					. '_' . (($function instanceof MFunc) ? $function->getKey() : $function)
					. '_' . $action;
			if (!is_null($scope)) {
				$flash_key .= '_' . $scope;
			}
			if ($raw || (($is_allowed = $this->getFlashData($flash_key)) === null)) {
				if (($permission_service = $this->container->get('gost_site_manager.permission_service'))
						&& ($permission_service instanceof MPermissionService)) {
					$user_permission = $permission_service->getUserPermissions($user, $function, $scope);
					foreach ($user_permission as $perm) {
						if (($perm instanceof MPermission) && (($perm->getPermissions() | $action) === $perm->getPermissions())) {
							$is_allowed = true;
							break;
						}
					}
					$this->setFlashData($flash_key, $is_allowed);
				}
			}
		}
		return isset($is_allowed) ? $is_allowed : false;
	}
	
	/**
	 * 获取配置参数
	 *
	 * @return mixed
	 */
	public function getConfig($path = null) {
		if (!$path)
			return $this->_config;
		elseif (strpos($path, '/') === false)
			return isset($this->_config[$path]) ? $this->_config[$path] : null;
	
		$conf= $this->_config;
		foreach (explode('/', $path) as $path) {
			$conf = $conf[$path];
		}
		return $conf;
	}
}