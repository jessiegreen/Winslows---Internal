<?php
namespace Forms\Company\Supplier\Product;
use Entities\Company\Supplier\Product\ProductAbstract as ProductAbstract;
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
    private $_ProductAbstract;
    
    public function __construct($options = null, ProductAbstract $Product = null)
    {
	$this->_ProductAbstract = $Product;
	parent::__construct($options);
    }
    
    public function init()
    {	
	$this->addElement(new Dataservice_Form_Element_SupplierSelect("supplier_id", array(
            'required'	    => true,
            'label'	    => 'Supplier:',
	    'belongsTo'	    => 'product',
	    'value'	    => $this->_ProductAbstract && $this->_ProductAbstract->getSupplier() ? 
				$this->_ProductAbstract->getSupplier()->getId() : 
				""
        )));
	
	$this->addElement('text', 'name', array(
            'required'	    => true,
            'label'	    => 'Name:',
	    'belongsTo'	    => 'product',
	    'value'	    => $this->_ProductAbstract ? $this->_ProductAbstract->getName() : ""
        ));
	
	$this->addElement('text', 'part_number', array(
            'required'	    => true,
            'label'	    => 'Part #:',
	    'belongsTo'	    => 'product',
	    'value'	    => $this->_ProductAbstract ? $this->_ProductAbstract->getPartNumber() : ""
        ));
	
	$this->addElement('textarea', 'description', array(
            'required'	    => false,
            'label'	    => 'Description:',
	    'belongsTo'	    => 'product',
	    'rows'	    => '10',
	    'cols'	    => '35',
	    'value'	    => $this->_ProductAbstract ? $this->_ProductAbstract->getDescription() : ""
        ));
    }
}

?>
