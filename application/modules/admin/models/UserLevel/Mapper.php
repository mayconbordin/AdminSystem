<?php

class Admin_Model_UserLevel_Mapper extends Zf_Model_DataMapper
{
	public function __construct()
    {
        $this->setMap(
            array(
                'lev_level'        	 => 'level',
                'lev_alias' 	 	 => 'alias'
            )
        );
    }
}
