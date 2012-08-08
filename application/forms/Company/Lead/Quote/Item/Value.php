<?php
namespace Forms\Company\Lead\Quote\Item;
use Entities\Company\Lead\Quote\Item\Value as Value;
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
class Form_Quote_ConfigurableProductOptionGroup extends Zend_Form
{
    private $_ConfigurableProductOptionGroup;
    
    public function __construct(\Entities\ConfigurableProductOptionGroup $ConfigurableProductOptionGroup, $options = null) {
	$this->_ConfigurableProductOptionGroup = $ConfigurableProductOptionGroup;
	parent::__construct($options);
    }
    
    public function init($options = array()){
	$form = new Form_Quote_ConfigurableProductOptionGroup_Subform($this->_ConfigurableProductOptionGroup, $options);
	
	$this->addSubForm($form, (string) $this->_ConfigurableProductOptionGroup->getId());
    }
}

?>
