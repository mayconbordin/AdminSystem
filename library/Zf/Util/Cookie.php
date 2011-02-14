<?php

class Zf_Util_Cookie
{
	public static function setCookie($name, $value, $expire = 0, $path, $domain, $secure = false, $httponly = false)
	{
		setcookie($name, $value, $expire, $path, $domain, $secure, $httponly);
	}
	
	public static function getCookie($name)
	{
		return $_COOKIE[$name];
	}
}