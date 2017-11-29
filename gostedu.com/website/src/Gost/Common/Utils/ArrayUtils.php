<?php

namespace Gost\Common\Utils;

/**
 * 数组实用工具类
 * 
 * @author devy
 *
 */
class ArrayUtils {

	/**
	 * 字符串转换为数组
	 *
	 * @param string|array $var 字符串或数组
	 * @param string $delimiter 拆分符
	 * @param boolean $unique 是否过滤重复项
	 *
	 * @return array
	 */
	static public function s2a($var, $delimiter = ',', $unique = true) {
		if (is_string($var)) {
			$var = explode($delimiter, $var);
		} elseif (!is_array($var)) {
			return array();
		}
		$arr = array_filter(array_map(function($v){ return trim($v); }, $var));
		return $unique ? array_unique($arr) : $arr;
	}
	
	/**
	 * 数组转换为字符串
	 *
	 * 如果 $var 是字符串，则使用 $delimiter 进行拆分成数组
	 * 然后再使用 $glue 将数组项连接成字符串
	 *
	 * @param array|string $var 数组或字符串
	 * @param string $delimiter 字符串拆分符
	 * @param string $glue 字符串连接符
	 * @param boolean $filter_duplicated 移除重复项
	 *
	 * @return string
	 */
	static public function a2s($var, $delimiter = ',', $glue = ', ', $filter_duplicated = true) {
		$pieces = self::s2a($var, $delimiter, $filter_duplicated);
		return implode($glue, $pieces);
	}
	
	/**
	 * 检查数组中是否存在指定的key
	 *
	 * @param array $keys
	 * @param array $search
	 * @param boolean $match_all 是否匹配全部
	 *
	 * @return boolean
	 */
	static function keysExists($keys, $search, $match_all = true) {
		return $match_all
				? ((array_key_exists($key = array_shift($keys), $search) || in_array($key, $search))
						&& ($keys ? self::keysExists($keys, $search, $match_all) : true))
				: ((array_key_exists($key = array_shift($keys), $search) || in_array($key, $search))
						|| ($keys ? self::keysExists($keys, $search, $match_all) : false));
	}
	
}
