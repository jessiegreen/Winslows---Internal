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
class Form_Codebuilder_ValueOption extends Zend_Form{
    private $_valueoption;
    
    public function __construct($options = null, \Entities\CbValueOption $valueoption = null) {
	$this->_valueoption = $valueoption;
	parent::__construct($options);
    }
    
    public function init($options = array()){
	if($this->_valueoption !== null && $this->_valueoption->getId() > 0){
	    $id = $this->addElement('hidden', 'id', array(
		'required'  => true,
		'belongsTo' => 'valueoption',
		'value'	    => $this->_valueoption ? $this->_valueoption->getId() : ""
	    ));
	}
	
	$this->addElement('text', 'name', array(
            'required'	    => true,
            'label'	    => 'Name:',
	    'belongsTo'	    => 'valueoption',
	    'size'	    => '80',
	    'value'	    => $this->_valueoption ? $this->_valueoption->getName() : ""
        ));
	
	$this->addElement('text', 'index', array(
            'required'	    => true,
            'label'	    => 'Index:',
	    'belongsTo'	    => 'valueoption',
	    'value'	    => $this->_valueoption ? $this->_valueoption->getIndex() : ""
        ));
	
	$this->addElement('text', 'code', array(
            'required'	    => true,
            'label'	    => 'Code:',
	    'belongsTo'	    => 'valueoption',
	    'value'	    => $this->_valueoption ? $this->_valueoption->getCode() : ""
        ));
	
	$this->addElement('textarea', 'description', array(
            'label'	    => 'Description:',
	    'belongsTo'	    => 'valueoption',
	    'style'	    => 'width:500px;height:150px;',
	    'value'	    => $this->_valueoption ? $this->_valueoption->getDescription() : ""
        ));

        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));

    }
}