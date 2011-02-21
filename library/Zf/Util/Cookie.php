<?php

/**
 * Cookie Handler
 * 
 * Based on EncryptedCookieSessionStore from https://github.com/jcs/halfmoon/
 *
 */
class Zf_Util_Cookie
{
	protected $_name;
	protected $_value;
	protected $_expire;
	protected $_path;
	protected $_domain;
	protected $_secure;
	protected $_httponly;
	protected $_key;
	
	public function __construct($name, $value = null, $expire = 0, $path = null, $domain = null, $secure = false, $httponly = false)
	{
		$this->_name 	 = $name;
		$this->_value 	 = $value;
		$this->_expire 	 = $expire;
		$this->_path 	 = $path;
		$this->_domain 	 = $domain;
		$this->_secure 	 = $secure;
		$this->_httponly = $httponly;
		
		if (!function_exists("mcrypt_encrypt")){
			throw new Zf_Util_CookieException("MCrypt extension not installed");
		}
	}
	
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
	public static function setCookie($name, $value = null, $expire = 0, $path = null, $domain = null, $secure = false, $httponly = false)
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
	
	public function setKey($key) {
		// check the key lenght (must be a md5 hash)
		if (strlen($key) != 32) {
			throw new Zf_Util_CookieException("cookie encryption key must be 32 characters long");
		}
		
		// pack the key
		$this->_key = pack("H*", $key);
	}
	
	public function setEncryptedCookie(array $data) {
		// format the data
		$data = base64_encode(serialize($data));
		
		// generate random iv for aes-256-cfb
		$iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256,
			MCRYPT_MODE_CFB), MCRYPT_RAND);

		// encrypt the iv with aes-128-ecb
		$e_iv = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $this->_key, $iv,
			MCRYPT_MODE_ECB);

		// create the hmac signature
		$hmac = hash_hmac("sha256", $data, $this->_key, $raw_output = true);

		// encrypt the hmac and data with aes-256-cfb, using the random iv
		$e_data = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $this->_key,
			$hmac . "--" . $data, MCRYPT_MODE_CFB, $iv);

		$cookie = base64_encode($e_iv) . "--" . base64_encode($e_data);

		self::setCookie(
			$this->_name,
			$cookie,
			$this->_expire,
			$this->_path,
			$this->_domain,
			$this->_secure,
			$this->_httponly
		);

		return true;
	}
	
	public function getEncryptedCookie()
	{
		if (!self::cookieExists($this->_name)) {
			throw new Zf_Util_CookieException("Cookie do not exist");
		}
		
		list($e_iv, $e_data) = explode("--", self::getCookie($this->_name), 2);

		if (strlen($e_iv) && strlen($e_data)) {
			$e_iv = base64_decode($e_iv);
			$e_data = base64_decode($e_data);

			$iv = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $this->_key, $e_iv,
				MCRYPT_MODE_ECB);

			$data_and_hmac = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $this->_key,
				$e_data, MCRYPT_MODE_CFB, $iv);

			list($hmac, $data) = explode("--", $data_and_hmac, 2);
			
			if (is_null($hmac) || is_null($data)) {
				throw new Zf_Util_CookieException("no HMAC or data");
			}

			if (hash_hmac("sha256", $data, $this->_key, $raw = true) !== $hmac) {
				throw new Zf_Util_CookieException("invalid HMAC");
			}
			
			$data = unserialize(base64_decode($data));

			return $data;
		}

		return "";
	}
}