<?php
namespace Gost\Bundle\BaseBundle\Service;


/**
 * 闪存数据服务（避免程序上下文重复获取诸如数据库中的数据）
 * 
 * @author devy
 *
 */
class FlashDataService {
	
	static private $_instances = array();
	
	private $_flashDataBag = array();
	
	/**
	 * @param string $identify
	 * @return FlashDataService
	 */
	static public function getInstance($identify = 'default') {
		if (!(isset(self::$_instances[$identify]) 
				&& (self::$_instances[$identify] instanceof FlashDataService))) {
			self::$_instances[$identify] = new FlashDataService();
		}
		return self::$_instances[$identify];
	}
	
	/**
	 * 获取闪存对象
	 *
	 * @param string $key
	 * @return mixed
	 */
	public function get($key) {
		return array_key_exists($key, $this->_flashDataBag)
				? $this->_flashDataBag[$key]
				: null;
	}
	
	/**
	 * 设置闪存对象（闪存对象可以用于存放当前程序生命周期内重复用到的参数对象）
	 *
	 * @param string $key
	 * @param mixed $data
	 * @param boolean $remove
	 * 
	 * @return FlashDataService
	 */
	public function set($key, $data, $remove = false) {
		$this->_flashDataBag[$key] = $data;
		if ($remove)
			unset($this->_flashDataBag[$key]);
		return $this;
	}
	
	/**
	 * 获取全部闪存内容
	 * 
	 * @return array
	 */
	public function all() {
		return $this->_flashDataBag;
	}

}