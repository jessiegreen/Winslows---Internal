<?php
namespace Forms\Person;
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
class PhoneNumber extends \Zend_Form
{    
    private $_PersonPhoneNumber;
    
    public function __construct($options = null, Entities\Person\PhoneNumber $PersonPhoneNumber = null)
    {
	$this->_PersonPhoneNumber = $PersonPhoneNumber;
	parent::__construct($options);
    }
    
    public function init($options = array())
    {
	$form = new PhoneNumber\Subform($options, $this->_PersonPhoneNumber);
	
	$this->addSubForm($form, "person_phonenumber");
	
	$this->addElement('submit', 'submit', array(
            'ignore'	    => true,
        ));
    }
}

?>
