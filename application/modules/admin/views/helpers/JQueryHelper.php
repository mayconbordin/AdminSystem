<?php

class Zend_View_Helper_JQueryHelper extends Zend_View_Helper_Abstract
{
	function jQueryHelper() {
		$this->view->headScript()->prependFile(
			$this->view->baseUrl() . '/js/jquery/jquery-1.4.4.min.js'
		);
	}
}