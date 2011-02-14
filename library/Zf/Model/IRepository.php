<?php

interface Zf_Model_IRepository
{
	/**
	 * Set the DAO to be used in transactions.
	 * 
	 * @param Zf_Model_IDAO $dao
	 */
	public function setDao($dao);
	
	/**
	 * Get the DAO to be used in transactions.
	 * 
	 * @return Zf_Model_IDAO
	 */
	public function getDao();
	
	/**
	 * Set the Mapper to be used in data conversion.
	 * 
	 * @param Zf_Model_DataMapper $mapper
	 */
	public function setMapper($mapper);
	
	/**
	 * Get the Mapper to be used in data conversion.
	 * 
	 * @return Zf_Model_DataMapper
	 */
	public function getMapper();
}