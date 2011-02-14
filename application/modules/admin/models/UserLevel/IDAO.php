<?php

interface Admin_Model_UserLevel_IDAO
{
	public function fetchRow($id);
    public function fetchAll($where = null, $order = null, $count = null, $offset = null);
    
    public function save($data);
    public function delete($data);
    public function select($order = null);
}

