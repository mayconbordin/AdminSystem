<?php

class Zend_View_Helper_TableHelper extends Zend_View_Helper_Abstract
{
	/**
	 * 
	 * @param $columns As colunas a serem exibidas, devem ser identificadas pelo seu
	 * alias e devem conter o nome do campo na tabela e o nome a ser exibido no header.
	 * Ex.: $columns['user'] = array('field' => 'user_name', 'name' => 'Usuário');
	 * @param $paginator
	 * @param $order
	 * @param $urlOptions
	 */
	function tableHelper($columns, $paginator, $orderBy, $urlOptions) {
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
    	
		$this->view->columns = $columns;
		$this->view->paginator = $paginator;
		$this->view->orderCol = $order[0];
		$this->view->orderType = $order[1];
		$this->view->urlOptions = $urlOptions;
		
		return $this->view->render("helpers/TableHelper.phtml");
	}
}
