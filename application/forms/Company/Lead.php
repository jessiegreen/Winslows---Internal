<?php
namespace Form\Company;
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
class Lead extends \Zend_Form
{    
    private $_Lead;
    
    public function __construct($options = null, \Entities\Company\Lead $Lead = null) {
	$this->_Lead = $Lead;
	parent::__construct($options);
    }
    
    public function init($options = array())
    {
	$form = new Form\Lead\Subform($options, $this->_Lead);
	
	$this->addSubForm($form, "company_lead");
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}

?>
