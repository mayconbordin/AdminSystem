<?php

class Zend_View_Helper_DroplineIEStylesheetHelper extends Zend_View_Helper_Abstract
{
	function droplineIEStylesheetHelper() {
		$this->view->headLink()->prependStylesheet(
			$this->view->baseUrl() . '/css/layouts/login/pro_dropline_ie.css',
			'screen', 'IE'
		);
	}
}