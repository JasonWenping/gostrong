<?php
namespace Gost\Bundle\BaseBundle\Component;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\User\UserInterface;


/**
 * 上下文对象基类
 * 
 * @author devy
 *
 */
class BaseContext extends \Gost\Bundle\BaseBundle\Component\BaseService {
	
	/**
	 * 获取当前登录用户
	 * 
	 * @return UserInterface|null
	 */
	public function getCurrentUser() {
		if (!$this->container->has('security.context')) {
			throw new \LogicException('The SecurityBundle is not registered in your application.');
		}

		if (($token = $this->container->get('security.context')->getToken())
				&& ($user = $token->getUser())
				&& ($user instanceof UserInterface)) {
			return $user;
		}
		
		return null;
	}
	
}
