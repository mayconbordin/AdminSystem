<?php

class Zf_Model_DataMapperException extends Zf_Model_Exception {}

class Zf_Model_DataMapper
{
    /**
     * @var array
     */
    protected $map = array();

    /**
     * Class constructor.
     *
     * @param array $map
     * @return void
     */
    public function __construct(array $map = null)
    {
        if (null !== $map) {
            $this->setMap($map);
        }
    }

    /**
     * Set map array. 
     *
     * @param array $map
     * @return void
     */
    public function setMap(array $map)
    {
        $this->map = $map;
    }

    /**
     * Return map array.
     *
     * @return array
     */
    public function getMap()
    {
        return $this->map;
    }

    /**
     * Append fields to the map array.
     *
     * @param array
     * @return void
     */
    public function append(array $fields)
    {
        $this->setMap(array_merge($this->getMap(), $fields));
    }
    
	/**
	 * Set a value in an object through its attribute accessor.
	 * 
	 * @param object $object
	 * @param string $attribute
	 * @param mixed $value
	 * @throws Zf_Model_DataMapperException
	 */
	private function __setValue($object, $attribute, $value)
	{
		$methods = get_class_methods($object);
		
		$method = 'set' . ucfirst($attribute);
			        
		if (in_array($method, $methods)) {
			$object->$method($value);
		} else {
			$message = sprintf('Method "%s" not defined in %s', $method, get_class($object));
			throw new Zf_Model_DataMapperException($message);
		}
	}
	
	/**
	 * Get an object within another object or create a new object.
	 *
	 * @param object $object
	 * @param array $property
	 * @throws Zf_Model_DataMapperException
	 */
	private function __getObject($object, array $property)
	{
		$methods = get_class_methods($object);
		
		$method = 'get' . ucfirst($property['parent']);
			        
		if (in_array($method, $methods)) {
			$value = $object->$method();
			
			if (is_null($value)) {
				return new $property['class'];
			} else {
				return $value;
			}
		} else {
			$message = sprintf('Method "%s" not defined in %s', $method, get_class($object));
			throw new Zf_Model_DataMapperException($message);
		}
	}
	
	/**
	 * Recursive method that run through a property and set their values in agreement
	 * with its properties.
	 *
	 * @param object $entity
	 * @param array|string $property
	 * @param mixed $value
	 */
	private function __assignValue($entity, $property, $value)
	{
		if (is_array($property)) {
			$object = $this->__getObject($entity, $property);
	            	
	    	$this->__assignValue($object, $property['child'], $value);
	    	
	    	$this->__setValue($entity, $property['parent'], $object);
	    	
	    	return;
	    } else {
	    	$this->__setValue($entity, $property, $value);
	    	return;
	    }
	}

    /**
     * Assign property values.
     *
     * @param Zf_Model_Entity $entity
     * @param array $element
     * @return void
     * @throws Zf_Model_DataMapperException
     */
    public function assign(Zf_Model_Entity $entity, array $element)
    {
    	$map = $this->getMap();
    	
    	foreach ($element as $key => $value) {
            if (!array_key_exists($key, $map)) {
                throw new Zf_Model_DataMapperException(sprintf('No such field "%s"', $key));
            }
            
            $property = $map[$key];
            
            $this->__assignValue($entity, $property, $value);
        }
        
        return $entity;
    }
    
    /**
     * Walk through the object using the mapping reference until get
     * its data information.
     * 
     * @param object $entity
     * @param string|array $property
     * @throws Zf_Model_DataMapperException
     */
    private function __fetchValue($entity, $property)
    {
    	if (is_null($entity)) {
    		return null;
    	}
    	
    	$methods = get_class_methods($entity);
    		
    	if (is_array($property)) {
    		$method = 'get' . ucfirst($property['parent']);
    		
    		if (in_array($method, $methods)) {
				$object = $entity->$method();
				$value = $this->__fetchValue($object, $property['child']);
			} else {
				$message = sprintf('Method "%s" not defined in %s', $method, get_class($entity));
				throw new Zf_Model_DataMapperException($message);
			}
    	} else {
    		$method = 'get' . ucfirst($property);
    		
    		if (in_array($method, $methods)) {
    			$value = $entity->$method();
    		
    			return $value;
    		} else {
				$message = sprintf('Method "%s" not defined in %s', $method, get_class($entity));
				throw new Zf_Model_DataMapperException($message);
			}
    	}
    	
    	return $value;
    }

    /**
     * Map fields to properties.
     *
     * @param Zf_Model_Entity $entity
     * @return array
     */
    public function map(Zf_Model_Entity $entity)
    {
    	$methods = get_class_methods($entity);
		
        $array = array();
        
        foreach ($this->getMap() as $field => $property) {
        	$array[$field] = $this->__fetchValue($entity, $property);
        }
        return $array;
    }
        
    /**
     * Return a field value based on the given property
     * 
     * @param string $property
     * @return string|null
     */
    public function getField($property)
    {
    	foreach($this->map as $index => $value) {
    		if (is_array($value)) {
    			$value = $value['parent'];
    		}
    		if (strcmp($value, $property) == 0) {
    			return $index;
    		}
    	}
    	
    	return null;
    }
    
	/**
     * Return a property value based on the given field
     * 
     * @param string $property
     * @return string|null
     */
    public function getProperty($field)
    {
    	if (isset($this->map[$field])) {
    		return $this->map[$field];
    	} else {
    		return null;
    	}
    }
}