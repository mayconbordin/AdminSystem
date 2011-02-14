<?php

class Admin_Model_LoginAttempt_DAO implements Zf_Model_IDAO, Login_Model_LoginAttempt_IDAO
{
	/**
	 * @var Login_Model_DbTable_LoginAttempt
	 */
	protected $_dbTable;
	
	/**
	 * @param unknown_type unknown_type $dbTable
	 */
	public function setDbTable($dbTable) {
		if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Login_Model_LoginAttempt_Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        
        return $this;
	}

	/**
	 * @return Zend_Db_Table_Abstract
	 */
	public function getDbTable() {
		if (null === $this->_dbTable) {
            $this->setDbTable('Login_Model_DbTable_LoginAttempt');
        }
        return $this->_dbTable;
	}
	
	/**
	 * 
	 * @param unknown_type $datetime
	 * @param unknown_type $ip
	 */
	public function fetchRow($datetime, $ip) {
		try {
	    	$result = $this->getDbTable()->find($datetime, $ip);
	    	
	        if (0 == count($result)) {
	            return null;
	        }
	        
	        $row = $result->current()->toArray();
	     
	        return $row;
		} catch(Exception $ex) {
			throw new Login_Model_LoginAttempt_Exception($ex);
		}
		
		return null;
	}

/**
	 * @param unknown_type $where
	 * @param unknown_type $order
	 * @param unknown_type $count
	 * @param unknown_type $offset
	 */
	public function fetchAll($where = null, $order = null, $count = null, $offset = null) {
		try {
			$resultSet = $this->getDbTable()->fetchAll($where, $order, $count, $offset);
	        return $resultSet->toArray();
		} catch(Exception $ex) {
			throw new Login_Model_LoginAttempt_Exception($ex);
		}
		
		return null;
	}

	/**
	 * @param unknown_type $data
	 */
	public function save($data) {
		try {
			if ( is_null( $this->fetchRow($data['att_datetime'], $data['att_ip']) ) ) {
	        	$this->getDbTable()->insert($data);
	        } else {
	        	$datetime = $data['att_datetime'];
	        	$ip = $data['att_ip'];
	        	
	        	unset($data['att_datetime']);
	        	unset($data['att_ip']);
	        	
	        	$this->getDbTable()->update($data, array(
	    				'att_datetime' => $datetime,
	    				'att_ip' 	   => $ip
	    			));
	        }
		} catch(Exception $ex) {
			throw new Login_Model_LoginAttempt_Exception($ex);
		}
		
		return null;
	}

	/**
	 * @param unknown_type $data
	 */
	public function delete($data) {
		try {
			$this->getDbTable()->delete(array(
	    				'att_datetime' => $data['att_datetime'],
	    				'att_ip' 	   => $data['att_ip']
			));
		} catch(Exception $ex) {
			throw new Login_Model_LoginAttempt_Exception($ex);
		}
		
		return null;
	}

	/**
	 * @param unknown_type $order
	 */
	public function select($order = null) {
		try {
			$select = $this->getDbTable()
	    		   ->select()
	    		   ->from('login_attempts', array('att_datetime', 'att_ip', 'att_success', 'att_username'));
	    		   
	    	if ( !is_null($order) ) {
	    		$select->order( $order );
	    	}
	
	    	return $select;
		} catch(Exception $ex) {
			throw new Login_Model_LoginAttempt_Exception($ex);
		}
		
		return null;
	}
}
