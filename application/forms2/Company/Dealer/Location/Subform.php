<?php
namespace Forms\Company\Dealer\Location;
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
class Subform extends \Forms\Company\Location\Subform
{
    private $_Location;
    
    public function __construct($options = null, \Entities\Company\Dealer\Location $Location = null)
    {
	$this->_Location = $Location;
	
	parent::__construct($options, $Location);
    }
    
    public function init()
    {
	$this->addElement(new \Dataservice_Form_Element_Company_DealerSelect("dealer_id", array(
            'required'	    => true,
            'label'	    => 'Dealer:',
	    'belongsTo'	    => 'company_dealer_location',
	    'value'	    => $this->_Location && $this->_Location->getDealer() ? 
				$this->_Location->getDealer()->getId() : 
				""
        )));
	
	parent::init();
    }
}