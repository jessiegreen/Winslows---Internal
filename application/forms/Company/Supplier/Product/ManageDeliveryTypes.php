<?php
namespace Forms\Company\Supplier\Product;
/**
 * Name:
 * Company:
 *
 * Description for class (if any)...
 *
 * @author     Jessie Green <jessie.winslows@gmail.com>
 * @copyright  2012 Winslows inc.
 * @version    Release: @package_version@
 */
class ManageDeliveryTypes extends \Dataservice_Form
{
    private $_Product;
    
    public function __construct(\Entities\Company\Supplier\Product\ProductAbstract $Product, $options = null)
    {
	$this->_Product = $Product;
	
	parent::__construct($options);
    }
    
    public function init($options = array())
    {	
        $form = new ManageDeliveryTypes\Subform($this->_Product, $options);
	
	$this->addSubForm($form, "company_supplier_product_managedeliverytypes");
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}