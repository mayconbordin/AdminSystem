<?php

class Admin_Bootstrap extends Zend_Application_Module_Bootstrap
{
    public function initResourceLoader()
    {
        $loader = $this->getResourceLoader();
        $loader->addResourceType('helper', 'helpers', 'Helper');
    }

    protected function _initConfig()
    {
        $env = $this->getEnvironment();
        $config = new Zend_Config_Ini(
            dirname(__FILE__) . '/configs/admin.ini', 
            $this->getEnvironment()
        );
        
        Zend_Registry::set('admin_config', $config);
        
        return $config;
    }

    protected function _initHelpers()
    {
        $this->bootstrap('config');
        $config = $this->getResource('config');

        Zend_Controller_Action_HelperBroker::addHelper(
            new Admin_Helper_Authentication()
        );
        
        Zend_Controller_Action_HelperBroker::addHelper(
            new Admin_Helper_Paginator()
        );
        
        Zend_Controller_Action_HelperBroker::addHelper(
            new Admin_Helper_UrlOrderBy()
        );
    }
    
	protected function _initLayout()
    {
        $options = array('layout'     => 'layout',
                         'layoutPath' => APPLICATION_PATH . '/modules/admin/layouts/scripts/',
                         'content'    => 'content');
        Zend_Layout::startMvc($options);
    }
}
