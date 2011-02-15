<?php

class Admin_Model_UserLevel_Repository implements Admin_Model_UserLevel_IDAO, Zf_Model_IRepository
{
	protected $_dao;
	protected $_mapper;
	
	/**
	 * @param unknown_type $dao
	 */
	public function setDao($dao) {
		if (is_string($dao)) {
            $dao = new $dao();
        }
        if (!$dao instanceof Admin_Model_UserLevel_DAO) {
            throw new Admin_Model_UserLevel_Exception('Invalid data access object provided');
        }
        $this->_dao = $dao;
        
        return $this;
	}

	/**
	 * @return Zf_Model_IDAO
	 */
	public function getDao() {
		if (null === $this->_dao) {
            $this->setDao('Admin_Model_UserLevel_DAO');
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
            throw new Admin_Model_UserLevel_Exception('Invalid data mapper provided');
        }
        $this->_mapper = $mapper;
        
        return $this;
	}

	/**
	 * @return Zf_Model_DataMapper
	 */
	public function getMapper() {
		if (null === $this->_mapper) {
            $this->setMapper('Admin_Model_UserLevel_Mapper');
        }
        return $this->_mapper;
	}
	
	/**
	 * @param unknown_type $id
	 */
	public function fetchRow($id) {
		try {
			$row = $this->getDao()->fetchRow($id);
			$level = $this->getMapper()->assign(new Admin_Model_UserLevel_Entity(), $row);
			return $level;
		} catch (Admin_Model_UserLevel_Exception $ex) {
			throw $ex;
		} catch (Zf_Model_DataMapperException $ex) {
			throw new Admin_Model_UserLevel_Exception($ex);
		}
	}

/**
	 * @param unknown_type $where
	 * @param unknown_type $order
	 * @param unknown_type $count
	 * @param unknown_type $offset
	 */
	public function fetchAll($where = null, $order = null, $count = null, $offset = null) {
		try {
			$rows = $this->getDao()->fetchAll($where, $order, $count, $offset);
			$levels = array();
			
			foreach ( $rows as $row ) {
				$levels[] = $this->getMapper()->assign(new Admin_Model_UserLevel_Entity(), $row);
			}
			
			return $levels;
		} catch (Admin_Model_UserLevel_Exception $ex) {
			throw $ex;
		} catch (Zf_Model_DataMapperException $ex) {
			throw new Admin_Model_UserLevel_Exception($ex);
		}
		
		return null;
	}

	/**
	 * @param unknown_type $data
	 */
	public function save($data) {
		try {
			$dataArray = $this->getMapper()->map($data);
			$this->getDao()->save($dataArray);
		} catch (Admin_Model_UserLevel_Exception $ex) {
			throw $ex;
		}
		
		return null;
	}

	/**
	 * @param unknown_type $data
	 */
	public function delete($data) {
		try {
			$dataArray = $this->getMapper()->map($data);
			$this->getDao()->delete($dataArray);
		} catch (Admin_Model_UserLevel_Exception $ex) {
			throw $ex;
		}
		
		return null;
	}

	/**
	 * @param unknown_type $order
	 */
	public function select($order = null) {
		try {
			return $this->getDao()->select($order);
		} catch (Admin_Model_UserLevel_Exception $ex) {
			throw $ex;
		}
		
		return null;
	}
}
