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
class Form_Address_Address extends Zend_Form
{
    private $_Address;
    private $_belongs_to;
    
    public function __construct($options = null, Entities\Address $Address = null, $belongs_to = "address") {
	$this->_Address	    = $Address;
	$this->_belongs_to  = $belongs_to;
	parent::__construct($options);
    }
    
    public function init($options = array()){
	if($this->_Address){
	    $this->addElement('text', 'id', array(
		'label'	    => 'Address Id',
		'disabled'  => true,
		'required'  => true,
		'belongsTo' => $this->_belongs_to,
		'value'	    => $this->_Address ? $this->_Address->getId() : ""
	    ));
	}
	
	$this->addElement('text', 'name', array(
            'required'	    => true,
            'label'	    => 'Location Name:',
	    'belongsTo'	    => $this->_belongs_to,
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

        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));

    }
}

?>
