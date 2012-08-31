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
class AddProduct2 extends \Zend_Form
{
    public function init($options = array())
    {
	$form = new AddProduct2\Subform($options);
	
	$this->addSubForm($form, "company_lead_quote_addproduct2");

        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}

?>
