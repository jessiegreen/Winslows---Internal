<?php
namespace Forms\Address;
use Entities\Address\AddressAbstract as AddressAbstract;
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
class Subform extends \Zend_Form_SubForm
{
    private $_AddressAbstract;
    
    public function __construct($options = null, AddressAbstract $AddressAbstract = null) 
    {
	$this->_AddressAbstract	    = $AddressAbstract;
	
	parent::__construct($options);
    }
    
    public function init()
    {	
	$this->addElement('text', 'name', array(
            'required'	    => true,
            'label'	    => 'Address Name:',
	    'belongsTo'	    => "address",
	    'description'   => '(Ex. Home)',
	    'value'	    => $this->_AddressAbstract ? $this->_AddressAbstract->getName() : ""
        ));
	
        $this->addElement('text', 'address_1', array(
            'required'	    => true,
            'label'	    => 'Address Line 1:',
	    'belongsTo'	    => $this->_belongs_to,
	    'value'	    => $this->_AddressAbstract ? $this->_AddressAbstract->getAddress1() : ""
        ));
	
	$this->addElement('text', 'address_2', array(
            'required'	    => false,
            'label'	    => 'Address Line 2:',
	    'belongsTo'	    => $this->_belongs_to,
	    'value'	    => $this->_AddressAbstract ? $this->_AddressAbstract->getAddress2() : ""
        ));
	
	$this->addElement('text', 'county', array(
            'required'	    => false,
            'label'	    => 'County:',
	    'belongsTo'	    => $this->_belongs_to,
	    'value'	    => $this->_AddressAbstract ? $this->_AddressAbstract->getCounty() : ""
        ));

        $this->addElement('text', 'city', array(
            'required'	    => true,
            'label'	    => 'City:',
	    'belongsTo'	    => $this->_belongs_to,
	    'value'	    => $this->_AddressAbstract ? $this->_AddressAbstract->getCity() : ""
        ));
	
	$this->addElement('text', 'state', array(
            'required'	    => true,
            'label'	    => 'State:',
	    'size'	    => '2',
	    'belongsTo'	    => $this->_belongs_to,
	    'value'	    => $this->_AddressAbstract ? $this->_AddressAbstract->getState() : ""
        ));
	
	$this->addElement(new \Dataservice_Form_Element_StateSelect("state", array(
            'required'	    => true,
            'label'	    => 'State:',
	    'belongsTo'	    => $this->_belongs_to,
	    'value'	    => $this->_AddressAbstract ? $this->_AddressAbstract->getState() : ""
        )));
	
	$this->addElement('text', 'zip_1', array(
            'required'	    => true,
            'label'	    => 'Zip:',
	    'size'	    => '5',
	    'belongsTo'	    => $this->_belongs_to,
	    'value'	    => $this->_AddressAbstract ? $this->_AddressAbstract->getZip1() : ""
        ));
	
	$this->addElement('text', 'zip_2', array(
            'required'	    => false,
            'label'	    => 'Zip Extension:',
	    'size'	    => '5',
	    'belongsTo'	    => $this->_belongs_to,
	    'value'	    => $this->_AddressAbstract ? $this->_AddressAbstract->getZip2() : ""
        ));
	
	if(
	    $this->_AddressAbstract && 
	    ($this->_AddressAbstract->getLatitude() || $this->_AddressAbstract->getLongitude())
	)
	{
	    $this->addElement('radio', 'reset_latlong', array(
		'required'	=> true,
		'label'		=> 'Reset Lat Long?:',
		'multioptions'	=> array("no", "yes"),
		'belongsTo'	=> $this->_belongs_to,
		'value'		=> 0
	    ));
	}
    }
}