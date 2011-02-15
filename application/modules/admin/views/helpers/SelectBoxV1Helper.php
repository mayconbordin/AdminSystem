<?php

class Zend_View_Helper_SelectBoxV1Helper extends Zend_View_Helper_Abstract
{
	function selectBoxV1Helper() {
		$this->view->headScript()->prependFile(
			$this->view->baseUrl() . '/js/jquery/jquery.selectbox-0.5.js',
			'text/javascript', array('conditional' => '!IE 7')
		);
	}
}