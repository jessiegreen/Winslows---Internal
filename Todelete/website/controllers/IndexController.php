<?php
class Website_IndexController extends Dataservice_Controller_Action
{    
    public function init()
    {
	$this->view->headScript()->appendFile("/javascript/website.js");
	
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
	$this->view->Websites = $this->_em->getRepository("Entities\Website\WebsiteAbstract")->findBy(array(), array("name" => "ASC"));
    }
    
    /**
     * @return Entities\Company\Supplier\Product\Configurable\Instance
     */
    private function _getWebsite()
    {
	return $this->getEntityFromParamFields("Website\WebsiteAbstract", array("id"));
    }
    
    private function _CheckRequiredWebsiteExists(\Entities\Website\WebsiteAbstract $Website)
    {
	if(!$Website->getId())
	{
	    $this->_FlashMessenger->addErrorMessage("Could not get Website");
	    $this->_History->goBack();
	}
    } 
}

