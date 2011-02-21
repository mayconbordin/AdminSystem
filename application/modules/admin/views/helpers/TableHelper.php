<?php

class Zend_View_Helper_TableHelper extends Zend_View_Helper_Abstract
{
	public function tableHelper(array $config, $paginator)
	{
		//Allowed orders
        $orderType = array('asc', 'desc');
        
        //Get the order column and type
        $order = explode('-', $config['order']);
        
        //Check if the column exists
        if ( !isset( $config['columns'][ $order[0] ] ) ) {
        	$order[0] = $config['default-order'][0];
        }
        
        //Check if the order type exists
        if ( !in_array($order[1], $orderType) ) {
        	$order[1] = $config['default-order'][1];
        }
        
        //Set as selected the given order column
        $config['columns'][$order[0]]['selected'] = true;
        
        //Set the variables
        $this->view->paginator = $paginator;
        $this->view->orderCol  = $order[0];
        $this->view->orderType = $order[1];
        $this->view->columns   = $config['columns'];
        $this->view->mapper    = $config['mapper'];
        $this->view->url 	   = $config['url'];
        
        return $this->view->render("TableHelper.phtml");
	}
}