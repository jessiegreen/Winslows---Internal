<?php
namespace Forms\Company\Employee;
/**
 * Name:
 * Company:
 *
 * Description for class (if any)...
 *
 * @author     Jessie Green <jessie.winslows@gmail.com>
 * @copyright  2012 Winslows inc.
 * @version    Release: @package_version@
 */
class ManageRoles extends \Dataservice_Form
{
    private $_Employee;
    
    public function __construct(\Entities\Company\Employee $Employee, $options = null)
    {
	$this->_Employee = $Employee;
	
	parent::__construct($options);
    }
    
    public function init($options = array())
    {	
        $form = new ManageRoles\Subform($this->_Employee, $options);
	
	$this->addSubForm($form, "company_employee_manage_roles");
	
	$this->addElement('submit', 'Add Role', array(
            'ignore'   => true,
        ));
    }
}

?>
