<?php

class Admin_Model_LoginAttempt_Repository implements Zf_Model_IRepository, Admin_Model_LoginAttempt_IDAO
{
	protected $_dao;
	protected $_mapper;
	
	/**
	 * @param Admin_Model_LoginAttempt_DAO $dao
	 */
	public function setDao($dao) {
		if (is_string($dao)) {
            $dao = new $dao();
        }
        if (!$dao instanceof Admin_Model_LoginAttempt_DAO) {
            throw new Admin_Model_LoginAttempt_Exception('Invalid data access object provided');
        }
        $this->_dao = $dao;
        
        return $this;
	}

	/**
	 * @return Admin_Model_LoginAttempt_DAO
	 */
	public function getDao() {
		if (null === $this->_dao) {
            $this->setDao('Admin_Model_LoginAttempt_DAO');
        }
        return $this->_dao;
	}

	/**
	 * @param unknown_type $mapper
	 */
	public function setMapper($mapper) {
		if (is_string($mapper)) {
            $mapper = new $mapper();
        }
        if (!$mapper instanceof Zf_Model_DataMapper) {
            throw new Admin_Model_LoginAttempt_Exception('Invalid data mapper provided');
        }
        $this->_mapper = $mapper;
        
        return $this;
	}

	/**
	 * @return Zf_Model_DataMapper
	 */
	public function getMapper() {
		if (null === $this->_mapper) {
            $this->setMapper('Admin_Model_LoginAttempt_Mapper');
        }
        return $this->_mapper;
	}

	/**
	 * 
	 * @param unknown_type $datetime
	 * @param unknown_type $ip
	 */
	public function fetchRow($datetime, $ip) {
		try {
			$row = $this->getDao()->fetchRow($datetime, $ip);
			$loginAttempt = $this->getMapper()->assign(new Admin_Model_LoginAttempt_Entity(), $row);
			return $loginAttempt;
		} catch (Admin_Model_LoginAttempt_Exception $ex) {
			throw $ex;
		} catch (Zf_Model_DataMapperException $ex) {
			throw new Admin_Model_LoginAttempt_Exception($ex);
		}
	}

	/**
	 * @param unknown_type unknown_type $where
	 * @param unknown_type unknown_type $order
	 * @param unknown_type unknown_type $count
	 * @param unknown_type unknown_type $offset
	 */
	public function fetchAll($where = null, $order = null, $count = null, $offset = null) {
		try {
			$rows = $this->getDao()->fetchAll($where, $order, $count, $offset);
			$loginAttempts = array();
			
			foreach ( $rows as $row ) {
				$loginAttempts[] = $this->getMapper()->assign(new Admin_Model_LoginAttempt_Entity(), $row);
			}
			
			return $loginAttempts;
		} catch (Admin_Model_LoginAttempt_Exception $ex) {
			throw $ex;
		} catch (Zf_Model_DataMapperException $ex) {
			throw new Admin_Model_LoginAttempt_Exception($ex);
		}
		
		return null;
	}

	/**
	 * @param unknown_type unknown_type $data
	 */
	public function save($data) {
		try {
			$dataArray = $this->getMapper()->map($data);
			$this->getDao()->save($dataArray);
		} catch (Admin_Model_LoginAttempt_Exception $ex) {
			throw $ex;
		}
		
		return null;
	}

/**
	 * @param unknown_type unknown_type $data
	 */
	public function delete($data) {
		try {
			$dataArray = $this->getMapper()->map($data);
			$this->getDao()->delete($dataArray);
		} catch (Admin_Model_LoginAttempt_Exception $ex) {
			throw $ex;
		}
		
		return null;
	}

	/**
	 * 
	 * @param unknown_type $order
	 */
	public function select($order = null) {
		try {
			return $this->getDao()->select($order);
		} catch (Admin_Model_LoginAttempt_Exception $ex) {
			throw $ex;
		}
		
		return null;
	}
}
