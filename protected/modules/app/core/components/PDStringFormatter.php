<?php
/**
 * Date: 3/30/13
 * Class: PDStringFormatter
 * Description:
 *
 */
class PDStringFormatter extends CApplicationComponent
{
    public function snakeCaseToWords($string) {
        $tokens = explode('_',$string);
        foreach($tokens as $idx=>$token) {
            $tokens[$idx] = ucfirst($token);
        }
        return implode(' ',$tokens);
    }
}
