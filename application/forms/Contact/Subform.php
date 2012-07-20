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
class Form_Contact_Subform extends Zend_Form_SubForm
{
    private $_Contact;
    
    public function __construct($options = null, Entities\Contact $Contact = null) {
	$this->_Contact	    = $Contact;
	parent::__construct($options);
    }
  
    public function init(){
	if($this->_Contact){
	    $type_options   = $this->_Contact->getTypeOptions();
	    $type_options   = $this->_Contact->getTypeOptions();
	    $result_options = $this->_Contact->getResultOptions();
	}
	else{
	    $Contact	    = new Entities\Contact();
	    $type_options   = $Contact->getTypeOptions();
	    $result_options = $Contact->getResultOptions();
	}
	
	$this->addElement('select', 'type', array(
            'required'	    => true,
            'label'	    => 'Type:',
	    'multioptions'  => $type_options,
	    'belongsTo'	    => "contact",
	    'value'	    => $this->_Contact ? $this->_Contact->getType() : ""
        ));
	
	$this->addElement('text', 'type_detail', array(
            'required'	    => true,
	    'label'	    => "Type Detail:",
	    'belongsTo'	    => "contact",
	    "description"   => "214-555-5555, example@gmail.com, or Will Point (Location name)",
	    'value'	    => $this->_Contact ? $this->_Contact->getTypeDetail() : ""
        ));
	
	$this->addElement('textarea', 'note', array(
            'required'	    => false,
	    'label'	    => "Note:",
	    'rows'	    => 10,
	    'belongsTo'	    => "contact",
	    'value'	    => $this->_Contact ? $this->_Contact->getNote() : ""
        ));
	
	$this->addElement('select', 'result', array(
            'required'	    => true,
            'label'	    => 'Result:',
	    'multioptions'  => $result_options,
	    'belongsTo'	    => "contact",
	    'value'	    => $this->_Contact ? $this->_Contact->getType() : ""
        ));
    }
}

?>
