<?php

namespace Gost\Bundle\SiteManagerBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

use Gost\Bundle\SiteManagerBundle\Component\MContext;

/**
 * Twig模板扩展
 *
 * @author devylee
 *        
 */
class SiteManagerExtension extends \Twig_Extension implements ContainerAwareInterface {

	/**
	 * @var ContainerInterface
	 */
	private $container;
	
	/**
	 * @var MContext
	 */
	private $context;
	
	function __construct(ContainerInterface $container = null) {
		$this->setContainer($container);
	}
	
	/**
	 * @see \Symfony\Component\DependencyInjection\ContainerAwareInterface::setContainer()
	 */
	public function setContainer(ContainerInterface $container = null) {
		$this->container = $container;
		$this->context = MContext::getInstance($container);
	}

	/**
	 * @see Twig_ExtensionInterface::getName()
	 */
	public function getName() {
		return 'gost_site_manager_twig_extension';
	}
	
	/**
	 * @see Twig_Extension::getFilters()
	 */
	public function getFilters() {
		return array(
				
		);
	}
	
	/**
	 * @see Twig_Extension::getFunctions()
	 */
	public function getFunctions() {
		return array(
				'is_permitted' => new \Twig_Function_Method($this, 'is_permitted'),
		);
	}
	
	/**
	 * @see Twig_Extension::getGlobals()
	 */
	public function getGlobals() {
		return array(
				
		);
	}

	/**
	 * 功能是否授权
	 *
	 * @param mixed $function
	 * @param mixed $action
	 * @param integer $scope
	 */
	public function is_permitted($function, $action, $scope = null) {
		return $this->context->isAllowed($function, $action, $scope);
	}
	
}