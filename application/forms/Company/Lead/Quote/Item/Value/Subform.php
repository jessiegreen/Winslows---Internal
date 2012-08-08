<?php
namespace Forms\Company\Lead\Quote\Item\Value;
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
class Subform extends \Zend_Form_SubForm
{    
    private $_ConfigurableProductOptionGroup;
    
    public function __construct(\Entities\ConfigurableProductOptionGroup $ConfigurableProductOptionGroup, $options = null) {
	$this->_ConfigurableProductOptionGroup = $ConfigurableProductOptionGroup;
	parent::__construct($options);
    }
    
    public function init() {
	$ids_array = array();
	foreach ($this->_ConfigurableProductOptionGroup->getConfigurableProductOptions() as $ConfigurableProductOption) {
	    $options = array("" => "Please Select...");
	    /* @var $ConfigurableProductOptionValue \Entities\ConfigurableProductOptionValue */
	    foreach ($ConfigurableProductOption->getConfigurableProductOptionValues() as $ConfigurableProductOptionValue) {
		$options[$ConfigurableProductOptionValue->getId()] = $ConfigurableProductOptionValue->getName();
	    }
	    $this->addElement(
		    "select", 
		    (string) $ConfigurableProductOption->getId(), 
		    array(
			"required"	=> $ConfigurableProductOption->isRequired(),
			"label"		=> $ConfigurableProductOption->getName(),
			"belongsTo"	=> $this->_ConfigurableProductOptionGroup->getId(),
			"multioptions"	=> $options
		    )
		);
	    $ids_array[] = $ConfigurableProductOption->getId();
	}
	
	$this->addDisplayGroup(
		$ids_array, 
		(string) $this->_ConfigurableProductOptionGroup->getId(), 
		array(
		    'legend'	=> $this->_ConfigurableProductOptionGroup->getName().
				    ($this->_ConfigurableProductOptionGroup->hasRequiredOption() ? 
					" *required" : ""),
		)
	);
	
	$displaygroup = $this->getDisplayGroup((string) $this->_ConfigurableProductOptionGroup->getId());
		$displaygroup->setDecorators(array(
                    'FormElements',
                    'Fieldset',
                    array('HtmlTag',array('tag'=>'div','style'=>'width:100%;'))
		));
	
	parent::init();
    }
}

?>
