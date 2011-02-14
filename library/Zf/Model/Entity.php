<?php

abstract class Zf_Model_Entity
{
    /**
     * Class constructor.
     * 
     * @param array $options
     * @return void
     */
    public function __construct(array $options = null)
    {
        if (null !== $options && is_array($options)) {
            $this->setOptions($options);
        }
    }
    
    /**
     * Assign options to properties.
     * 
     * @param array $options
     * @return Zf_Model_Entity
     */
	public function setOptions(array $options)
    {
        $methods = get_class_methods($this);
        
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }
    
    /**
     * Return an string when the object is printed.
     * 
     * @return string
     */
    public function __toString()
    {
    	return get_class($this);
    }
    
	/**
     * Return an associative array containing all the properties in this object. 
     *
     * @return array
     */
    public function __toArray()
    {
        return get_object_vars($this);
    }
    
    /**
     * Create dynamic setters methods.
     * 
     * @param string $name
     * @param mixed $value
     * @throws BadMethodCallException
     */
    public function __set($name, $value)
    {
        $method = 'set' . $name;
        
        if (('mapper' == $name) || !method_exists($this, $method)) {
        	$message = 'Invalid method call: ' . get_class($this) . '::' . $method . '()';
        	throw new BadMethodCallException($message);
        }
        
        $this->$method($value);
    }
 
    /**
     * Create dynamic getters methods.
     * 
     * @param string $name
     * @return mixed
     * @throws BadMethodCallException
     */
    public function __get($name)
    {
        $method = 'get' . $name;
        
        if (('mapper' == $name) || !method_exists($this, $method)) {
            $message = 'Invalid method call: ' . get_class($this) . '::' . $method . '()';
        	throw new BadMethodCallException($message);
        }
        
        return $this->$method();
    }
}