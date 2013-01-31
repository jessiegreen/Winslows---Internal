<?php
namespace Forms\Company\Supplier;

class AddCompany extends \Zend_Form
{
    
    public function init($options = array())
    {	
        $form = new AddCompany\Subform($options);
	
	$this->addSubForm($form, "company_supplier_addcompany");
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}