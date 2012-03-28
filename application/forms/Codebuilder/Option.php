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
class Form_Codebuilder_Option extends Zend_Form{
    private $_option;
    
    public function __construct($options = null, \Entities\CbOption $option = null) {
	$this->_option = $option;
	parent::__construct($options);
    }
    
    public function init($options = array()){
	if($this->_option !== null && $this->_option->getId() > 0){
	    $id = $this->addElement('hidden', 'id', array(
		'required'  => true,
		'belongsTo' => 'option',
		'value'	    => $this->_option ? $this->_option->getId() : ""
	    ));
	}
	
	$this->addElement('text', 'code', array(
            'required'	    => true,
            'label'	    => 'Code:',
	    'belongsTo'	    => 'option',
	    'size'	    => '2',
	    'value'	    => $this->_option ? $this->_option->getCode() : ""
        ));
	
	$this->addElement('text', 'name', array(
            'required'	    => true,
            'label'	    => 'Name:',
	    'belongsTo'	    => 'option',
	    'value'	    => $this->_option ? $this->_option->getName() : ""
        ));
	
	$this->addElement('textarea', 'description', array(
            'required'	    => false,
            'label'	    => 'Description:',
	    'belongsTo'	    => 'option',
	    'style'	    => 'width:200px;height:150px;',
	    'value'	    => $this->_option ? $this->_option->getDescription() : ""
        ));

        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));

    }
}

?>
