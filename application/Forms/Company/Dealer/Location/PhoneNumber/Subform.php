<?php
namespace Forms\Company\Dealer\Location\PhoneNumber;
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
class Subform extends \Forms\Company\PhoneNumber\Subform
{
    private $_PhoneNumber;
    
    public function __construct($options = null, \Entities\Company\Location\PhoneNumber $PhoneNumber = null)
    {
	$this->_PhoneNumber = $PhoneNumber;
	
	parent::__construct($options, $this->_PhoneNumber);
    }
    
    public function init($options = array())
    {
	$this->addElement(new \Dataservice_Form_Element_Company_Dealer_LocationSelect("location_id", array(
            'required'	    => true,
            'label'	    => 'Location:',
	    'belongsTo'	    => 'company_dealer_location_phonenumber',
	    'value'	    => $this->_PhoneNumber && $this->_PhoneNumber->getLocation() ? 
				$this->_PhoneNumber->getLocation()->getId() : 
				""
        )));
	
	parent::init($options);
    }
}