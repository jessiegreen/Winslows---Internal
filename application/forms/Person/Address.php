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
class Address extends \Zend_Form
{    
    private $_PersonAddress;
    
    public function __construct($options = null, Entities\Person\Address $PersonAddress = null)
    {
	$this->_PersonAddress = $PersonAddress;
	parent::__construct($options);
    }
    
    public function init($options = array())
    {
	$form = new Address\Subform($options, $this->_PersonAddress);
	
	$this->addSubForm($form, "person_address");
	
	$this->addElement('submit', 'submit', array(
            'ignore'	    => true,
        ));
    }
}

?>
