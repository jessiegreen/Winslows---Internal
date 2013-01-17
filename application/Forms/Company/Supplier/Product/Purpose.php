<?php
namespace Forms\Company\Supplier\Product;
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
class Purpose extends \Dataservice_Form
{    
    private $_Purpose;
    
    public function __construct(\Entities\Company\Supplier\Product\Purpose $Purpose = null, $options = null)
    {
	$this->_Purpose = $Purpose;
	
	parent::__construct($options);
    }
    
    public function init($options = array())
    {	
        $form = new Purpose\Subform($this->_Purpose, $options);
	
	$this->addSubForm($form, "company_supplier_product_purpose");
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}
