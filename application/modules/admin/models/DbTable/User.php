<?php

class Admin_Model_DbTable_User extends Zend_Db_Table_Abstract
{
	protected $_name = 'users';
	protected $_primary = 'user_id';
	protected $_sequence = true;
	protected $_referenceMap    = array(
        'Level' => array(
            'columns'           => 'user_level',
            'refTableClass'     => 'UserLevel',
            'refColumns'        => 'lev_level'
        )
    );
}