<?php

class Zend_View_Helper_SHA256Helper extends Zend_View_Helper_Abstract
{
	function sHA256Helper() {
		$this->view->headScript()->prependFile(
			$this->view->baseUrl() . '/js/sha256.js'
		);
	}
}