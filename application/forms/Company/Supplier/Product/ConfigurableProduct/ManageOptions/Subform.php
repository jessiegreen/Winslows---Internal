<?php

/**
 * Name:
 * Product:
 *
 * Description for class (if any)...
 *
 * @author     Jessie Green <jessie.winslows@gmail.com>
 * @copyright  2012 Winslows inc.
 * @version    Release: @package_version@
 */
class Form_ConfigurableProduct_ManageOptions_Subform extends Zend_Form_SubForm
{
    private $_ConfigurableProduct;
    
    public function __construct(\Entities\ConfigurableProduct $ConfigurableProduct, $options = null)
    {
	$this->_ConfigurableProduct = $ConfigurableProduct;
	parent::__construct($options);
    }
    
    public function init()
    {	
	$values = array();
	if($this->_ConfigurableProduct){
	    foreach($this->_ConfigurableProduct->getConfigurableProductOptionGroups() as $ConfigurableProductOptionGroup){
		$values[] = $ConfigurableProductOptionGroup->getId();
	    }
	}
	
	$this->addElement(new Dataservice_Form_Element_ConfigurableProductOptionGroupMultiCheckbox("configurableproduct_manageoptions", array(
            'required'	    => false,
            'label'	    => 'Option Groups:',
	    'belongsTo'	    => 'configurableproduct_manageoptions',
	    'value'	    => $values
        )));
    }
}

?>
