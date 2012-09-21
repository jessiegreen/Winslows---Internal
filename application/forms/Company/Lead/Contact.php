<?php
namespace Forms\Company\Lead;
use Entities\Company\Lead\Contact as Contact;
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
class Contact extends \Zend_Form
{
    private $_Contact;
    private $_Lead;
    
    public function __construct(\Entities\Company\Lead $Lead, $options = null, Contact $Contact = null)
    {
	$this->_Contact	    = $Contact;
	$this->_Lead	    = $Lead;
	parent::__construct($options);
    }
  
    public function init($options = array())
    {
	$form = new Contact\Subform($this->_Lead, $options, $this->_Contact);
	
	$this->addSubForm($form, "company_lead_contact");

        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}

?>
