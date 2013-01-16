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
	$Employee   = \Services\Auth::factory()->getIdentityPerson();
	$AdminRole  = \Services\Company\Employee\Role::factory()->getAdminRole();
	
	if($Employee->hasRole($AdminRole) || $Employee->hasRole('Sales Manager'))
	{
	    return $this->_em->getRepository("Entities\Company\Lead")->findBy(array(), array("last_name" => "ASC", "first_name" => "ASC"));
	}
	
	/* @var $Employee \Entities\Company\Employee */
	return $Employee->getLeads();
    }
}
