<?php

class Admin_UserController extends Zend_Controller_Action
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
        //Colunas habilitadas
        $columns = array(
        	'name' => 'user_name', 
            'email' => 'user_email',
            'level' => 'lev_alias',
            'lastactivity' => 'user_last_activity'
        );
                    
        $orderStr = $this->_helper->UrlOrderBy->parse($this->_getParam('order', 'name-asc'), $columns);
                    
        //Tipo de ordenação
        $orderType = array('asc', 'desc');
        
        //Obtém a coluna e tipo de ordenação
        $order = explode('-', $this->_getParam('order', 'name-asc'));
        
        //Verifica se a coluna existe
        if ( !isset( $columns[ $order[0] ] ) ) {
        	$order[0] = 'name';
        }
        
        //Verifica se o tipo de ordem existe
        if ( !in_array($order[1], $orderType) ) {
        	$order[1] = 'asc';
        }
        
        //String de ordenação
        $orderStr = $columns[$order[0]] . ' ' . $order[1];
                    
        $userRepository = new Admin_Model_User_Repository();
        $select = $userRepository->select($orderStr);
        
        $this->view->paginator = $this->_helper->Paginator->addPaginator($select, $this->_getParam('page', 1));
        
        $this->view->orderCol = $order[0];
        $this->view->orderType = $order[1];
    }

    public function deleteAction()
    {
        // action body
    }

    public function editAction()
    {
        $userRepository = new Admin_Model_User_Repository();
    	$user = $userRepository->fetchRow( $this->_request->getParam('id') );
    	
        $userForm = new Admin_Form_User();
        $userForm = $userForm->getUserForm();
        $userForm->populate($user->__toArray());
        //use populate to fill the form with data
        
        
        print_r($user->__toArray());
        
	    $this->view->userForm = $userForm;
    }


}





