<?php
namespace Forms\Company\Website;

class ManageCatalogs extends \Dataservice_Form
{
    private $_Website;
    
    public function __construct(\Entities\Company\Website $Website, $options = null)
    {
	$this->_Website = $Website;
	
	parent::__construct($options);
    }
    
    public function init($options = array())
    {	
        $form = new ManageCatalogs\Subform($this->_Website, $options);
	
	$this->addSubForm($form, "company_website_manage_catalogs");
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}