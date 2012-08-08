<?php
namespace Forms\Company\Location;
use Entities\Company\Location as Location;
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
    private $_Location;
    
    public function __construct($options = null, Location $Location = null)
    {
	$this->_Location = $Location;
	parent::__construct($options);
    }
    
    public function init()
    {	
	if($this->_Location){
	    $type_options   = $this->_Location->getTypeOptions();
	}
	else{
	    $Location	    = new Location;
	    $type_options   = $Location->getTypeOptions();
	}
	
	$this->addElement(new Dataservice_Form_Element_CompanySelect("company_id", array(
            'required'	    => true,
            'label'	    => 'Company:',
	    'belongsTo'	    => 'location',
	    'value'	    => $this->_Location && $this->_Location->getCompany() ? 
				$this->_Location->getCompany()->getId() : 
				""
        )));
	
	$this->addElement('text', 'name', array(
            'required'	    => true,
            'label'	    => 'Name:',
	    'belongsTo'	    => 'location',
	    'value'	    => $this->_Location ? $this->_Location->getName() : ""
        ));
	
	$this->addElement('select', 'type', array(
            'required'	    => true,
            'label'	    => 'Type:',
	    'multioptions'  => $type_options,
	    'belongsTo'	    => "location",
	    'value'	    => $this->_Location ? $this->_Location->getType() : ""
        ));
    }
}

?>
