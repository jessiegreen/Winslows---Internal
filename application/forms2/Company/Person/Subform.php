<?php
namespace Forms\Company\Person;

class Subform extends \Zend_Form_SubForm
{
    private $_Person;
    
    public function __construct($options = null, \Entities\Company\Person\PersonAbstract $Person = null)
    {
	$this->_Person = $Person;
	
	parent::__construct($options);
    }
  
    public function init($options = array())
    {
        $this->addElement('text', 'first_name', array(
            'required'	    => true,
            'label'	    => 'First Name:',
	    'belongsTo'	    => 'person',
	    'value'	    => $this->_Person ? $this->_Person->getFirstName() : ""
        ));

        $this->addElement('text', 'middle_name', array(
            'required'	    => false,
            'label'	    => 'Middle Name:',
	    'belongsTo'	    => 'person',
	    'value'	    => $this->_Person ? $this->_Person->getMiddleName() : ""
        ));
	
	$this->addElement('text', 'last_name', array(
            'required'	    => true,
            'label'	    => 'Last Name:',
	    'belongsTo'	    => 'person',
	    'value'	    => $this->_Person ? $this->_Person->getLastName() : ""
        ));
	
	$this->addElement('text', 'suffix', array(
            'required'	    => false,
            'label'	    => 'Suffix:',
	    'belongsTo'	    => 'person',
	    'value'	    => $this->_Person ? $this->_Person->getSuffix() : ""
        ));
    }
}