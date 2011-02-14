<?php

class Admin_Helper_Paginator extends Zend_Controller_Action_Helper_Abstract
{
	public function addPaginator(Zend_Db_Select $select, $page)
    {
        //$page = $this->_getParam('page', 1);
        $paginator = new Zend_Paginator(new Zend_Paginator_Adapter_DbSelect($select));
        $paginator->setItemCountPerPage(10)
                  ->setCurrentPageNumber($page)
                  ->setPageRange(5);
                  
        return $paginator;
    }
}
