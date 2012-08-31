<?php
namespace Forms\RtoProvider\ManageProducts;
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
class Subform extends \Zend_Form_SubForm
{
    private $_RtoProvider;
    
    public function __construct(\Entities\Company\RtoProvider $RtoProvider, $options = null)
    {
	$this->_RtoProvider = $RtoProvider;
	parent::__construct($options);
    }
    
    public function init()
    {	
	$values = array();
	
	if($this->_RtoProvider)
	{
	    foreach($this->_RtoProvider->getProducts() as $Product)
	    {
		$values[] = $Product->getId();
	    }
	}
	
	$this->addElement(new \Dataservice_Form_Element_RtoProvider_Products_MultiCheckbox("products_checks", array(
            'required'	    => false,
            'label'	    => 'Products:',
	    'belongsTo'	    => 'rto_provider_manageproducts',
	    'value'	    => $values
        )));
    }
}

?>
