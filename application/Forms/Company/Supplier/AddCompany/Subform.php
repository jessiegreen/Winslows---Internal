<?php
namespace Forms\Company\Supplier\AddCompany;

class Subform extends \Zend_Form_SubForm
{    
    public function init()
    {		
	$this->addElement(new \Dataservice_Form_Element_CompanySelect("company_id", array(
            'required'	    => true,
            'label'	    => 'Company:',
	    'belongsTo'	    => 'supplier_addcompany',
	    'value'	    => ""
        )));
    }
}