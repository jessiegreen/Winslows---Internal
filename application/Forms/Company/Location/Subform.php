<?php
namespace Forms\Company\Location;
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
class Subform extends \Forms\Location\Subform
{
    private $_Location;
    
    public function __construct($options = null, \Entities\Company\Location $Location = null)
    {
	$this->_Location = $Location;
	
	parent::__construct($options, $Location);
    }
    
    public function init()
    {	
	$this->addElement(new \Dataservice_Form_Element_CompanySelect("company_id", array(
            'required'	    => true,
            'label'	    => 'Company:',
	    'belongsTo'	    => 'company_location',
	    'value'	    => $this->_Location && $this->_Location->getCompany() ? 
				$this->_Location->getCompany()->getId() : 
				""
        )));
	
	parent::init();
    }
}