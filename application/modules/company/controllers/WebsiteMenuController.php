<?php
class Company_WebsiteMenuController extends Dataservice_Controller_Action
{    
    public function editAction()
    {	
	
    }
    
    public function viewAction()
    {
	$this->view->headScript()->appendFile("/javascript/website/menu.js");
	
	$Menu = $this->_getMenu();
	
	$this->_CheckRequiredMenuExists($Menu);
	
	$this->view->Menu = $Menu;
	$this->view->menu_items = Services\Company\Website\Menu::factory()->getMenuParentItems("Top");
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
}

