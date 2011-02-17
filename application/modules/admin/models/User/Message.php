<?php

class Admin_Model_User_Message extends Zf_Model_Message
{
	const SUCCESS_LOGOUT = "logoutSuccess";
	const WRONG_USER_PASS = "wrongUserPass";
	
	protected $_messageTemplates = array(
        self::SUCCESS_LOGOUT => "You've logged out successfuly",
        self::WRONG_USER_PASS => "Username and/or password incorrect"
    );
}