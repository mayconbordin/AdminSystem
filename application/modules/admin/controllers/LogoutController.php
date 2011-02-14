<?php

class Admin_LogoutController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $objAuth = Zend_Auth::getInstance();
 
        // clear the user identity
        $objAuth->clearIdentity();
        
        $this->_redirect("admin");
    }


}

