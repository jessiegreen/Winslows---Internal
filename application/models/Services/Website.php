<?php
namespace Services;

class Website extends \Dataservice_Service_ServiceAbstract
{   
    /**
     * @return Website
     */
    public static function factory()
    {
	return parent::factory();
    }
    
    /**
     * @return string
     */
    public function getCurrentNameIndex()
    {
	return WEBSITE_NAME_INDEX;
    }
    
    /**
     * @return \Entities\Website\WebsiteAbstract
     */
    public function getCurrentWebsite()
    {
	return $this->_em->getRepository("Entities\Website\WebsiteAbstract")
		    ->findOneBy(array("name_index" => $this->getCurrentNameIndex()));
    }
}