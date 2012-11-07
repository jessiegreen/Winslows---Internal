<?php
namespace Forms\Company\Employee\Account;
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
class Subform extends \Forms\Website\Account\Subform
{    
    private $_Account;
    
    private $_safe;
    
    public function __construct($options = null, \Entities\Company\Employee\Account  $Account = null, $safe = true) 
    {
	$this->_Account = $Account;
	$this->_safe	= $safe;
        
	parent::__construct($options, $this->_Account, $this->_safe);
    }
    
    public function init($options = array())
    {	
	$this->addElement(new \Dataservice_Form_Element_EmployeeSelect("employee_id", array(
            'required'	    => true,
            'label'	    => 'Employee:',
	    'belongsTo'	    => 'company_employee_account',
	    'value'	    => $this->_Account && $this->_Account->getEmployee() ? $this->_Account->getEmployee()->getId() : ""
        )));
        
	parent::init($options);
    }
}