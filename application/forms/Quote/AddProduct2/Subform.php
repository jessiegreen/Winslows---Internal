<?php

/**
 * Name:
 * Location:
 *
 * Description for class (if any)...
 *
 * @author     Jessie Green <jessie.winslows@gmail.com>
 * @copyright  2012 Winslows inc.
 * @version    Release: @package_version@
 */
class Form_Quote_AddProduct2_Subform extends Zend_Form_SubForm
{    
    public function init() {
	$this->addElement("radio", "method",
		array(
		    "required"	    => true,
		    "Label"	    => "Method",
		    "multioptions"  => array("manual" => "Manual", "builder" => "Builder"),
		    "value"	    => "manual"
		)
	);
	
	parent::init();
    }
}

?>
