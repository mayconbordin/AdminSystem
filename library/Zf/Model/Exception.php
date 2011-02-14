<?php

class Zf_Model_Exception extends Zend_Exception
{
	public function __construct($ex)
	{
		if ($ex instanceof Exception) {
			parent::__construct($ex->getMessage(), $ex->getCode(), $ex);
		} elseif (is_string($ex)) {
			parent::__construct($ex);
		} else {
			parent::__construct('Unknown error');
		}
	}
}