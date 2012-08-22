<?php
namespace Forms\Company\Website\Account;
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
class Subform extends \Zend_Form_SubForm
{
    private $_Account;
    private $_safe;
    
    public function __construct($options = null, \Entities\Company\Website\Account $Account = null, $safe = true) {
	$this->_Account  = $Account;
	$this->_safe	    = $safe;
	parent::__construct($options);
    }
    
    public function init()
    {
	if($this->_safe)
	{
	    $this->addElement('text', 'username', array(
		'required'	    => true,
		'label'		    => 'Username:',
		'belongsTo'	    => 'company_website_account',
		'value'		    => $this->_Account ? $this->_Account->getUsername() : ""
	    ));
	}
	else{
	    $this->addElement('text', 'username', array(
		'required'	    => true,
		'label'		    => 'Username:',
		'belongsTo'	    => 'company_website_account',
		'value'		    => $this->_Account ? $this->_Account->getUsername() : ""
	    ));

	    $this->addElement('password', 'password', array(
		'required'	    => true,
		'label'		    => 'Password:',
		'belongsTo'	    => 'company_website_account'
	    ));
	}
    }
}