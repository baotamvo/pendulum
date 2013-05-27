<?php

/**
 * Description of PDService
 *
 * @author BaoTam Vo
 */
abstract class PDBaseService extends CModel implements PDITransaction {
    
    protected static $_attributeNames = array();
    private $_results = array();
    
    public function attributeNames() {
        // set up attribute names with all the public attributes
        if(!isset(self::$_attributeNames[get_class($this)])) {
            $thisClass = new ReflectionClass(get_class($this));
            $attrNames = array();
            foreach($thisClass->getProperties() as $property)
            {
                $propertyName = $property->getName();
                if($property->isPublic() && !$property->isStatic())
                    $attrNames[] = $propertyName;
            }
            self::$_attributeNames[get_class($this)] = $attrNames;
        }
        
        return self::$_attributeNames[get_class($this)];
    }
    
    
    # =SERVICE-SPECIFIC OPERATIONS= #
    /**
     * setup neccesary environment for the main process 
     * @return boolean successful? run() will stop and return false
     * if this is not successful
     */
    protected function begin() {
        return $this->validate();
    }
    
    
    /**
     * clean up the environment after running the process
     * @return boolean successful? run() will stop and return false
     * if this is not successful
     */
    protected function end() {
        return true;
    }
    
    /**
     * This is the main process
     * 
     * @return boolean successful? run() will stop and return false
     * if this is not successful
     */
    protected function process() {
        return true;
    }
    
    
    public function run() {
        return
            $this->begin() &&
            $this->process() &&
            $this->end() &&
            !$this->hasErrors();
    }
    
   
    
	/**
	 * Returns a value indicating whether there is any validation result.
	 * @param string $key key name. Use null to check all keys.
	 * @return boolean whether there is any result.
	 */
	public function hasResults($key=null)
	{
		if($key===null)
			return $this->_results!==array();
		else
			return isset($this->_results[$key]);
	}

	/**
	 * Returns the results for all key or a single key.
	 * @param string $key key name. Use null to retrieve results for all keys.
	 * @return array results for all keys or the specified key. Empty array is returned if no result.
	 */
	public function getResults($key=null)
	{
		if($key===null)
			return $this->_results;
		else
			return isset($this->_results[$key]) ? $this->_results[$key] : array();
	}

	/**
	 * Returns the first result of the specified key.
	 * @param string $key key name.
	 * @return string the result message. Null is returned if no result.
	 */
	public function getResult($key)
	{
		return isset($this->_results[$key]) ? ($this->_results[$key]) : null;
	}

	/**
	 * Adds a new result to the specified key.
	 * @param string $key key name
	 * @param string $result new result message
	 */
	public function addResult($key,$result)
	{
		$this->_results[$key]=$result;
	}


	/**
	 * Adds a list of results.
	 * @param array $results a list of results. The array keys must be key names.
	 * The array values should be result messages. If an key has multiple results,
	 * these results must be given in terms of an array.
	 * You may use the result of {@link getResults} as the value for this parameter.
	 */
	public function addResults($results)
	{
		foreach($results as $key=>$result)
		{
			if(is_array($result))
			{
				foreach($result as $e)
					$this->addResult($key, $e);
			}
			else
				$this->addResult($key, $result);
		}
	}

	/**
	 * Removes results for all keys or a single key.
	 * @param string $key key name. Use null to remove results for all key.
	 */
	public function clearResults($key=null)
	{
		if($key===null)
			$this->_results=array();
		else
			unset($this->_results[$key]);
	}

    public function beginTransaction() {
        return app()->load('service/models')->get('transaction',array('service'=>$this));
    }

}


/**
 * Description of PDServiceException
 *
 * @author BaoTam Vo
 */
class PDServiceException extends PDException {
    
}
?>
