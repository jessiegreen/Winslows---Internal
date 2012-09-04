<?php
namespace Forms\Company\Location;
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
    private $_PhoneNumber;
    
    public function __construct($options = null, \Entities\Company\Location\PhoneNumber $PhoneNumber = null)
    {
	$this->_PhoneNumber = $PhoneNumber;
	parent::__construct($options);
    }
    
    public function init($options = array())
    {
	$form = new PhoneNumber\Subform($options, $this->_PhoneNumber);
	
	$this->addSubForm($form, "company_location_phonenumber");
	
	$this->addElement('submit', 'submit', array(
            'ignore'	    => true,
        ));
    }
}

?>
