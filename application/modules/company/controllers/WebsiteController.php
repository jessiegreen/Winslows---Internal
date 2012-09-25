<?php
class Company_WebsiteController extends Dataservice_Controller_Action
{    
    public function init()
    {
	$this->view->headScript()->appendFile("/javascript/company/website.js");
	
	parent::init();
    }
    
    public function editAction()
    {	
	
    }
    
    public function viewAction()
    {
	$Website = $this->_getWebsite();

	$this->_CheckRequiredWebsiteExists($Website);
	
	$this->view->Website = $Website;
    }
    
    public function viewAllAction()
    {
	$this->view->Websites = $this->_em->getRepository("Entities\Company\Website")->findBy(array(), array("name" => "ASC"));
    }
    
    /**
     * @return Entities\Company\Website
     */
    private function _getWebsite()
    {
	return $this->getEntityFromParamFields("Company\Website", array("id"));
    }
    
    private function _CheckRequiredWebsiteExists(\Entities\Company\Website $Website)
    {
	if(!$Website->getId())
	{
	    $this->_FlashMessenger->addErrorMessage("Could not get Website");
	    $this->_History->goBack();
	}
    } 
}

