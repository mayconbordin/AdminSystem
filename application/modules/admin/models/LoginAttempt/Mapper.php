<?php

class Admin_Model_LoginAttempt_Mapper extends Zf_Model_DataMapper
{
	public function __construct()
    {
        $this->setMap(
            array(
                'att_datetime'   => 'datetime',
                'att_ip' 	 	 => 'ip',
                'att_success'  	 => 'success',
            	'att_username'   => 'username'
            )
        );
    }
}
