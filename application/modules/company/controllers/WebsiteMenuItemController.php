<?php
class Company_WebsiteMenuItemController extends Dataservice_Controller_Crud_Action
{    
    public function init()
    {
	$this->_EntityClass = "Entities\Company\Website\Menu\Item";
	
	parent::init();
    }

    public function removeAction()
    {
	$this->_helper->viewRenderer->setNoRender(true);
	$this->_helper->layout->disableLayout();
	
	$menu_id	= $this->_getParam("menu_id");
	$menuitem_id	= $this->_getParam("menuitem_id");
	
	if($menuitem_id)
	{
	    /* @var $em \Doctrine\ORM\EntityManager */
	    $em		= $this->_helper->EntityManager();
	    /* @var $Resource \Entities\Company\Website\Menu */
	    $Menu	= $em->find("Entities\Company\Website\Menu", $menu_id);
	    $MenuItem	= $em->find("Entities\Company\Website\Menu\Item", $menuitem_id);
	    
	    if($Menu && $MenuItem)
	    {
		$Menu->removeItem($MenuItem);		
		$em->persist($Menu);
		$em->flush();
		
		$this->_FlashMessenger->addSuccessMessage("Menu Item Removed");
	    }
	    else
	    {
		$this->_FlashMessenger->addErrorMessage("Error Removing Menu Item - Not Found");
	    }
	    
	    $this->_History->goBack();
	}
	else
	{
	    $this->_FlashMessenger->addErrorMessage("Error Removing Menu Item, Id Not Sent");
	    $this->_History->goBack();
	}
    }
}

