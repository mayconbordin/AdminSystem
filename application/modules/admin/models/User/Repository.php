<?php

class Admin_Model_User_Repository implements Login_Model_User_IDAO, Zf_Model_IRepository
{
	protected $_dao;
	protected $_mapper;
	
	/**
	 * @param Login_Model_User_DAO $dbTable
	 */
	public function setDao($dao) {
		if (is_string($dao)) {
            $dao = new $dao();
        }
        if (!$dao instanceof Login_Model_User_DAO) {
            throw new Login_Model_User_Exception('Invalid data access object provided');
        }
        $this->_dao = $dao;
        
        return $this;
	}

	/**
	 * @return Login_Model_User_DAO
	 */
	public function getDao() {
		if (null === $this->_dao) {
            $this->setDao('Login_Model_User_DAO');
        }
        return $this->_dao;
	}
	
	/**
	 * @param string|Login_Model_User_Mapper $mapper
	 */
	public function setMapper($mapper) {
		if (is_string($mapper)) {
            $mapper = new $mapper();
        }
        if (!$mapper instanceof Zf_Model_DataMapper) {
            throw new Login_Model_User_Exception('Invalid data mapper provided');
        }
        $this->_mapper = $mapper;
        
        return $this;
	}

	/**
	 * @return Login_Model_User_Mapper
	 */
	public function getMapper() {
		if (null === $this->_mapper) {
            $this->setMapper('Login_Model_User_Mapper');
        }
        return $this->_mapper;
	}
	
	/**
	 * @param int $id
	 * @return Login_Model_User_Entity
	 */
	public function fetchRow($id) {
		try {
			$row = $this->getDao()->fetchRow($id);
			$user = $this->getMapper()->assign(new Login_Model_User_Entity(), $row);
			return $user;
		} catch (Login_Model_User_Exception $ex) {
			throw $ex;
		} catch (Zf_Model_DataMapperException $ex) {
			throw new Login_Model_User_Exception($ex);
		}
	}

	/**
	 * @param string|array|Zend_Db_Table_Select $where
	 * @param string|array $order
	 * @param int $count
	 * @param int $offset
	 * @return array of Login_Model_User_Entity
	 */
	public function fetchAll($where = null, $order = null, $count = null, $offset = null) {
		try {
			$rows = $this->getDao()->fetchAll($where, $order, $count, $offset);
			$users = array();
			
			foreach ( $rows as $row ) {
				$users[] = $this->getMapper()->assign(new Login_Model_User_Entity(), $row);
			}
			
			return $users;
		} catch (Login_Model_User_Exception $ex) {
			throw $ex;
		} catch (Zf_Model_DataMapperException $ex) {
			throw new Login_Model_User_Exception($ex);
		}
		
		return null;
	}

	/**
	 * @param string $name
	 * @return Login_Model_User_Entity
	 */
	public function fetchByName($name) {
		try {
			$row = $this->getDao()->fetchByName($name);
			$user = $this->getMapper()->assign(new Login_Model_User_Entity(), $row);
			return $user;
		} catch (Login_Model_User_Exception $ex) {
			throw $ex;
		} catch (Zf_Model_DataMapperException $ex) {
			throw new Login_Model_User_Exception($ex);
		}
		
		return null;
	}

	/**
	 * @param Login_Model_User_Entity $data
	 */
	public function save($data) {
		try {
			$dataArray = $this->getMapper()->map($data);
			$this->getDao()->save($dataArray);
		} catch (Login_Model_User_Exception $ex) {
			throw $ex;
		}
		
		return null;
	}

	/**
	 * @param Login_Model_User_Entity $data
	 */
	public function delete($data) {
		try {
			$dataArray = $this->getMapper()->map($data);
			$this->getDao()->delete($dataArray);
		} catch (Login_Model_User_Exception $ex) {
			throw $ex;
		}
		
		return null;
	}

	/**
	 * @param string $order
	 */
	public function select($order = null) {
		try {
			$this->getDao()->select($order);
		} catch (Login_Model_User_Exception $ex) {
			throw $ex;
		}
		
		return null;
	}

	/**
	 * @param Login_Model_User_Entity $data
	 */
	public function updateChallenge($data) {
		try {
			$dataArray = $this->getMapper()->map($data);
			$this->getDao()->updateChallenge($dataArray);
		} catch (Login_Model_User_Exception $ex) {
			throw $ex;
		} catch (Zf_Model_DataMapperException $ex) {
			throw new Login_Model_User_Exception($ex);
		}
		
		return null;
	}

	/**
	 * @param Login_Model_User_Entity $data
	 */
	public function updateLastActivity($data) {
		try {
			$dataArray = $this->getMapper()->map($data);
			$this->getDao()->updateLastActivity($dataArray);
		} catch (Login_Model_User_Exception $ex) {
			throw $ex;
		} catch (Zf_Model_DataMapperException $ex) {
			throw new Login_Model_User_Exception($ex);
		}
		
		return null;
	}
}
