<?php
namespace Forms\Company\Supplier\Product\Configurable\ManageOptions;

use Entities\Company\Supplier\Product\Configurable as Configurable;

class Subform extends \Zend_Form_SubForm
{
    private $_Configurable;
    
    public function __construct(Configurable $Configurable, $options = null)
    {
	$this->_Configurable = $Configurable;
	
	parent::__construct($options);
    }
    
    public function init()
    {	
	$values = array();
	
	if($this->_Configurable)
	{
	    foreach($this->_Configurable->getOptions() as $Option)
	    {
		$values[] = $Option->getId();
	    }
	}
	
	$this->addElement(new \Dataservice_Form_Element_OptionMultiCheckbox("configurable_manageoptions", array(
            'required'	    => false,
            'label'	    => 'Option Groups:',
	    'belongsTo'	    => 'configurable_manageoptions',
	    'value'	    => $values
        )));
    }
}