<?php

namespace Gost\Common\Utils;

/**
 * 实用工具方法类
 * 
 * @author devy
 *
 */
class MiscUtils {
	

	const RANDSTR_MODE_LOWER_ALPHABET = 1;
	const RANDSTR_MODE_UPPER_ALPHABET = 2;
	const RANDSTR_MODE_NUMERIC = 4;
	const RANDSTR_MODE_MIXED = 7;
	
	/**
	 * 获取HTTP请求头信息
	 *
	 * @return array
	 */
	static public function getallheaders() {
		if (!function_exists('getallheaders')) {
			$headers = '';
			foreach ($_SERVER as $name => $value) {
				if (substr($name, 0, 5) == 'HTTP_') {
					$headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
				}
			}
			return $headers;
		}
		return getallheaders();
	}
	
	/**
	 * 获取客户端IP地址
	 *
	 * @return string
	 */
	static public function getclientip() {
		if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			return $_SERVER['HTTP_X_FORWARDED_FOR'];
		} elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
			return $_SERVER['HTTP_CLIENT_IP'];
		} elseif (isset($_SERVER['REMOTE_ADDR'])) {
			return $_SERVER['REMOTE_ADDR'];
		} elseif ($ip = getenv('HTTP_X_FORWARDED_FOR')) {
			return $ip;
		} elseif ($ip = getenv('HTTP_CLIENT_IP')) {
			return $ip;
		} elseif ($ip = getenv('REMOTE_ADDR')) {
			return $ip;
		}
		return 'unknown';
	}
	
	/**
	 * 生成GUID字符串
	 * 00000000-0000-0000-0000-000000000000
	 *
	 * @return string
	 */
	static public function guid() {
		if (function_exists('com_create_guid'))
			return trim(com_create_guid(), '{}');
	
		return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X',
				mt_rand(0, 65535),
				mt_rand(0, 65535),
				mt_rand(0, 65535),
				mt_rand(16384, 20479),
				mt_rand(32768, 49151),
				mt_rand(0, 65535),
				mt_rand(0, 65535),
				mt_rand(0, 65535));
	}
	
	/**
	 * 生成随机字符串
	 *
	 * @param number $length 字符串长度
	 * @param integer $mode 字符组成（1: 小写字母; 2: 大写字母; 4: 数字）
	 * @param number $min_numeric 最少包含数字
	 * @param number $min_alphabet 最少包含字母
	 *
	 * @return string
	 */
	static public function randstr($length = 9, $mode = self::RANDSTR_MODE_MIXED, $min_numeric = false, $min_alphabet = false, $readability = true) {
		$w = '';
		$n = '';
		$s = '';
		if (($mode | self::RANDSTR_MODE_LOWER_ALPHABET) === $mode) { // 小写字母
			$w .= $readability ? 'ackntuvwxyz' : 'abcdefghijklmnopqrstuvwxyz';
		}
		if (($mode | self::RANDSTR_MODE_UPPER_ALPHABET) === $mode) { // 大写字母
			$w .= $readability ? 'ACKNTUVWXY' : 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		}
		if (($mode | self::RANDSTR_MODE_NUMERIC) === $mode) { // 数字
			$n .= $readability ? '345678' : '0123456789';
		}
		if (is_integer($min_numeric) && $min_numeric > 0 && strlen($n) > 0) {
			for ($i = 0; $i < $min_numeric; $i ++) {
				$s .= substr($n, mt_rand(0, strlen($n) - 1), 1);
			}
		}
		if (is_integer($min_alphabet) && $min_alphabet > 0 && strlen($w) > 0) {
			for ($i = strlen($s); $i < $min_numeric; $i ++) {
				$s .= substr($w, mt_rand(0, strlen($w) - 1), 1);
			}
		}
		for ($i = strlen($s); $i < $length; $i ++) {
			$s .= substr($w.$n, mt_rand(0, strlen($w.$n) - 1), 1);
		}
		return str_shuffle($s);
	}
	
	/**
	 * 格式化字符串
	 *
	 * @example Misc::vnsprintf("%welcome\$s, %name\$s", array("welcome"=>"hello", "name=>"John"))
	 *
	 * @param string $format
	 * @param array $data
	 *
	 * @return string
	 */
	static public function vnsprintf($format, $data) {
		$pattern = '/(?<!%)%((?:[[:alpha:]_-][[:alnum:]_-]*|([-+])?[0-9]+(?(2)(?:\.[0-9]+)?|\.[0-9]+)))\$[-+]?\'?.?-?[0-9]*(\.[0-9]+)?\w/x';
		$matches = null;
		if (preg_match_all($pattern, $format, $matches, PREG_SET_ORDER | PREG_OFFSET_CAPTURE)) {
			$offset = 0;
			$keys = array_keys($data);
			foreach ($matches as &$value) {
				if (($key = array_search($value[1][0], $keys, true)) !== false
						|| (is_numeric($value[1][0])
								&& ($key = array_search((int)$value[1][0], $keys, true)) !== false)) {
									$len = strlen($value[1][0]);
									$format = substr_replace($format, 1 + $key, $offset + $value[1][1], $len);
									$offset -= $len - strlen(1 + $key);
								}
			}
		}
		return vsprintf($format, $data);
	}
	
	/**
	 * 对数据进行签名
	 * @param string $format
	 * @param array $data
	 * @param string $secure
	 *
	 * @return string 签名字符串
	 */
	static public function sign($format, $data, $secure) {
		return strtolower(md5(strtolower(sha1(self::vnsprintf($format, $data))) . $secure));
	}
	
	/**
	 * .NET风格MD5 like XX-XX-XX-XX-XX-XX-XX-XX-XX-XX-XX-XX-XX-XX-XX-XX
	 * @param string $str
	 */
	static public function dotnet_md5($str) {
		return wordwrap(strtoupper(md5(mb_convert_encoding($str, 'UTF-16LE'))), 2, '-', true);
	}
	
	/**
	 * 资源回收
	 */
	static public function gc() {
		if (gc_enable()) {
			return gc_collect_cycles();
		} else {
			gc_enable();
			$c = gc_collect_cycles();
			gc_disable();
			return $c;
		}
	}
	
	/**
	 * 获取时间戳
	 *
	 * @param mixed $ts
	 * @return integer
	 */
	static public function unixts($ts) {
		if (is_numeric($ts)) {
			return intval($ts);
		} elseif (is_string($ts) && !empty($ts)
				&& ($timestamp = strtotime($ts))) {
			return $timestamp;
		}
		return null;
	}
	
	/**
	 * 多个字符串比较
	 * @return boolean
	 */
	static public function strcmp() {
		if (($num_args = func_num_args())
				&& ($num_args === 1)) {
					$vars = func_get_arg(0);
				} elseif ($num_args > 1) {
					$vars = func_get_args();
				} else {
					return false;
				}
				if (is_array($vars) && (($num_vars = count($vars)) > 1)) {
					$offset = 0;
					do {
						$cmp = strcmp((string)$vars[$offset++], (string)$vars[$offset]);
					} while (($cmp === 0) && ($offset < $num_vars-1));
					return ($cmp === 0) ? true : false;
				}
				return false;
	}
	
	/**
	 * Tries to convert the given HTML into a plain text format - best suited for
	 * e-mail display, etc.
	 *
	 * <p>In particular, it tries to maintain the following features:
	 * <ul>
	 *   <li>Links are maintained, with the 'href' copied over
	 *   <li>Information in the &lt;head&gt; is lost
	 * </ul>
	 *
	 * @param html the input HTML
	 * @return the HTML converted, as best as possible, to text
	 */
	static public function html2text($html, $encoding = 'utf-8') {
		try {
			$html = self::fix_newlines($html);
			if (!$html) return '';
				
			libxml_use_internal_errors(true);
				
			$doc = new \DOMDocument();
			if (!$doc->loadHTML('<?xml encoding="' . $encoding . '">' . $html))
				throw new \Exception("Could not load HTML - badly formed?");
				
			foreach ($doc->childNodes as $item) {
				if ($item->nodeType == XML_PI_NODE) {
					$doc->removeChild($item);
					break;
				}
			}
				
			$doc->encoding = $encoding;
			$output = self::iterate_over_node($doc);
				
			libxml_use_internal_errors(false);
				
			// remove leading and trailing spaces on each line
			$output = preg_replace("/[ \t]*\n[ \t]*/im", "\n", $output);
				
			// remove leading and trailing whitespace
			$output = trim($output);
				
			return $output;
		} catch (\Exception $ex) {
			return strip_tags($html);
		}
	}
	
	/**
	 * Unify newlines; in particular, \r\n becomes \n, and
	 * then \r becomes \n. This means that all newlines (Unix, Windows, Mac)
	 * all become \ns.
	 *
	 * @param text text with any number of \r, \r\n and \n combinations
	 * @return the fixed text
	 */
	static private function fix_newlines($text) {
		// replace \r\n to \n
		$text = str_replace("\r\n", "\n", $text);
		// remove \rs
		$text = str_replace("\r", "\n", $text);
	
		return $text;
	}
	
	static private function next_child_name($node) {
		// get the next child
		$nextNode = $node->nextSibling;
		while ($nextNode != null) {
			if ($nextNode instanceof \DOMElement) {
				break;
			}
			$nextNode = $nextNode->nextSibling;
		}
		$nextName = null;
		if (($nextNode instanceof \DOMElement)
				&& ($nextNode != null)) {
					$nextName = strtolower($nextNode->nodeName);
				}
	
				return $nextName;
	}
	
	static private function prev_child_name($node) {
		// get the previous child
		$nextNode = $node->previousSibling;
		while ($nextNode != null) {
			if ($nextNode instanceof \DOMElement) {
				break;
			}
			$nextNode = $nextNode->previousSibling;
		}
		$nextName = null;
		if (($nextNode instanceof DOMElement)
				&& ($nextNode != null)) {
					$nextName = strtolower($nextNode->nodeName);
				}
	
				return $nextName;
	}
	
	static private function iterate_over_node($node) {
		if ($node instanceof \DOMText) {
			return preg_replace("/\\s+/im", " ", $node->wholeText);
		}
		if ($node instanceof \DOMDocumentType) {
			// ignore
			return "";
		}
	
		$nextName = self::next_child_name($node);
		$prevName = self::prev_child_name($node);
	
		$name = strtolower($node->nodeName);
	
		// start whitespace
		switch ($name) {
			case "hr":
				return "------\n";
	
			case "style":
			case "head":
			case "title":
			case "meta":
			case "script":
				// ignore these tags
				return "";
	
			case "h1":
			case "h2":
			case "h3":
			case "h4":
			case "h5":
			case "h6":
				// add two newlines
				$output = "\n";
				break;
	
			case "p":
			case "div":
				// add one line
				$output = "\n";
				break;
	
			default:
				// print out contents of unknown tags
				$output = "";
				break;
		}
	
		// debug
		//$output .= "[$name,$nextName]";
	
		for ($i = 0; $i < $node->childNodes->length; $i++) {
			$n = $node->childNodes->item($i);
	
			$text = self::iterate_over_node($n);
	
			$output .= $text;
		}
	
		// end whitespace
		switch ($name) {
			case "style":
			case "head":
			case "title":
			case "meta":
			case "script":
				// ignore these tags
				return "";
	
			case "h1":
			case "h2":
			case "h3":
			case "h4":
			case "h5":
			case "h6":
				$output .= "\n";
				break;
	
			case "p":
			case "br":
				// add one line
				if ($nextName != "div")
					$output .= "\n";
					break;
	
			case "div":
				// add one line only if the next child isn't a div
				if (($nextName != "div") && ($nextName != null))
					$output .= "\n";
					break;
	
			case "a":
				// links are returned in [text](link) format
				$href = $node->getAttribute("href");
				if ($href == null) {
					// it doesn't link anywhere
					if ($node->getAttribute("name") != null) {
						$output = "[$output]";
					}
				} else {
					if ($href == $output) {
						// link to the same address: just use link
						$output;
					} else {
						// replace it
						$output = "[$output]($href)";
					}
				}
	
				// does the next node require additional whitespace?
				switch ($nextName) {
					case "h1": case "h2": case "h3": case "h4": case "h5": case "h6":
						$output .= "\n";
						break;
				}
	
			default:
				// do nothing
		}
	
		return $output;
	}
	
}