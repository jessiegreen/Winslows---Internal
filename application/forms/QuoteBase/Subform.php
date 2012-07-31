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
class Form_QuoteBase_Subform extends Zend_Form_SubForm
{
    private $_QuoteBase;
    
    public function __construct($options = null, Entities\QuoteBase $QuoteBase = null) {
	$this->_QuoteBase	    = $QuoteBase;
	parent::__construct($options);
    }
}

?>
