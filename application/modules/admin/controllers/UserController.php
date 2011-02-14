<?php

class Admin_UserController extends Zend_Controller_Action
{

    public function init()
    {
        // Check if user is logged
        if ( !$this->_helper->Authentication->hasIdentity() ) {
    		$this->_redirect("admin/login");
    	}
    }

    public function indexAction()
    {
        // action body
    }

    public function deleteAction()
    {
        // action body
    }

    public function editAction()
    {
        // action body
    }


}





