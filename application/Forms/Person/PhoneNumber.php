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
class PhoneNumber extends \Dataservice_Form
{    
    private $_PhoneNumber;
    
    public function __construct($options = null, \Entities\Person\PhoneNumber $PhoneNumber = null)
    {
	$this->_PhoneNumber = $PhoneNumber;
	parent::__construct($options);
    }
    
    public function init($options = array())
    {
	$form = new PhoneNumber\Subform($options, $this->_PhoneNumber);
	
	$this->addSubForm($form, "person_phonenumber");
	
	$this->addElement('submit', 'submit', array(
            'ignore'	    => true,
        ));
    }
}

?>
