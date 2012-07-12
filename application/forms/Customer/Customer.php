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
class Form_Customer_Customer extends Form_Person_Person
{    
    private $_Customer;
    
    public function __construct($options = null, Entities\Customer $Customer = null) {
	$this->_Customer = $Customer;
	parent::__construct($options, $this->_Customer);
    }
    
    public function init($options = array())
    {
	if($this->_Customer){
	    $this->addElement('hidden', 'id', array(
		'required'  => true,
		'belongsTo' => 'customer',
		'value'	    => $this->_Customer ? $this->_Customer->getId() : ""
	    ));
	}
	
        $this->addElement('text', 'company', array(
            'required'	    => false,
            'label'	    => 'Company:',
	    'belongsTo'	    => 'customer',
	    'value'	    => $this->_Customer ? $this->_Customer->getCompany() : ""
        ));
	parent::init($options);
    }
}

?>
