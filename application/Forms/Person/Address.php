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
    private $_Address;
    
    public function __construct($options = null, \Entities\Person\Address $Address = null)
    {
	$this->_Address = $Address;
	
	parent::__construct($options);
    }
    
    public function init($options = array())
    {
	$form = new \Forms\Person\Address\Subform($options, $this->_Address);
	
	$this->addSubForm($form, "person_address");
	
	$this->addElement('submit', 'submit', array(
            'ignore'	    => true,
        ));
    }
}