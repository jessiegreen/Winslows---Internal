<?php
namespace Forms\Company\Supplier\Product\ManageDeliveryTypes;

use Entities\Company\Supplier\Product\ProductAbstract as Product;
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
    private $_Product;
    
    public function __construct(Product $Product, $options = null)
    {
	$this->_Product = $Product;
	
	parent::__construct($options);
    }
    
    public function init()
    {	
	$values = array();
	
	if($this->_Product)
	{
	    foreach($this->_Product->getDeliveryTypes() as $DeliveryType)
	    {
		$values[] = $DeliveryType->getId();
	    }
	}
	
	$this->addElement(new \Dataservice_Form_Element_Company_Supplier_Product_DeliveryTypeMultiCheckbox("product_managedeliverytypes", array(
            'required'	    => false,
            'label'	    => 'DeliveryTypes:',
	    'belongsTo'	    => 'product_managedeliverytypes',
	    'value'	    => $values
        )));
    }
}