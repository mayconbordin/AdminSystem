<?php

class Zend_View_Helper_ShakeUIHelper extends Zend_View_Helper_Abstract
{
	function shakeUIHelper() {
		$this->view->headLink()->prependStylesheet(
			$this->view->baseUrl() . '/css/ui/ui-darkness/jquery.ui.all.css'
		);
		
		$this->view->headScript()->prependFile(
			$this->view->baseUrl() . '/js/jquery/ui/jquery.effects.shake.min.js'
		);
		
		$this->view->headScript()->prependFile(
			$this->view->baseUrl() . '/js/jquery/ui/jquery.effects.core.min.js'
		);
	}
}