<?php

class Admin_Form_Login extends Zend_Form
{

    public function init()
    {
        $name = new Zend_Form_Element_Text('name');
        $name->setLabel('formLabels_Username')
         	 ->setRequired(true)
             ->addFilter('StringToLower')
             ->setAttrib('class', 'login-inp');
                          
        $password = new Zend_Form_Element_Password('password');
        $password->setLabel('formLabels_Password')
        		 ->setAttrib('class', 'login-inp');
        
        $challenge = new Zend_Form_Element_Hidden('challenge');
        
        $remember = new Zend_Form_Element_Checkbox('login-check');
        $remember->setLabel('formLabels_RememberMe')
        		 ->setAttrib('class', 'checkbox-size')
        		 ->setAttrib('id', 'login-check');
        
        $login = new Zend_Form_Element_Submit('login');
        $login->setLabel('formLabels_Login')
        	  ->setName("submit")
        	  ->setAttrib('class', 'submit-login');
        	 	 
        $this->addElements(
            array(
                $name,
                $password,
                $challenge,
                $remember,
                $login
            )
        );
    }
}

