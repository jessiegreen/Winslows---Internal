<?php
namespace Services;

class Company extends \Dataservice_Service_ServiceAbstract
{    
    /**
     * @return Company
     */
    public static function factory()
    {
	return parent::factory();
    }
    
    /**
     *
     * @return \Entities\Company 
     */
    public function getCurrentCompany()
    {
	return $this->_em->getRepository("Entities\Company")->find(
			\Services\Company\Website::factory()->getCurrentWebsite()->getCompany()->getId()
		);
    }
    
    /** 
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getCompanies()
    {
	return $this->_em->getRepository("Entities\Company")->findBy(array(), array("name" => "ASC"));
    }
}
