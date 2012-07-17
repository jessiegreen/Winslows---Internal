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
class Form_Webaccount_Webaccount extends Zend_Form{
    private $_WebAccount;
    private $_safe;
    
    public function __construct($options = null, Entities\Webaccount $WebAccount = null, $safe = true) {
	$this->_WebAccount  = $WebAccount;
	$this->_safe	    = $safe;
	parent::__construct($options);
    }
    
    public function init($options = array()){
	if($this->_safe){
	    $this->addElement('text', 'username', array(
		'required'	    => false,
		'disable'	    => true,
		'label'		    => 'Username:',
		'belongsTo'	    => 'webaccount',
		'value'		    => $this->_WebAccount ? $this->_WebAccount->getUsername() : ""
	    ));

	    $this->addElement('text', 'password', array(
		'disable'	    => true,
		'required'	    => false,
		'label'		    => 'Password:',
		'belongsTo'	    => 'webaccount',
		'value'		    => "*******"
	    ));
	}
	else{
	    $this->addElement('text', 'username', array(
		'required'	    => true,
		'label'		    => 'Username:',
		'belongsTo'	    => 'webaccount',
		'value'		    => $this->_WebAccount ? $this->_WebAccount->getUsername() : ""
	    ));

	    $this->addElement('password', 'password', array(
		'required'	    => true,
		'label'		    => 'Password:',
		'belongsTo'	    => 'webaccount'
	    ));
	}

        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));

    }
}

?>
