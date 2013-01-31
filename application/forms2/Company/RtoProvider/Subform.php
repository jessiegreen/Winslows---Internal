<?php
namespace Forms\Company\RtoProvider;

class Subform extends \Zend_Form_SubForm
{
    private $_RtoProvider;
    
    public function __construct($options = null, \Entities\Company\RtoProvider $RtoProvider = null)
    {
	$this->_RtoProvider = $RtoProvider;
	parent::__construct($options);
    }
    
    public function init()
    {		
	$this->addElement(new \Dataservice_Form_Element_CompanySelect("company_id", array(
            'required'	    => true,
            'label'	    => 'Company:',
	    'belongsTo'	    => 'company_rto_provider',
	    'value'	    => $this->_RtoProvider && $this->_RtoProvider->getCompany() ? $this->_RtoProvider->getCompany()->getId() : ""
        )));
	
	$this->addElement('text', 'name', array(
            'required'	    => true,
            'label'	    => 'Name:',
	    'belongsTo'	    => 'company_rto_provider',
	    'value'	    => $this->_RtoProvider ? $this->_RtoProvider->getName() : ""
        ));
	
	$this->addElement('text', 'dba', array(
            'required'	    => true,
            'label'	    => 'DBA:',
	    'belongsTo'	    => 'company_rto_provider',
	    'value'	    => $this->_RtoProvider ? $this->_RtoProvider->getDba() : ""
        ));
	
	$this->addElement('text', 'name_index', array(
            'required'	    => true,
            'label'	    => 'Name Index:',
	    'belongsTo'	    => 'company_rto_provider',
	    'value'	    => $this->_RtoProvider ? $this->_RtoProvider->getNameIndex() : ""
        ));
	
	$this->addElement('textarea', 'description', array(
            'required'	    => false,
            'label'	    => 'Description:',
	    'belongsTo'	    => 'company_rto_provider',
	    'rows'	    => '10',
	    'cols'	    => '35',
	    'value'	    => $this->_RtoProvider ? $this->_RtoProvider->getDescription() : ""
        ));
    }
}

?>
