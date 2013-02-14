<?php
namespace Forms\Company;

class Catalog extends \Dataservice_Form
{    
    private $_Catalog;
    
    public function __construct(\Entities\Company\Catalog $Catalog, $options = null)
    {
	$this->_Catalog = $Catalog;
	
	parent::__construct($options, $this->_Catalog);
    }
    
    public function init($options = array())
    {	
        $form = new Catalog\Subform($this->_Catalog, $options);
	
	$this->addSubForm($form, "company_catalog");
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}