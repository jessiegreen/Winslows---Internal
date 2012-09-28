<?php
namespace Forms\Company\Lead;
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
class Contact extends \Dataservice_Form
{
    private $_Contact;
    
    public function __construct($options = null, \Entities\Company\Lead\Contact $Contact = null)
    {
	$this->_Contact	    = $Contact;
	
	parent::__construct($options);
    }
  
    public function init($options = array())
    {
	$form = new Contact\Subform($options, $this->_Contact);
	
	$this->addSubForm($form, "company_lead_contact");

        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}