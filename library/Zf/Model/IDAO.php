<?php

interface Zf_Model_IDAO
{
	/**
	 * Set the DB-Table to be used in database transactions.
	 * 
	 * @param Zend_Db_Table_Abstract $dbTable
	 */
	public function setDbTable($dbTable);
	
	/**
	 * Get the DB-Table to be used in database transactions.
	 * 
	 * @return Zend_Db_Table_Abstract
	 */
	public function getDbTable();
}