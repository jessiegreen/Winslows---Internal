<?php
namespace Forms\Company\Lead;
use Entities\Company\Lead as Lead;
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
class Subform extends \Forms\Person\Subform
{    
    private $_Lead;
    
    public function __construct($options = null, Lead $Lead = null) {
	$this->_Lead = $Lead;
	parent::__construct($options, $this->_Lead);
    }
    
    public function init($options = array())
    {	
        $this->addElement(new Dataservice_Form_Element_EmployeeSelect("employee", array(
            'required'	    => true,
            'label'	    => 'Employee:',
	    'belongsTo'	    => 'lead',
	    'value'	    => $this->_Lead && $this->_Lead->getEmployee() ? 
				    $this->_Lead->getEmployee()->getId() : 
				    Services\Auth::factory()->getIdentityPerson()->getId()
        )));
	
	parent::init($options);
    }
}

?>
