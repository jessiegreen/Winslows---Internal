<?php
namespace Forms\Role;
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
class RoleAbstract extends \Zend_Form
{
    private $_Role;
    
    public function __construct($options = null, \Entities\Company\Employee\Role $Role = null)
    {
	$this->_Role = $Role;
	parent::__construct($options);
    }
    
    public function init($options = array())
    {
	$form = new Role\Subform($options, $this->_Role);
	
	$this->addSubForm($form, "company_employee_role");

        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}