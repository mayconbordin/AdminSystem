<?php

class Zf_Util_String
{
	/**
  	 * Generate an random string
  	 * 
  	 * @param int $length
  	 * @return string The random string generated
  	 */
  	public static function generateRandomString($length = 40) {
    	if (!is_int($length) || $length < 1) {
      		return false;
    	}
    	
    	$chars 		= "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    	$randstring = '';
    	$maxvalue 	= strlen($chars) - 1;
    	
    	for($i = 0; $i < $length; $i++) {
      		$randstring .= substr($chars,rand(0,$maxvalue),1);
    	}
    	
    	return $randstring;
  	}
}