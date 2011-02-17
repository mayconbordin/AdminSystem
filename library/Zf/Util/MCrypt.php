<?php

class Zf_Util_MCrypt {
	private static $iv;
	
	private static function _getIv() {
		if (self::$iv == null) {
			self::_setIv(mcrypt_create_iv(mcrypt_get_block_size (MCRYPT_TripleDES, MCRYPT_MODE_CBC), MCRYPT_DEV_RANDOM));
		}
		
		return self::$iv;
	}
	
	private static function _setIv($iv) {
		self::$iv = $iv;
	}
	
	/**
	 * Encrypt a string with a give key.
	 * 
	 * @param string $string
	 * @param string $key
	 */
	public static function encrypt($string, $key) {
	    $enc = "";
	    $enc = mcrypt_cbc (MCRYPT_TripleDES, $key, $string, MCRYPT_ENCRYPT, self::_getIv());
	  	return base64_encode($enc);
	}
	
	/**
	 * Decrypt a string with a give key.
	 * 
	 * @param string $string
	 * @param string $key
	 */
	public static function decrypt($string, $key) {
	    $dec = "";
	    $string = trim(base64_decode($string));
	    $dec = mcrypt_cbc (MCRYPT_TripleDES, $key, $string, MCRYPT_DECRYPT, self::_getIv());
	  	return $dec;
	}
}