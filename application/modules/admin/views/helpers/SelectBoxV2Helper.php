<?php

class Zend_View_Helper_SelectBoxV2Helper extends Zend_View_Helper_Abstract
{
	function selectBoxV2Helper() {
		$this->view->headScript()->prependFile(
			$this->view->baseUrl() . '/js/jquery/jquery.selectbox-0.5_style_2.js'
		);
	}
}