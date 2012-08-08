<?php
namespace Forms\Company\Supplier;
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
class AddCompany extends \Zend_Form
{
    
    public function init($options = array())
    {	
        $form = new AddCompany\Subform($options);
	
	$this->addSubForm($form, "company_supplier_addcompany");
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}

?>
