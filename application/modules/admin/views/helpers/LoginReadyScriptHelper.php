<?php

class Zend_View_Helper_LoginReadyScriptHelper extends Zend_View_Helper_Abstract
{
	function loginReadyScriptHelper() {
		$this->view->headScript()->prependFile(
			$this->view->baseUrl() . '/js/login/common.js'
		);
	}
}