<?php

class Admin_Form_User extends Zend_Form
{
	protected $id;
	protected $name;
	protected $email;
	protected $password;
	protected $password2;
	protected $level;
	protected $challenge;
	
	protected $remember;
	
	protected $saveBtn;
	protected $loginBtn;
	
    public function init()
    {
        $this->setName('userform');
    	$this->setAction('');
        $this->setMethod('POST');
        
        $this->id = new Zend_Form_Element_Hidden('id');
                
        $this->name = new Zend_Form_Element_Text('name');
        $this->name->setLabel('Usuário')
        	 ->addValidator('NotEmpty')
        	 ->addValidator('Alpha')
        	 ->addValidator('stringLength', false, array(5, 150))
         	 ->setRequired(true)
             ->addFilter('StringToLower')
             ->setErrorMessages( array("Valor não pode ser vazio") );
        	 
        $this->email = new Zend_Form_Element_Text('email');
        $this->email->setLabel('E-mail')
        	  ->addValidator('NotEmpty')
        	  ->addValidator('EmailAddress')
        	  ->addValidator('stringLength', false, array(1, 100))
         	  ->setRequired(true)
              ->addFilter('StringToLower')
              ->setErrorMessages( array("Valor não pode ser vazio") );
              
        $this->password = new Zend_Form_Element_Password('password');
        $this->password->setLabel('Senha')
        	  	 ->addValidator('NotEmpty')
        	  	 ->addValidator('stringLength', false, array(6))
         	  	 ->setRequired(true)
             	 ->setErrorMessages( array("Valor não pode ser vazio") );
              
        $this->password2 = new Zend_Form_Element_Password('password2');
        $this->password2->setLabel('Repetir Senha')
        	  	 	  ->addValidator('NotEmpty')
        	  	 	  ->addValidator('stringLength', false, array(6))
         	  	 	  ->setRequired(true)
             	 	  ->setErrorMessages( array("Valor não pode ser vazio") );
             	 
        $this->level = new Zend_Form_Element_Select('level');
        $this->level->setLabel('Nível')
        	  ->setErrorMessages( array("Valor não está na lista") );
        	  
       	//$this->level->addMultiOption(1, 'Um');
       	
       	$this->challenge = new Zend_Form_Element_Hidden('challenge');
       	
       	$this->remember = new Zend_Form_Element_Checkbox('login-check');
        $this->remember ->setLabel('Remember me')
        		  		->setAttrib('class', 'checkbox-size')
        		  		->setAttrib('id', 'login-check');
 
        $this->saveBtn = new Zend_Form_Element_Submit('save');
        $this->saveBtn->setLabel('Salvar')
        	 		  ->setName("submit");
        	 		  
        $this->loginBtn = new Zend_Form_Element_Submit('login');
        $this->loginBtn->setLabel('Login')
        	 		   ->setName("submit")
        	 		   ->setAttrib('class', 'submit-login');
    }
    
    public function getUserForm()
    {
    	$this->addElements(
            array(
            	$this->id,
                $this->name,
                $this->email,
                $this->password,
                $this->password2,
                $this->level,
                $this->saveBtn
            )
        );
        
        return $this;
    }
    
	public function getLoginForm()
    {
    	$this->name->setAttrib('class', 'login-inp');
    	$this->password->setAttrib('class', 'login-inp');
    	
    	$this->password->removeValidator('NotEmpty');
    	$this->password->removeValidator('stringLength');
    	$this->password->setRequired(false);
    	
    	$this->addElements(
            array(
            	$this->challenge,
                $this->name,
                $this->password,
                $this->remember,
                $this->loginBtn
            )
        );
        
        return $this;
    }
}