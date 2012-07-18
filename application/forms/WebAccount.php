<?php

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
class Form_Webaccount extends Zend_Form{
    private $_WebAccount;
    private $_safe;
    
    public function __construct($options = null, Entities\Webaccount $WebAccount = null, $safe = true) {
	$this->_WebAccount  = $WebAccount;
	$this->_safe	    = $safe;
	parent::__construct($options);
    }
    
    public function init($options = array()){
	$form = new Form_Webaccount_SubForm($options, $this->_WebAccount, $this->_safe);
	
	$this->addSubForm($form, "webaccount");
	
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}

?>
