<?php
namespace Services;

use Doctrine\ORM\EntityManager;

class Company extends \Dataservice_Service_ServiceAbstract
{    
    /**
     *
     * @return \Entities\Company 
     */
    public function getCurrentCompany()
    {
	return $this->_em->getRepository("Entities\Company")->find(
			\Services\Website::factory()->getCurrentWebsite()->getCompany()->getId()
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
