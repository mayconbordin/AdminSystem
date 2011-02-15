<?php

class Zend_View_Helper_DatePickerHelper extends Zend_View_Helper_Abstract
{
	function datePickerHelper() {
		$this->view->headLink()->prependStylesheet(
			$this->view->baseUrl() . 'css/datePicker.css'
		);
		
		$this->view->headScript()->prependFile(
			$this->view->baseUrl() . 'js/jquery/jquery.datePicker.js'
		);
		
		$this->view->headScript()->prependFile(
			$this->view->baseUrl() . 'js/jquery/date.js'
		);
	}
}