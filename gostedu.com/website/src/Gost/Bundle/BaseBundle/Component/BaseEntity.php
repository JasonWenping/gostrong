<?php

namespace Gost\Bundle\BaseBundle\Component;

use Doctrine\ORM\EntityManager;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\NotifyPropertyChanged;
use Doctrine\Common\PropertyChangedListener;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * 实体类基础类
 * 
 * @author devy
 *
 */
class BaseEntity {
	
	/**
	 * 获取对象数组
	 * @param boolean $clear_null
	 * @return array
	 */
	public function toArray($assoc = false, $clear_null = false, $keys_only = null) {
		$vars = get_class_vars(get_class($this));
		if (array_key_exists('lazyPropertiesDefaults', $vars)) unset($vars['lazyPropertiesDefaults']);
		foreach ($vars as $key => $value) {
			try {
				if ((strpos($key, '_') === 0)
						|| ($clear_null && is_null($this->$key))
						|| (is_array($keys_only) && !in_array($key, $keys_only))) {
					unset($vars[$key]);
				} else {
					if (is_string($this->$key) || is_numeric($this->$key) || is_bool($this->$key))
						$vars[$key] = $this->$key;
					elseif ($assoc && ($this->$key instanceof BaseEntity))
						$vars[$key] = $this->$key->toArray(false, $clear_null);
					elseif ($assoc && (($this->$key instanceof ArrayCollection) || is_array($this->$key)))
						foreach ($this->$key as $val) {
							if ($val instanceof BaseEntity)
								$vars[$key][] = $val->toArray(false, $clear_null);
							else
								$vars[$key][] = json_encode($val);
						}
	
				}
			} catch (\Exception $ex) {
				unset($vars[$key]);
			}
		}
		return $vars; //json_decode(json_encode($vars), true);
	}
	
	/**
	 * 保存修改
	 *
	 * @param EntityManager $em
	 *
	 */
	public function flush(EntityManager $em) {
		if (!$em->isOpen()) {
			$em = $em->create($em->getConnection(), $em->getConfiguration());
		}
		$em->persist($this);
		$em->flush();
		return $this;
	}
	
	/**
	 * 移除
	 *
	 * @param EntityManager $em
	 */
	public function remove(EntityManager $em) {
		if (!$em->isOpen()) {
			$em = $em->create($em->getConnection(), $em->getConfiguration());
		}
		$em->remove($this);
		return $em->flush();
	}
	
	
	private $_changes = array();
	private $_orignals = array();
	
	/**
	 * 获取变更属性
	 *
	 * @return array
	*/
	public function getChangedProperties() {
		return array_keys($this->_changes);
	}
	
	/**
	 * 获取变更属性值
	 *
	 * @return array
	 */
	public function getChangedValues($key = null) {
		if (is_null($key)) {
			return $this->_changes;
		} elseif (isset($this->_changes[$key])) {
			return $this->_changes[$key];
		} else {
			throw new \Exception("property with key '{$key}' does not exists in changed values.");
		}
	}
	
	/**
	 * 获取变更属性的原始值
	 *
	 * @return array
	 */
	public function getChangedPropertiesOrignal() {
		return $this->_orignals;
	}
	
	/**
	 * 设置属性值
	 *
	 * @param string $propName
	 * @param mixed $value
	 * @param boolean $force
	 *
	 * @return BaseEntity
	 */
	public function set($propName, $value, $force = false) {
		$setter = 'set' . ucfirst($propName);
		$getter = 'get' . ucfirst($propName);
		if (method_exists($this, $setter) && is_callable(array($this, $setter))) {
			if (method_exists($this, $getter) && is_callable(array($this, $getter))
					&& (($orignal = call_user_func_array(array($this, $getter), array())) !== $value)) {
				$this->_orignals[$propName] = $orignal;
				$this->_changes[$propName] = $value;
				$this->_onPropertyChanged($propName, $orignal, $value);
				$this->_changed = true;
			}
			return call_user_func_array(array($this, $setter), array($value));
		} elseif (!$force) {
			throw new \Exception("the specified property '{$propName}' does not have setter method.");
		}
		$this->$propName = $value;
		$this->_changed = true;
		return $this;
	}
	
	/**
	 * 是否更新
	 *
	 * @return boolean
	 */
	public function isChanged() {
		return $this->_changed;
	}
	
	private $_changed = false;
	
	private $_listeners = array();
	
	/**
	 * @see \Doctrine\Common\NotifyPropertyChanged::addPropertyChangedListener()
	 */
	public function addPropertyChangedListener(PropertyChangedListener $listener) {
		$this->_listeners[] = $listener;
	}
	
	protected function _onPropertyChanged($propName, $oldValue, $newValue) {
		if ($this->_listeners) {
			foreach ($this->_listeners as $listener) {
				if ($listener instanceof PropertyChangedListener)
					$listener->propertyChanged($this, $propName, $oldValue, $newValue);
			}
		}
	}
}