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
}