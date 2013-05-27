<?php

/**
 * Description of PDValidatorFactory
 *
 * @author BaoTam Vo
 */
class PDValidatorFactory extends CApplicationComponent {
    
    public $validatorBuilder = 'CValidator';
    
    /**
     * create the validators for the specified model
     * @param mixed $rule
     * @param mixed $model add this if it's an inline validation rule
     * @return \CValidator 
     */
    public function createValidator($rule, $model = null) {
        list($validatorName, $validatedAttributes, $params) = $this->parseValidatorDefinition($rule);
        $validatorBuilder = $this->validatorBuilder;
        return $validatorBuilder::createValidator($validatorName,$model,$validatedAttributes,$params);
    }
    
    /**
     * 
     * @param mixed $rule 
     * @return array the parsed rules the elements following the order:
     * <ol>
     *  <li>[1] validator name </li>
     *  <li>[2] validated attribute string of comma separated names or an array</li>
     *  <li>[3] validator params </li>
     * <ul>
     * 
     */
    protected function parseValidatorDefinition($rule) {
        if(isset($rule[0],$rule[1]))
            return array($rule[1],$rule[0],array_slice($rule, 2));
        else
            throw new PDInvalidValidationRuleException(
                'Invalid validation rule. The rule must specify attributes to be validated and the validator name. Recieved:'."\n".
                print_r($rule)
            );
    }
}

class PDInvalidValidationRuleException extends PDException {
    
}
?>
