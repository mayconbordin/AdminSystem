<?php

class Zf_Model_Message {
	/**
     * Failure message template definitions
     *
     * @var array
     */
    protected $_messageTemplates = array();
    
    /**
     * Translation object
     * @var Zend_Translate
     */
    protected $_translator;
    
    /**
     * Is translation disabled?
     * @var Boolean
     */
    protected $_translatorDisabled = false;
    
    /**
     * Get the message
     * 
     * @param string $messageKey
     * @param string $value
     */
	public function getMessage($messageKey, $value = null)
	{
		return $this->_createMessage($messageKey, $value);
	}
    
	/**
     * Constructs and returns a validation failure message with the given message key and value.
     *
     * Returns null if and only if $messageKey does not correspond to an existing template.
     *
     * If a translator is available and a translation exists for $messageKey,
     * the translation will be used.
     *
     * @param  string $messageKey
     * @param  string $value
     * @return string
     */
    private function _createMessage($messageKey, $value = null)
    {
        if (!isset($this->_messageTemplates[$messageKey])) {
            return null;
        }

        $message = $this->_messageTemplates[$messageKey];

        if (null !== ($translator = $this->getTranslator())) {
            if ($translator->isTranslated($messageKey)) {
                $message = $translator->translate($messageKey);
            } else {
                $message = $translator->translate($message);
            }
        }

        if (null != $value) {
	        if (is_object($value)) {
	            if (!in_array('__toString', get_class_methods($value))) {
	                $value = get_class($value) . ' object';
	            } else {
	                $value = $value->__toString();
	            }
	        } else {
	            $value = (string)$value;
	        }
	
	        $message = str_replace('%value%', (string) $value, $message);
        }

        return $message;
    }
    
	/**
     * Return translation object
     *
     * @return Zend_Translate_Adapter|null
     */
    public function getTranslator()
    {
        if ($this->translatorIsDisabled()) {
            return null;
        }

        if (null === $this->_translator) {
            return self::getDefaultTranslator();
        }

        return $this->_translator;
    }
    
   /**
     * Indicate whether or not translation should be disabled
     *
     * @param  bool $flag
     * @return Zend_Validate_Abstract
     */
    public function setDisableTranslator($flag)
    {
        $this->_translatorDisabled = (bool) $flag;
        return $this;
    }

    /**
     * Is translation disabled?
     *
     * @return bool
     */
    public function translatorIsDisabled()
    {
        return $this->_translatorDisabled;
    }
    
    /**
     * Set default translation object for all validate objects
     *
     * @param  Zend_Translate|Zend_Translate_Adapter|null $translator
     * @return void
     */
    public static function setDefaultTranslator($translator = null)
    {
        if ((null === $translator) || ($translator instanceof Zend_Translate_Adapter)) {
            self::$_defaultTranslator = $translator;
        } elseif ($translator instanceof Zend_Translate) {
            self::$_defaultTranslator = $translator->getAdapter();
        } else {
            require_once 'Zend/Validate/Exception.php';
            throw new Zend_Validate_Exception('Invalid translator specified');
        }
    }

    /**
     * Get default translation object for all validate objects
     *
     * @return Zend_Translate_Adapter|null
     */
    public static function getDefaultTranslator()
    {
        require_once 'Zend/Registry.php';
        if (Zend_Registry::isRegistered('Zend_Translate')) {
            $translator = Zend_Registry::get('Zend_Translate');
            if ($translator instanceof Zend_Translate_Adapter) {
                return $translator;
            } elseif ($translator instanceof Zend_Translate) {
                return $translator->getAdapter();
            }
        }
    }
}