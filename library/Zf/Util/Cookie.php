<?php

class Zf_Util_Cookie
{
	/**
	 * Create a new cookie.
	 * 
	 * @param  string $name 	The name of the cookie.
	 * @param  string $value 	The value of the cookie. This value is stored on the clients computer; do not store sensitive information.
	 * @param  int 	  $expire	The time the cookie expires. This is a Unix timestamp so is in number of seconds since the epoch. In other words, you'll most likely set this with the time() function plus the number of seconds before you want it to expire. Or you might use mktime(). time()+60*60*24*30 will set the cookie to expire in 30 days. If set to 0, or omitted, the cookie will expire at the end of the session (when the browser closes).
	 * @param  string $path		The path on the server in which the cookie will be available on. If set to '/', the cookie will be available within the entire domain. If set to '/foo/', the cookie will only be available within the /foo/ directory and all sub-directories such as /foo/bar/ of domain. The default value is the current directory that the cookie is being set in.
	 * @param  string $domain	The domain that the cookie is available to. To make the cookie available on all subdomains of example.com (including example.com itself) then you'd set it to '.example.com'. Although some browsers will accept cookies without the initial.
	 * @param  bool   $secure	Indicates that the cookie should only be transmitted over a secure HTTPS connection from the client. When set to TRUE, the cookie will only be set if a secure connection exists. On the server-side, it's on the programmer to send this kind of cookie only on secure connection.
	 * @param  bool   $httponly	When TRUE the cookie will be made accessible only through the HTTP protocol. This means that the cookie won't be accessible by scripting languages, such as JavaScript. This setting can effectively help to reduce identity theft through XSS attacks (although it is not supported by all browsers). Added in PHP 5.2.0. TRUE or FALSE
	 * @return bool				If output exists prior to calling this function, setcookie() will fail and return FALSE. If setcookie() successfully runs, it will return TRUE. This does not indicate whether the user accepted the cookie.
	 */
	public static function setCookie($name, $value, $expire = 0, $path, $domain, $secure = false, $httponly = false)
	{
		return setcookie($name, $value, $expire, $path, $domain, $secure, $httponly);
	}
	
	/**
	 * Get an existent cookie.
	 * 
	 * @param string $name The name of the cookie.
	 * @return string|null
	 */
	public static function getCookie($name)
	{
		if (isset($_COOKIE[$name])) {
			return $_COOKIE[$name];
		} else {
			return null;
		}
	}
	
	/**
	 * Checks if an cookie exists.
	 * 
	 * @param string $name
	 * @return bool
	 */
	public static function cookieExists($name)
	{
		if (isset($_COOKIE[$name])) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Delete an existent cookie.
	 * 
	 * @param string $name
	 * @return bool
	 */
	public static function deleteCookie($name)
	{
		return setcookie ($name, "", time() - 3600);
	}
}