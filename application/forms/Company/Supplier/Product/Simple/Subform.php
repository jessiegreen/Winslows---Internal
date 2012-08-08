<?php
namespace Forms\Company\Supplier\Product\Simple;
use Entities\Company\Supplier\Product\Simple as Simple;
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
class Subform extends \Form_Product_Subform
{    
    private $_Simple;
    
    public function __construct($options = null, Simple $Simple = null) {
	$this->_Simple = $Simple;
	parent::__construct($options, $this->_Simple);
    }
    
    public function init($options = array())
    {
	$this->addElement('text', 'price', array(
            'required'	    => true,
            'label'	    => 'Price:',
	    'belongsTo'	    => 'simpleproduct',
	    'value'	    => $this->_Simple ? $this->_Simple->getPrice() : ""
        ));
	
	parent::init($options);
    }
}

?>
