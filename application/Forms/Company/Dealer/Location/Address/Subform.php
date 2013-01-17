<?php
namespace Forms\Company\Dealer\Location\Address;
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
class Subform extends \Forms\Address\Subform
{    
    private $_Address;
    
    public function __construct($options = null, \Entities\Location\Address $Address = null)
    {
	$this->_Address = $Address;
	
	parent::__construct($options, $this->_Address);
    }
    
    public function init($options = array())
    {
	$this->addElement(new \Dataservice_Form_Element_Company_Dealer_LocationSelect("location_id", array(
            'required'	    => true,
            'label'	    => 'Location:',
	    'belongsTo'	    => 'company_dealer_location_address',
	    'value'	    => $this->_Address && $this->_Address->getLocation() ? 
				$this->_Address->getLocation()->getId() : 
				""
        )));
	
	parent::init($options);
    }
}