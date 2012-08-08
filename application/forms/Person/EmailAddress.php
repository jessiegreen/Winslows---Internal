<?php
namespace Forms\Person;
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
class EmailAddress extends \Zend_Form
{    
    private $_PersonEmailAddress;
    
    public function __construct($options = null, Entities\Person\EmailAddress $PersonEmailAddress = null)
    {
	$this->_PersonEmailAddress = $PersonEmailAddress;
	parent::__construct($options);
    }
    
    public function init($options = array())
    {
	$form = new EmailAddress\Subform($options, $this->_PersonEmailAddress);
	
	$this->addSubForm($form, "person_emailaddress");
	
	$this->addElement('submit', 'submit', array(
            'ignore'	    => true,
        ));
    }
}

?>
