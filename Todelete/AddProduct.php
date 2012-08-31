<?php
namespace Forms\Company\Lead\Quote;
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
class AddProduct extends \Zend_Form
{
    public function init($options = array()){
	$form = new AddProduct\Subform($options);
	
	$this->addSubForm($form, "company_lead_quote_addproduct");

        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}

?>
