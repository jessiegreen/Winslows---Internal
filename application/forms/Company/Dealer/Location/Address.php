<?php
namespace Forms\Company\Dealer\Location;
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
class Address extends \Dataservice_Form
{    
    private $_Address;
    
    public function __construct($options = null, \Entities\Location\Address $Address = null)
    {
	$this->_Address = $Address;
	
	parent::__construct($options, $this->_Address);
    }
    
    public function init($options = array())
    {
	$form = new Address\Subform($options, $this->_Address);
	
	$this->addSubForm($form, "company_dealer_location_address");

        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}