<?php
namespace Services\Company;

class Lead extends \Dataservice_Service_ServiceAbstract
{
    /**
     * @return Lead
     */
    public static function factory() 
    {
	return parent::factory();
    }
	    
    public function getAllAllowedLeads()
    {
	$Website    = \Services\Company\Website::factory()->getCurrentWebsite();
	$Employee   = $Website->getCurrentUserAccount(\Zend_Auth::getInstance())->getPerson();
	
	/* @var $Employee \Entities\Company\Employee */
	return $Employee->getAllAllowedLeads();
    }
}
