<?php

class Admin_Helper_Authentication extends Zend_Controller_Action_Helper_Abstract
{
	public function createChallenge( $view ) {
    	$authNamespace = new Zend_Session_Namespace('Zend_Auth');
	        	
        $challenge = Zf_Util_String::generateRandomString();
        $authNamespace->challenge = $challenge;
                	
        $view->challenge = $challenge;
    }
    
    public function hasIdentity() {
    	// Cria uma instancia de Zend_Auth
        $objAuth = Zend_Auth::getInstance();
    
        // Verifica se já está autenticado
        if ($objAuth->hasIdentity()) {
        	return true;
        } else {
        	if(Zf_Util_Cookie::cookieExists( Zend_Registry::get('admin_config')->resources->cookie->name )) {
        		
        	}
        }
    }
    
	public function checkLoginAttempts($success, $username) {  	
    	$loginAttempt = new Admin_Model_LoginAttempt_Entity();
    	$loginAttempt->setDatetime( time() )
			    	 ->setIp( Zf_Util_Ip::getIp() )
			    	 ->setUsername( $username )
			    	 ->setSuccess( $success );
			    	 
		$laRepository = new Admin_Model_LoginAttempt_Repository();
		$laRepository->save($loginAttempt);
    }
    
    public function updateUserActivity() {
    	if ($this->hasIdentity()) {
    		$authNamespace = new Zend_Session_Namespace('Zend_Auth');
    	
	    	$user = new Admin_Model_User_Entity();
	    	$user->setId( $authNamespace->userId );
	    	$user->setLastActivity( time() );
	    	
	    	$userRepository = new Admin_Model_User_Repository();
	    	$userRepository->updateLastActivity($user);
    	}
    }
}