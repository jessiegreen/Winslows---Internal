<?php
namespace Services\Company;

class Website extends \Dataservice_Service_ServiceAbstract
{
    /**
     * @return Website
     */
    public static function factory()
    {
	return parent::factory();
    }
    
    public function getAllWebsites()
    {
	return $this->_em->getRepository("Entities\Company\Website")->findBy(array(), array("name" => "ASC"));
    }
    
    /**
     * @return string
     */
    public function getCurrentNameIndex()
    {
	return WEBSITE_NAME_INDEX;
    }
    
    /**
     * @return \Entities\Company\Website\WebsiteAbstract
     */
    public function getCurrentWebsite()
    {
	return $this->_em->getRepository("Entities\Company\Website\WebsiteAbstract")
		    ->findOneBy(array("name_index" => $this->getCurrentNameIndex()));
    }
}