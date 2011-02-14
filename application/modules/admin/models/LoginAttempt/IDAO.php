<?php

interface Admin_Model_LoginAttempt_IDAO
{
	public function fetchRow($datetime, $ip);
    public function fetchAll($where = null, $order = null, $count = null, $offset = null);
    
    public function save($data);
    public function delete($data);
    public function select($order = null);
}
