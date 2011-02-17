<?php

class Admin_IndexController extends Zend_Controller_Action
{

    public function init()
    {
    	// Check if user is logged
        if ( !$this->_helper->Authentication->hasIdentity() ) {
    		$this->_redirect("admin/login");
    	}
    	
    	// update the user's activity
        $this->_helper->Authentication->updateUserActivity();
    }

    public function indexAction()
    {
        // action body
    }


}

