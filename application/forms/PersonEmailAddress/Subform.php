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
class Form_PersonEmailAddress_Subform extends Form_EmailAddress_Subform
{
    private $_PersonEmailAddress;
    
    public function __construct($options = null, Entities\PersonEmailAddress $PersonEmailAddress = null)
    {
	$this->_PersonEmailAddress = $PersonEmailAddress;
	
	parent::__construct($options, $this->_PersonEmailAddress);
    }
}

?>
