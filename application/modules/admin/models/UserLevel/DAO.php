<?php

class Admin_Model_UserLevel_DAO implements Zf_Model_IDAO, Login_Model_UserLevel_IDAO
{
	/**
	 * @var Login_Model_DbTable_UserLevel
	 */
	protected $_dbTable;
	
	/**
	 * @param unknown_type $dbTable
	 */
	public function setDbTable($dbTable) {
		if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Login_Model_UserLevel_Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        
        return $this;
	}

	/**
	 * @return Zend_Db_Table_Abstract
	 */
	public function getDbTable() {
		if (null === $this->_dbTable) {
            $this->setDbTable('Login_Model_DbTable_UserLevel');
        }
        return $this->_dbTable;
	}

	/**
	 * @param unknown_type $id
	 */
	public function fetchRow($id) {
		try {
	    	$result = $this->getDbTable()->find($id);
	    	
	        if (0 == count($result)) {
	            return null;
	        }
	        
	        $row = $result->current()->toArray();
	     
	        return $row;
		} catch(Exception $ex) {
			throw new Login_Model_UserLevel_Exception($ex);
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
			throw new Login_Model_UserLevel_Exception($ex);
		}
		
		return null;
	}

/**
	 * @param unknown_type $data
	 */
	public function save($data) {
		try {
	        if (null === $data['lev_level']) {
	            unset($data['lev_level']);
	            return $this->getDbTable()->insert($data);
	        } else {
	            $this->getDbTable()->update($data, array('lev_level = ?' => $data['lev_level']));
	        }
		} catch(Exception $ex) {
			throw new Login_Model_UserLevel_Exception($ex);
		}
		
		return null;
	}

/**
	 * @param unknown_type $data
	 */
	public function delete($data) {
		try {
			$this->getDbTable()->delete(array('lev_level = ?' => $data['lev_level']));
		} catch(Exception $ex) {
			throw new Login_Model_UserLevel_Exception($ex);
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
	    		   ->from('user_levels', array('lev_level', 'lev_alias'));
	    		   
	    	if ( !is_null($order) ) {
	    		$select->order( $order );
	    	}
	
	    	return $select;
		} catch(Exception $ex) {
			throw new Login_Model_UserLevel_Exception($ex);
		}
		
		return null;
	}
}
