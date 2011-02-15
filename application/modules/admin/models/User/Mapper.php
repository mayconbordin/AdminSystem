<?php

class Admin_Model_User_Mapper extends Zf_Model_DataMapper
{
	public function __construct()
    {
        $this->setMap(
            array(
                'user_id'        	 => 'id',
                'user_name' 	 	 => 'name',
                'user_email'  	 	 => 'email',
            	'user_password'  	 => 'password',
            	'user_challenge' 	 => 'challenge',
            	'user_level' 	 	 => array(
            								'class' => 'Admin_Model_UserLevel_Entity', 
            								'child' => 'level', 
            								'parent' => 'level'),
            	'user_last_activity' => 'lastActivity'
            )
        );
    }
}
