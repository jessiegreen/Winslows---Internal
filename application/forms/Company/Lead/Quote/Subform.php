<?php
namespace Forms\Company\Lead\Quote;
use Entities\Company\Lead\Quote as Quote;
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
class Subform extends QuoteAbstract\Subform
{
    private $_Quote; 
    
    public function __construct($options = null, Quote $Quote = null) 
    {
	$this->_Quote = $Quote;
	parent::__construct($options);
    }
    
    public function init() 
    {
	$this->addElement(new Dataservice_Form_Element_LeadSelect("lead_id", array(
            'required'	    => true,
            'label'	    => 'Lead:',
	    'belongsTo'	    => 'quote',
	    'value'	    => $this->_Quote && 
				    $this->_Quote->getLead()
				? $this->_Quote->getLead()->getId() 
				: ""
        )));
	
	$this->addElement(new Dataservice_Form_Element_EmployeeSelect("employee_id", array(
            'required'	    => true,
            'label'	    => 'Sales Person:',
	    'belongsTo'	    => 'quote',
	    'value'	    => $this->_Quote && 
				    $this->_Quote->getEmployee()
				? $this->_Quote->getEmployee()->getId() 
				: ""
        )));
	
	parent::init();
    }
}