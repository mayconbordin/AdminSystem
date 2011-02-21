<?php

class Admin_UserController extends Zend_Controller_Action
{
	protected $_params;

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
    	$order = $this->_getParam('order', 'name-asc');
    	
    	//TRADUZIR titles
    	
    	$tableConfig = array(
    		'columns' => array(
    			'name' 	 	   => array('selected' => false, 'title' => 'Nome'), 
			    'email' 	   => array('selected' => false, 'title' => 'Email'), 
			    'level' 	   => array('selected' => false, 'title' => 'Nível', 'field' => 'lev_alias'), 
			    'lastActivity' => array('selected' => false, 'title' => 'Última Visita', 'filter' => create_function('$value', 'return gmdate("d/m/Y H:i:s", $value);')), 
    		),
    		'mapper' => new Admin_Model_User_Mapper(),
    		'order' => $order,
    		'default-order' => array('name', 'asc'),
    		'url' => array(
    			'module' => 'admin',
    			'controller' => 'user',
    			'id' => 'id'
    		)
    	);
    	
    	$orderStr = $this->_helper->UrlOrderBy->parse($order, $tableConfig);
    	    	
    	$userRepository = new Admin_Model_User_Repository();
        $select = $userRepository->select($orderStr);
                
        $this->view->paginator = $this->_helper->Paginator->addPaginator($select, $this->_getParam('page', 1));
    	$this->view->tableConfig = $tableConfig;
    }

    public function deleteAction()
    {
        // action body
    }

    public function editAction()
    {
    	$levelRepository = new Admin_Model_UserLevel_Repository();
    	$levels = $levelRepository->fetchAll();
    	
        $userForm = new Admin_Form_User();
        $userForm->removerNameValidators();
        $userForm->getElement('level')->setMultiOptions($levels);
        $userForm->getElement('name')->setAttrib('readonly', 'readonly');
        $userForm->getElement('name')->setDescription("");
	    $this->view->userForm = $userForm;
	    
    	// Verifica se foi submetido via POST
        if( !$this->_request->isPost() ) {
        	$userRepository = new Admin_Model_User_Repository();
    		$user = $userRepository->fetchRow( $this->_request->getParam('id') );
    		$userForm->populate($user->__toArray());
        	return false;
        }
        
        // Obtém os dados passados via POST
	    $this->_params = $this->_request->getPost();
	            
    	// Se os dados não forem validos
        if(!$userForm->isValid($this->_params)) {
        	return false;
        }
    }


}





