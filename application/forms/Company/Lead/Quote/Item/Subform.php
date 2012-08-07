<?php

/**
 * Name:
 * QuoteProduct:
 *
 * Description for class (if any)...
 *
 * @author     Jessie Green <jessie.winslows@gmail.com>
 * @copyright  2012 Winslows inc.
 * @version    Release: @package_version@
 */
class Form_QuoteProduct_Subform extends Zend_Form_SubForm
{
    private $_QuoteProduct;
    
    public function __construct(Entities\QuoteProduct $QuoteProduct, $options = null)
    {
	$this->_QuoteProduct = $QuoteProduct;
	parent::__construct($options);
    }
    
    public function init()
    {	
	if($this->_QuoteProduct->getProduct()){
	    /* @var $ConfigurableProductOptionGroup \Entities\ConfigurableProductOptionGroup */
	    foreach ($this->_QuoteProduct->getProduct()->getConfigurableProductOptionGroups() as $ConfigurableProductOptionGroup) {
		$ids_array = array();
		/* @var $ConfigurableProductOption \Entities\ConfigurableProductOption */
		foreach ($ConfigurableProductOptionGroup->getConfigurableProductOptions() as $ConfigurableProductOption) {
		    $options = array("" => "Please Select...");
		    /* @var $ConfigurableProductOptionValue \Entities\ConfigurableProductOptionValue */
		    foreach ($ConfigurableProductOption->getConfigurableProductOptionValues() as $ConfigurableProductOptionValue) {
			$options[$ConfigurableProductOptionValue->getId()] = $ConfigurableProductOptionValue->getName();
		    }
		    $this->addElement(
			    "select", 
			    $ConfigurableProductOptionGroup->getIndex()."-".$ConfigurableProductOption->getIndex(), 
			    array(
				"required"	=> false,
				"label"		=> $ConfigurableProductOption->getName(),
				"belongsTo"	=> $ConfigurableProductOptionGroup->getIndex(),
				"multioptions"	=> $options
			    )
			);
		    $ids_array[] = $ConfigurableProductOptionGroup->getIndex()."-".$ConfigurableProductOption->getIndex();
		}
		$this->addDisplayGroup(
			$ids_array, 
			$ConfigurableProductOptionGroup->getIndex(), 
			array(
			    'legend'	=> $ConfigurableProductOptionGroup->getName(),
			)
		);
		$displaygroup = $this->getDisplayGroup($ConfigurableProductOptionGroup->getIndex());
		$displaygroup->setDecorators(array(
                    'FormElements',
                    'Fieldset',
                    array('HtmlTag',array('tag'=>'div','style'=>'width:30%;min-height:180px;float:left;'))
		));
	    }
	}
    }
}

?>
