<?php

interface Admin_Model_User_IDAO
{
	public function fetchRow($id);
    public function fetchAll($where = null, $order = null, $count = null, $offset = null);
    public function fetchByName($name);
    
    public function existsByNameAndChallenge($name, $challenge);
    
    public function save($data);
    public function delete($data);
    public function select($order = null);
    
    public function updateChallenge($data);
    public function updateLastActivity($data);
}
