<?php
namespace Forms\Company\Employee\ManageRoles;
/**
 * Name:
 * Product:
 *
 * Description for class (if any)...
 *
 * @author     Jessie Green <jessie.winslows@gmail.com>
 * @copyright  2012 Winslows inc.
 * @version    Release: @package_version@
 */
class Subform extends \Zend_Form_SubForm
{
    private $_Employee;
    
    public function __construct(\Entities\Company\Employee $Employee, $options = null)
    {
	$this->_Employee = $Employee;
	parent::__construct($options);
    }
    
    public function init()
    {	
	$this->addElement(new \Dataservice_Form_Element_Employee_ManageRoles_Select("role_id", array(
            'required'	    => true,
            'label'	    => 'Roles:',
	    'belongsTo'	    => 'company_employee_manage_roles'
        )));
    }
}