<?php

class Admin_Helper_UrlOrderBy extends Zend_Controller_Action_Helper_Abstract
{
	public function parse($orderBy, $columns)
    {
        //Tipo de ordenação
    	$orderType = array('asc', 'desc');
    	
    	//Obtém a coluna e tipo de ordenação
    	$order = explode('-', $orderBy);
    	
    	//Verifica se a coluna existe
    	if ( !isset( $columns[ $order[0] ] ) ) {
    		$order[0] = 'name';
    	}
    	
    	//Verifica se o tipo de ordem existe
    	if ( !in_array($order[1], $orderType) ) {
    		$order[1] = 'asc';
    	}
    	
    	//String de ordenação
    	$orderStr = $columns[$order[0]]['field'] . ' ' . $order[1];
    	
    	return $orderStr;
    }
}
