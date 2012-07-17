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
class Form_Location_Location extends Zend_Form{
    private $_location;
    
    public function __construct($options = null, \Entities\Location $Location = null) {
	$this->_location = $Location;
	parent::__construct($options);
    }
    
    public function init($options = array()){
	if($this->_location !== null && $this->_location->getId() > 0){
	    $this->addElement('hidden', 'id', array(
		'required'  => true,
		'belongsTo' => 'location',
		'value'	    => $this->_location ? $this->_location->getId() : ""
	    ));
	}
	
	if($this->_location){
	    $type_options   = $this->_location->getTypeOptions();
	}
	else{
	    $Location	    = new \Entities\Location;
	    $type_options   = $Location->getTypeOptions();
	}
	
	$this->addElement('text', 'name', array(
            'required'	    => false,
            'label'	    => 'Name:',
	    'belongsTo'	    => 'location',
	    'value'	    => $this->_location ? $this->_location->getName() : ""
        ));
	
	$this->addElement('text', 'phone', array(
            'required'	    => false,
            'label'	    => 'Phone:',
	    'belongsTo'	    => 'location',
	    'value'	    => $this->_location ? $this->_location->getPhone() : ""
        ));
	
	$this->addElement('select', 'type', array(
            'required'	    => true,
            'label'	    => 'Type:',
	    'multioptions'  => $type_options,
	    'belongsTo'	    => "location",
	    'value'	    => $this->_location ? $this->_location->getType() : ""
        ));

        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));

    }
}

?>
