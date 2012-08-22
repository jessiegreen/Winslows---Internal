<?php
namespace Forms\Company\Website;
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
class Account extends \Zend_Form
{
    private $_Account;
    private $_safe;
    
    public function __construct($options = null, \Entities\Company\Website\Account $Account = null, $safe = true)
    {
	$this->_Account  = $Account;
	$this->_safe	    = $safe;
	parent::__construct($options);
    }
    
    public function init($options = array())
    {
	$form = new Account\SubForm($options, $this->_Account, $this->_safe);
	
	$this->addSubForm($form, "company_website_account");
	
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}

?>
