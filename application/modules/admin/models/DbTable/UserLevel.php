<?php

class Admin_Model_DbTable_UserLevel extends Zend_Db_Table_Abstract
{
    protected $_name = 'user_levels';
	protected $_primary = 'lev_level';
	protected $_sequence = false;
	protected $_dependentTables = array('User');
}