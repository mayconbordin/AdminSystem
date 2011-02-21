<?php

class Admin_Helper_UserCookie extends Zend_Controller_Action_Helper_Abstract
{
	/**
	 * Create the user cookie
	 * 
	 * @param string $userName The name of the user to be remembered
	 * @param string $userChallenge The user challenge used to authenticate
	 * @param string $userKey The key to encrypt the user challenge. Could be the combination of the
	 * user IP and the user browser version. Some info that just the user's computer would have.
	 */
	public function create($userName, $userChallenge)
	{
		//Get the config information
		$cookieName = Zend_Registry::get('admin_config')->resources->cookie->name;
		$expireIn = Zend_Registry::get('admin_config')->resources->cookie->expireIn;
		
		//Browser object
		$browser = new Zf_Util_Browser();
		
		//Generate the user key
		$userKey = $browser->getBrowser().
				   $browser->getVersion().
				   $browser->getUserAgent().
				   $browser->getPlatform().
				   Zf_Util_Ip::getIp();
				   
		//Create a hash with the user key
		$userKey = md5($userKey);
		
		//Join the user data
		$userData = array($userName, $userChallenge);
		
		$cookie = new Zf_Util_Cookie($cookieName, null, $expireIn);
		$cookie->setKey($userKey);
		$cookie->setEncryptedCookie($userData);
	}
	
	public function isAuthentic()
	{
		//Get the config information
		$cookieName = Zend_Registry::get('admin_config')->resources->cookie->name;
		
		//Browser object
		$browser = new Zf_Util_Browser();
		
		//Generate the user key
		$userKey = $browser->getBrowser().
				   $browser->getVersion().
				   $browser->getUserAgent().
				   $browser->getPlatform().
				   Zf_Util_Ip::getIp();
				   
		//Create a hash with the user key
		$userKey = md5($userKey);
		
		$cookie = new Zf_Util_Cookie($cookieName);
		$cookie->setKey($userKey);
		$userData = array();
		
		try {
			$userData = $cookie->getEncryptedCookie();
		} catch (Zf_Util_CookieException $ex) {
			return false;
		}
		
		//Check if the user and it's challenge exists
		$userRepository = new Admin_Model_User_Repository();
		if ($userRepository->existsByNameAndChallenge($userData[0], $userData[1])) {
			return true;
		} else {
			return false;
		}
	}
	
	public function destroy()
	{
		//Get the config information
		$cookieName = Zend_Registry::get('admin_config')->resources->cookie->name;
		
		Zf_Util_Cookie::deleteCookie($cookieName);
	}
}