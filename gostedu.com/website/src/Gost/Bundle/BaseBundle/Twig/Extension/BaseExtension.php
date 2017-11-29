<?php

namespace Gost\Bundle\BaseBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Twig模板扩展
 * 
 * @author devylee
 *
 */
class BaseExtension extends \Twig_Extension implements ContainerAwareInterface {

	/**
	 * @var ContainerInterface
	 */
	private $container;
	
	function __construct(ContainerInterface $container = null) {
		$this->setContainer($container);
	}
	
	/**
	 * @see \Symfony\Component\DependencyInjection\ContainerAwareInterface::setContainer()
	 */
	public function setContainer(ContainerInterface $container = null) {
		$this->container = $container;
	}
	
	/**
	 * @see Twig_ExtensionInterface::getName()
	 */
	public function getName() {
		return 'gost_base_twig_extension';
	}

	/**
	 * @see Twig_Extension::getFilters()
	 */
	public function getFilters() {
		return array(
				'in_array' => new \Twig_Filter_Function('in_array'),
				'generate_url' => new \Twig_Filter_Method($this, 'generate_url'),
				'oper_or' => new \Twig_Filter_Method($this, 'oper_or'),
				'array_item' => new \Twig_Filter_Method($this, 'array_item'),
		);
	}
	
	/**
	 * @see Twig_Extension::getFunctions()
	 */
	public function getFunctions() {
		return array(
				'in_array' => new \Twig_Function_Function('in_array'),
				'generate_url'=> new \Twig_Function_Method($this, 'generate_url'),
		);
	}

	/**
	 * 或操作
	 *
	 * @param mixed $p1
	 * @param mixed $p2
	 * @return boolean
	 */
	public function oper_or($p1, $p2) {
		return $p1 | $p2;
	}

	/**
	 * 取数组内容
	 *
	 * @param array $array
	 * @param mixed $key
	 * @return mixed|NULL
	 */
	public function array_item($array, $key) {
		if (array_key_exists($key, $array)) {
			return $array[$key];
		}
		return null;
	}
	
	/**
	 * 网址转换
	 * @param string $route
	 * @param array $params
	 */
	public function generate_url($route, $params = array(), $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH) {
		try {
			$url = $this->container->get('router')->generate($route, $params, $referenceType);
			return $url;
		} catch (\Exception $ex) {
			return '#';
		}
	}
}