<?php

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
class Form_Address_Subform extends Zend_Form_SubForm
{
    private $_Address;
    
    public function __construct($options = null, Entities\Address $Address = null) {
	$this->_Address	    = $Address;
	parent::__construct($options);
    }
    
    public function init(){	
	$this->addElement('text', 'name', array(
            'required'	    => true,
            'label'	    => 'Address Name:',
	    'belongsTo'	    => "address",
	    'description'   => '(Ex. Home)',
	    'value'	    => $this->_Address ? $this->_Address->getName() : ""
        ));
	
        $this->addElement('text', 'address_1', array(
            'required'	    => true,
            'label'	    => 'Address Line 1:',
	    'belongsTo'	    => $this->_belongs_to,
	    'value'	    => $this->_Address ? $this->_Address->getAddress1() : ""
        ));
	
	$this->addElement('text', 'address_2', array(
            'required'	    => false,
            'label'	    => 'Address Line 2:',
	    'belongsTo'	    => $this->_belongs_to,
	    'value'	    => $this->_Address ? $this->_Address->getAddress2() : ""
        ));
	
	$this->addElement('text', 'county', array(
            'required'	    => false,
            'label'	    => 'County:',
	    'belongsTo'	    => $this->_belongs_to,
	    'value'	    => $this->_Address ? $this->_Address->getCounty() : ""
        ));

        $this->addElement('text', 'city', array(
            'required'	    => true,
            'label'	    => 'City:',
	    'belongsTo'	    => $this->_belongs_to,
	    'value'	    => $this->_Address ? $this->_Address->getCity() : ""
        ));
	
	$this->addElement('text', 'state', array(
            'required'	    => true,
            'label'	    => 'State:',
	    'size'	    => '2',
	    'belongsTo'	    => $this->_belongs_to,
	    'value'	    => $this->_Address ? $this->_Address->getState() : ""
        ));
	
	$this->addElement('text', 'zip_1', array(
            'required'	    => true,
            'label'	    => 'Zip:',
	    'size'	    => '5',
	    'belongsTo'	    => $this->_belongs_to,
	    'value'	    => $this->_Address ? $this->_Address->getZip1() : ""
        ));
	
	$this->addElement('text', 'zip_2', array(
            'required'	    => false,
            'label'	    => 'Zip Extension:',
	    'size'	    => '5',
	    'belongsTo'	    => $this->_belongs_to,
	    'value'	    => $this->_Address ? $this->_Address->getZip2() : ""
        ));
    }
}

?>
