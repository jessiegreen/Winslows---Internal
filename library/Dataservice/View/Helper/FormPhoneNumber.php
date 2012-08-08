<?php
class Dataservice_View_Helper_FormPhoneNumber extends Zend_View_Helper_FormElement
{
    public function formPhoneNumber ($name, $value = null, $attribs = null)
    {
        // separate value into area, prefix and line.
        $area = '';
        $prefix = '';
        $line = '';
        if (is_array($value)) {
            $area = $value['area'];
            $prefix = $value['prefix'];
            $line = $value['line'];
        } elseif ($value) {            
            list($area, $prefix, $line) = explode('-', $value);
        }
 
        // build select options
        $areaAttribs = isset($attribs['areaAttribs']) ? $attribs['areaAttribs'] : array();
        $prefixAttribs = isset($attribs['prefixAttribs']) ? $attribs['prefixAttribs'] : array();
        $lineAttribs = isset($attribs['lineAttribs']) ? $attribs['lineAttribs'] : array();
       
        // Set length of fields.
        $areaAttribs['maxlength']   = 3;
	$areaAttribs['size']	    = "3";
        $prefixAttribs['maxlength'] = 3;
	$prefixAttribs['size']	    = "3";
        $lineAttribs['maxlength']   = 4;
	$lineAttribs['size']	    = "4";
 
        // return the 3 text boxes separated by -
        return            
            $this->view->formText(
                $name . '[area]',
                $area,
                $areaAttribs) . '-' .
            $this->view->formText(
                $name . '[prefix]',
                $prefix,
                $prefixAttribs) . '-' .
            $this->view->formText(
                $name . '[line]',
                $line,
                $lineAttribs                
            );
    }
}
