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
	$Website	= $this->_getWebsite();
	$company_id	= $this->getRequest()->getParam("company_id", null);
	$CompanyRepos	= $this->_em->getRepository("Entities\Company");
	
	if(!$Website->getId())
	{
	    if($company_id)
	    {
		$Company = $CompanyRepos->find($company_id);
		
		if($Company)
		{
		    $Website->setCompany($Company);
		}
	    }
	}
	
	$form = new Forms\Company\Website($Website, array("method" => "post"));
	
	$form->addElement("button", "cancel", 
		array("onclick" => "location='".$this->_History->getPreviousUrl(1)."'")
		);
	
	if($this->isPostAndValid($form))
	{
	    $data = $this->_params["company_website"];
	    
	    try 
	    {
		$Website->populate($data);

		$Company = $CompanyRepos->find($data["company_id"]);

		if($Company)
		{
		    $Website->setCompany($Company);
		}

		$this->_em->persist($Website);
		$this->_em->flush();
	    
		$this->_FlashMessenger->addSuccessMessage("Website Saved"); 
		$this->_History->goBack();
	    }
	    catch (Exception $exc)
	    {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
		$this->_History->goBack();
	    }
	}
	
	$this->view->Website	= $Website;
	$this->view->form	= $form;
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

