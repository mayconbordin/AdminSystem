<?php

class Admin_Form_User extends Zend_Form
{
	protected $_inputDecorator = array(
		    'ViewHelper',
        	array('Description',array('tag'=>'td')),
            'CustomErrors',
            array(array('data'=>'HtmlTag'),
            array('tag'=>'td')),
            array('Label',array('tag'=>'th', 'requiredSuffix' => ' *')),
            array(array('row'=>'HtmlTag'),array('tag'=>'tr')),
	);
	
	protected $_inputDecorator2 = array(
		    'ViewHelper',
        	array('Description',array('tag'=>'td')),
            'CustomErrors',
            array(array('data'=>'HtmlTag'),
            array('tag'=>'td')),
            array('Label',array('tag'=>'th', 'requiredSuffix' => '')),
            array(array('row'=>'HtmlTag'),array('tag'=>'tr')),
	);
	
    public function init()
    {
        $this->setName('userform');
    	$this->setAction('');
        $this->setMethod('POST');
        
        $this->addElementPrefixPath('Zf_Form_Decorator',
                            'Zf/Form/Decorator/',
                            'decorator');
        
        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array(
            	'tag' => 'table', 
            	'border' => "0", 
            	'cellpadding' => "0", 
            	'cellspacing' => "0", 
            	'id' => "id-form")),
            'Form',
        ));
                        
        $id = new Zend_Form_Element_Hidden('id');
                        
        $name = new Zend_Form_Element_Text('name');
        $name->setLabel('Usuário')
        	 ->addValidator('NotEmpty')
        	 ->addValidator('Alpha')
        	 ->addValidator('stringLength', false, array(5, 150))
         	 ->setRequired(true)
             ->addFilter('StringToLower')
             ->setAttrib('class', 'inp-form')
             ->setDecorators($this->_inputDecorator);
      	 
        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('E-mail')
        	  ->addValidator('NotEmpty')
        	  ->addValidator('EmailAddress')
        	  ->addValidator('stringLength', false, array(1, 100))
         	  ->setRequired(true)
              ->addFilter('StringToLower')
             ->setAttrib('class', 'inp-form')
             ->setDecorators($this->_inputDecorator);
              
        $password = new Zend_Form_Element_Password('password');
        $password->setLabel('Senha')
        	  	 ->addValidator('NotEmpty')
        	  	 ->addValidator('stringLength', false, array(6))
         	  	 ->setRequired(true)
             	 ->setAttrib('class', 'inp-form')
             	 ->setDecorators($this->_inputDecorator);
              
        $password2 = new Zend_Form_Element_Password('password2');
        $password2->setLabel('')
        	  	  ->addValidator('NotEmpty')
        	  	  ->addValidator('stringLength', false, array(6))
         	  	  ->setRequired(true)
             	  ->setAttrib('class', 'inp-form')
             	  ->setDecorators($this->_inputDecorator2);
             	 
        $level = new Zend_Form_Element_Select('level');
        $level->setLabel('Nível')
        	  ->setAttrib('class', 'styledselect_form_1')
        	  ->setDecorators($this->_inputDecorator);
 
        $save = new Zend_Form_Element_Submit('save');
        $save->setLabel('')
        	 ->setAttrib('class', 'form-submit')
        	 ->setName("submit")
        	 ->setDecorators($this->_inputDecorator);
        	 
       	$this->addElements(
            array(
                $id,
                $name,
                $email,
                $password,
                $password2,
                $level,
                $save
            )
        );
    }
    
    public function removerNameValidators() {
    	$name = $this->getElement('name');
    	$name->removeValidator('NotEmpty');
    	$name->removeValidator('Alpha');
    	$name->removeValidator('stringLength');
    	$name->setRequired(false);
    }
}