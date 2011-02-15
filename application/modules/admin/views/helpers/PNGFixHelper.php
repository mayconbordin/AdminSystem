<?php

class Zend_View_Helper_PNGFixHelper extends Zend_View_Helper_Abstract
{
	function pNGFixHelper() {
		$this->view->headScript()->prependScript( "
			$(document).ready(function() {
				$(document).pngFix( );
			});
		");
		
		$this->view->headScript()->prependFile(
			$this->view->baseUrl() . '/js/jquery/jquery.pngFix.pack.js'
		);
	}
}