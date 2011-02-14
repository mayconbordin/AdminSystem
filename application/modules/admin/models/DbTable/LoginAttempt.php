<?php

class Admin_Model_DbTable_LoginAttempt extends Zend_Db_Table_Abstract
{
	protected $_name = 'login_attempts';
	protected $_primary = array('att_datetime', 'att_ip');
}

