<?php
namespace Forms\Company\Lead\Quote\AddProduct2;
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
class Subform extends \Zend_Form_SubForm
{    
    public function init() 
    {
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