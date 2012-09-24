<?php
namespace Services;

class Website extends \Dataservice_Service_ServiceAbstract
{   
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
    
    
    public function getGenericWebsiteGuest()
    {
	return $this->_em->getRepository("Entities\Website\Guest")
		    ->findOneBy(array("id" => 27));
    }
}