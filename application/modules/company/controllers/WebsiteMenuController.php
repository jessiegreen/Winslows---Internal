<?php
class Company_WebsiteMenuController extends Dataservice_Controller_Action
{    
    public function editAction()
    {	
	/* @var $Menu \Entities\Website\Menu */
	$Menu	= $this->getEntityFromParamFields("Website\Menu", array("id"));
	
	if(!$Menu->getId())
	{
	    $Website = $this->_getWebsite();

	    $this->_CheckRequiredWebsiteExists($Website);

	    $Menu->setWebsite($Website);
	}
	
	$form	= new Forms\Website\Menu(array("method" => "post"), $Menu);
	$form->addElement("button", "cancel", 
		array("onclick" => "location='".$this->_History->getPreviousUrl(1)."'")
		);
	
	
	if($this->isPostAndValid($form))
	{
	    try 
	    {
		$data	= $this->_params["website_menu"];
		
		$Menu->populate($data);
		
		$this->_em->persist($Menu);
		$this->_em->flush();

		$message = "Menu saved";
		$this->_FlashMessenger->addSuccessMessage($message);
	    } 
	    catch (Exception $exc) 
	    {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
		$this->_History->goBack(1);
	    }
	    $this->_History->goBack(1);
	}
	
	$this->view->form   = $form;
	$this->view->Menu   = $Menu;
    }
    
    public function viewAction()
    {
	$this->view->headScript()->appendFile("/javascript/company/website/menu.js");
	
	$Menu = $this->_getMenu();
	
	$this->_CheckRequiredMenuExists($Menu);
	
	$this->view->Menu = $Menu;
    }
    
    /**
     * @return Entities\Company\Supplier\Product\Configurable\Instance
     */
    private function _getMenu()
    {
	return $this->getEntityFromParamFields("Website\Menu", array("id"));
    }
    
    private function _CheckRequiredMenuExists(\Entities\Website\Menu $Menu)
    {
	if(!$Menu->getId())
	{
	    $this->_FlashMessenger->addErrorMessage("Could not get Menu");
	    $this->_History->goBack();
	}
    } 
    
    /**
     * @return Entities\Company\Website
     */
    private function _getWebsite()
    {
	$id	    = $this->getRequest()->getParam("website_id", 0);
	$Website    = $this->_em->find("Entities\Company\Website", $id);
	if($Website)return $Website;
	else return new Entities\Company\Website;
    }
    
    private function _CheckRequiredWebsiteExists(Entities\Company\Website $Website)
    {
	if(!$Website->getId())
	{
	    $this->_FlashMessenger->addErrorMessage("Could not get Website");
	    $this->_History->goBack();
	}
    }
}

