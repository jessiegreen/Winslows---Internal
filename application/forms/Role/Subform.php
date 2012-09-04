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
class Subform extends \Zend_Form_SubForm
{
    private $_Role;
    
    public function __construct($options = null, \Entities\Company\Employee\Role $Role = null) {
	$this->_Role = $Role;
	parent::__construct($options);
    }
    
    public function init(){
	
	$this->addElement('text', 'name', array(
            'required'	    => true,
            'label'	    => 'Name:',
	    'belongsTo'	    => 'role',
	    'value'	    => $this->_Role ? $this->_Role->getName() : ""
        ));
	
	$this->addElement('textarea', 'description', array(
            'required'	    => false,
            'label'	    => 'Description:',
	    'belongsTo'	    => 'role',
	    'style'	    => 'width:200px;height:150px;',
	    'value'	    => $this->_Role ? $this->_Role->getDescription() : ""
        ));
    }
}

?>
