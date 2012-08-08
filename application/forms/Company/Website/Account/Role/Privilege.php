<?php
namespace Forms\Company\Website\Account\Role;
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
class Privilege extends \Zend_Form
{
    private $_privilege;
    
    public function __construct($options = null, \Entities\Privilege $privilege = null) {
	$this->_privilege = $privilege;
	parent::__construct($options);
    }
    
    public function init($options = array()){
	if($this->_privilege !== null && $this->_privilege->getId() > 0){
	    $id = $this->addElement('hidden', 'id', array(
		'required'  => true,
		'belongsTo' => 'privilege',
		'value'	    => $this->_privilege ? $this->_privilege->getId() : ""
	    ));
	}
	
	$this->addElement('text', 'name', array(
            'required'	    => true,
            'label'	    => 'Name:',
	    'belongsTo'	    => 'privilege',
	    'value'	    => $this->_privilege ? $this->_privilege->getName() : ""
        ));
	
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));

    }
}

?>
