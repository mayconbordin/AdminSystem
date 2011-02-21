<?php

class Zend_View_Helper_CheckboxScriptHelper extends Zend_View_Helper_Abstract
{
	function checkboxScriptHelper() {
		$this->view->headScript()->prependFile(
			$this->view->baseUrl() . '/js/jquery/jquery.bind.js'
		);
		
		$this->view->headScript()->prependFile(
			$this->view->baseUrl() . '/js/jquery/ui.checkbox.js'
		);
		
		$this->view->headScript()->prependFile(
			$this->view->baseUrl() . '/js/jquery/ui.core.js'
		);
	}
}