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
class Form_Codebuilder_Value extends Zend_Form{
    private $_value;
    
    public function __construct($options = null, \Entities\CbValue $value = null) {
	$this->_value = $value;
	parent::__construct($options);
    }
    
    public function init($options = array()){
	if($this->_value !== null && $this->_value->getId() > 0){
	    $id = $this->addElement('hidden', 'id', array(
		'required'  => true,
		'belongsTo' => 'value',
		'value'	    => $this->_value ? $this->_value->getId() : ""
	    ));
	}
	
	$this->addElement('text', 'name', array(
            'required'	    => true,
            'label'	    => 'Name:',
	    'belongsTo'	    => 'value',
	    'size'	    => '80',
	    'value'	    => $this->_value ? $this->_value->getName() : ""
        ));
	
	$this->addElement('text', 'length', array(
            'required'	    => true,
            'label'	    => 'Length:',
	    'belongsTo'	    => 'value',
	    'size'	    => '2',
	    'value'	    => $this->_value ? $this->_value->getLength() : ""
        ));
	
	$this->addElement('textarea', 'description', array(
            'required'	    => false,
            'label'	    => 'Description:',
	    'belongsTo'	    => 'value',
	    'style'	    => 'width:500px;height:150px;',
	    'value'	    => $this->_value ? $this->_value->getDescription() : ""
        ));

        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));

    }
}

?>
