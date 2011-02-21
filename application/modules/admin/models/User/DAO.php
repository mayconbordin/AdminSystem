<?php

class Admin_Model_User_DAO implements Zf_Model_IDAO, Admin_Model_User_IDAO
{
	/**
	 * @var Admin_Model_DbTable_User
	 */
	protected $_dbTable;
	
	/**
	 * @param string|Admin_Model_DbTable_User $dbTable
	 * @return Admin_Model_User_DAO
	 * @throws Admin_Model_User_Exception
	 */
	public function setDbTable($dbTable) {
		if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Admin_Model_User_Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        
        return $this;
	}

	/**
	 * @return Zend_Db_Table_Abstract
	 */
	public function getDbTable() {
		if (null === $this->_dbTable) {
            $this->setDbTable('Admin_Model_DbTable_User');
        }
        return $this->_dbTable;
	}
	
	/**
	 * @param int $id
	 * @return array
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
			throw new Admin_Model_User_Exception($ex);
		}
		
		return null;
	}

	/**
	 * @param string|array|Zend_Db_Table_Select $where
	 * @param string|array $order
	 * @param int $count
	 * @param int $offset
	 * @return array
	 */
	public function fetchAll($where = null, $order = null, $count = null, $offset = null) {
		try {
			$resultSet = $this->getDbTable()->fetchAll($where, $order, $count, $offset);
	        return $resultSet->toArray();
		} catch(Exception $ex) {
			throw new Admin_Model_User_Exception($ex);
		}
		
		return null;
	}

	/**
	 * @param string $name
	 * @return array
	 */
	public function fetchByName($name) {
		try {
	    	$row = $this->getDbTable()->fetchRow( array('user_name = ?' => $name) );
	    	    	
	        if (0 == count($row)) {
	            return null;
	        }
	                  
	        return $row->toArray();
		} catch(Exception $ex) {
			throw new Admin_Model_User_Exception($ex);
		}
		
		return null;
	}
	
	/**
	 * @param string $name
	 * @return bool
	 */
	public function existsByNameAndChallenge($name, $challenge) {
		try {
			$select = $this->getDbTable()
	    		   ->select()
        		   ->from($this->getDbTable(), array('count(*) as amount'))
        		   ->where('user_name = ?', $name)
        		   ->where('user_challenge = ?', $challenge);
        	$rows = $this->getDbTable()->fetchAll($select);
        	
        	if ($rows[0]->amount > 0) {
        		return true;
        	} else {
        		return false;
        	}
		} catch(Exception $ex) {
			throw new Admin_Model_User_Exception($ex);
		}
		
		return false;
	}

	/**
	 * @param array $data
	 * @return null|int
	 */
	public function save($data) {
		try {
	        if (null === $data['user_id']) {
	            unset($data['user_id']);
	            return $this->getDbTable()->insert($data);
	        } else {
	            $this->getDbTable()->update($data, array('user_id = ?' => $data['user_id']));
	        }
		} catch(Exception $ex) {
			throw new Admin_Model_User_Exception($ex);
		}
		
		return null;
	}

	/**
	 * @param array $data
	 */
	public function delete($data) {
		try {
			if (is_array($data)) {
				$this->getDbTable()->delete(array('user_id = ?' => $data['user_id']));
			} else {
				$this->getDbTable()->delete('user_id IN (?)', $data);
			}
		} catch(Exception $ex) {
			throw new Admin_Model_User_Exception($ex);
		}
		
		return null;
	}

	/**
	 * @param string $order
	 */
	public function select($order = null) {
		try {
			$select = $this->getDbTable()
	    		   ->select()
	    		   ->from($this->getDbTable(), array('user_id', 'user_name', 'user_email', 'user_last_activity'))
	    		   ->setIntegrityCheck(false)
	    		   ->join('user_levels', 'user_levels.lev_level = users.user_level', 'lev_alias');
	    		   
	    	if ( !is_null($order) ) {
	    		$select->order( $order );
	    	}
	
	    	return $select;
		} catch(Exception $ex) {
			throw new Admin_Model_User_Exception($ex);
		}
		
		return null;
	}

	/**
	 * @param int $id
	 * @param string $challenge
	 */
	public function updateChallenge($data) {
		try {
			$id = $data['user_id'];
			
			$data = array(
	        	'user_challenge' => $data['user_challenge']
	        );
	 
	        $this->getDbTable()->update($data, array('user_id = ?' => $id));
		} catch(Exception $ex) {
			throw new Admin_Model_User_Exception($ex);
		}
		
		return null;
	}

	/**
	 * @param int $id
	 * @param int $lastActivity
	 */
	public function updateLastActivity($data) {
		try {
			$id = $data['user_id'];
			
			$data = array(
	        	'user_last_activity' => $data['user_last_activity']
	        );
	 
	        $this->getDbTable()->update($data, array('user_id = ?' => $id));
		} catch(Exception $ex) {
			throw new Admin_Model_User_Exception($ex);
		}
		
		return null;
	}
}
