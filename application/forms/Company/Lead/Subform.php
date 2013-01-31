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
class Subform extends \Forms\Company\Person\Subform
{    
    private $_Lead;
    
    public function __construct($options = null, \Entities\Company\Lead $Lead = null)
    {
	$this->_Lead = $Lead;
	parent::__construct($options, $this->_Lead);
    }
    
    public function init($options = array())
    {	
        $this->addElement(new \Dataservice_Form_Element_EmployeeSelect("employee", array(
            'required'	    => true,
            'label'	    => 'Employee:',
	    'belongsTo'	    => 'lead',
	    'value'	    => $this->_Lead && $this->_Lead->getEmployee() ? 
				    $this->_Lead->getEmployee()->getId() : 
				    \Services\Company\Website::factory()
					->getCurrentWebsite()
					->getCurrentUserAccount(\Zend_Auth::getInstance())
					->getPerson()
					->getId()
        )));
	
	parent::init($options);
    }
}

?>
