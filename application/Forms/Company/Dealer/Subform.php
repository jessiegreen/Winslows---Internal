<?php
namespace Forms\Company\Dealer;

class Subform extends \Zend_Form_SubForm
{
    private $_Dealer;
    
    public function __construct(\Entities\Company\Dealer $Dealer, $options = null)
    {
	$this->_Dealer = $Dealer;
	
	parent::__construct($options);
    }
    
    public function init()
    {		
	$this->addElement(new \Dataservice_Form_Element_CompanySelect("company_id", array(
            'required'	    => true,
            'label'	    => 'Company:',
	    'value'	    => $this->_Dealer && $this->_Dealer->getCompany() ? $this->_Dealer->getCompany()->getId() : ""
        )));
	
	$this->addElement('text', 'name', array(
            'required'	    => true,
            'label'	    => 'Name:',
	    'value'	    => $this->_Dealer ? $this->_Dealer->getName() : ""
        ));
	
	$this->addElement('text', 'dba', array(
            'required'	    => true,
            'label'	    => 'DBA:',
	    'value'	    => $this->_Dealer ? $this->_Dealer->getDba() : ""
        ));
	
	$this->addElement('text', 'name_index', array(
            'required'	    => true,
            'label'	    => 'Name Index:',
	    'value'	    => $this->_Dealer ? $this->_Dealer->getNameIndex() : ""
        ));
	
	$this->addElement('textarea', 'description', array(
            'required'	    => false,
            'label'	    => 'Description:',
	    'rows'	    => '10',
	    'cols'	    => '35',
	    'value'	    => $this->_Dealer ? $this->_Dealer->getDescription() : ""
        ));
	
	$this->setElementsBelongTo("company_dealer");
    }
}