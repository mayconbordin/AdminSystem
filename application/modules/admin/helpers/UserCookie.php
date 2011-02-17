<?php

class Admin_Helper_UserCookie extends Zend_Controller_Action_Helper_Abstract
{
	public function create($userName, $userChallenge, $userKey)
	{
		//Get the config information
		$cookieName = Zend_Registry::get('admin_config')->resources->cookie->name;
		$expireIn = Zend_Registry::get('admin_config')->resources->cookie->expireIn;
		
		//Encrypt the user challenge
		$userChallenge = Zf_Util_MCrypt::encrypt($userChallenge, $userKey);
		
		//Serialize the cookie
		$cookieValue = serialize(array($userName, $userChallenge));
		
		//Encode the cookie
	    $cookieValue = base64_encode($cookieValue);
		
		//Create the user cookie
		Zf_Util_Cookie::setCookie($cookieName, $cookieValue, $expireIn);
	}
	
	public function destroy()
	{
		//Get the config information
		$cookieName = Zend_Registry::get('admin_config')->resources->cookie->name;
		
		Zf_Util_Cookie::deleteCookie($cookieName);
	}
}