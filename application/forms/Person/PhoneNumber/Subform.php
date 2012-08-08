<?php
namespace Forms\Person\PhoneNumber;
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
class Subform extends Forms\PhoneNumber\Subform
{
    private $_PersonPhoneNumber;
    
    public function __construct($options = null, Entities\Person\PhoneNumber $PersonPhoneNumber = null) {
	$this->_PersonPhoneNumber = $PersonPhoneNumber;
	parent::__construct($options, $this->_PersonPhoneNumber);
    }
}

?>
