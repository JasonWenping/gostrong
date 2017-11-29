<?php

namespace Gost\Common\Utils;

/**
 * 数据校验工具类
 *
 * @author devy
 *        
 */
class Validator {

	/**
	 * 是否是EMAIL地址
	 *
	 * @param string $str
	 *
	 * @return mixed
	 */
	public static function is_email($str) {
		return filter_var($str, FILTER_VALIDATE_EMAIL);
	}
	
	/**
	 * 是否是手机号码
	 * @param string $str
	 * @param mixed $specific_range 指定号段
	 */
	public static function is_cellphone($str, $specific_range = null) {
		$ranges  =  '130|131|132|133|134|135|136|137|138|139'; 		// 13x
		$ranges .= '|145|147'; 										// 14x
		$ranges .= '|150|151|152|153|155|156|157|158|159'; 			// 15x
		$ranges .= '|180|181|182|183|185|186|187|188|189'; 			// 18x
		$ranges .= '|170'; 											// 17x
		if (is_array($specific_range)) {
			$ranges = ArrayUtils::a2s($specific_range, '|');
		} elseif ($specific_range) {
			$ranges = $specific_range;
		}
		$pattern = "/^(\+86){0,1}({$ranges}){1}[\d]{8}$/i";
	
		return preg_match($pattern, $str);
	}
}