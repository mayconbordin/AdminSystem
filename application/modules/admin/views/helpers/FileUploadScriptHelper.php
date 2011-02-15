<?php

class Zend_View_Helper_FileUploadScriptHelper extends Zend_View_Helper_Abstract
{
	function fileUploadScriptHelper() {
		$this->view->headScript()->prependFile(
			$this->view->baseUrl() . 'js/jquery/jquery.filestyle.js'
		);
	}
}