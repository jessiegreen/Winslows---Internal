<?php
namespace Form\Person\EmailAddress;
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
class Subform extends Form\EmailAddress\Subform
{
    private $_PersonEmailAddress;
    
    public function __construct($options = null, Entities\Person\EmailAddress $PersonEmailAddress = null)
    {
	$this->_PersonEmailAddress = $PersonEmailAddress;
	
	parent::__construct($options, $this->_PersonEmailAddress);
    }
}

?>
