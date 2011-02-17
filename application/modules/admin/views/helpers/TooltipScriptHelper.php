<?php

class Zend_View_Helper_TooltipScriptHelper extends Zend_View_Helper_Abstract
{
	function tooltipScriptHelper() {
		$this->view->headScript()->prependFile(
			$this->view->baseUrl() . '/js/jquery/jquery.dimensions.js'
		);
		
		$this->view->headScript()->prependFile(
			$this->view->baseUrl() . '/js/jquery/jquery.tooltip.js'
		);
	}
}