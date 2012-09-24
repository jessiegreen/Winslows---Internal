<?php
class Company_WebsiteMenuItemController extends Dataservice_Controller_Action
{    
    public function editAction()
    {	
	/* @var $MenuItem \Entities\Website\Menu\Item */
	$MenuItem   = $this->getEntityFromParamFields("Website\Menu\Item", array("id"));
	$parent_id  = $this->_request->getParam("parent_id", null);
	
	if(!$MenuItem->getId() && $parent_id)
	{
	    $ParentMenuItem = $this->_em->getRepository("Entities\Website\Menu\Item")->findOneById($this->_params['parent_id']);
	    
	    if($ParentMenuItem){
		$MenuItem->setParent($ParentMenuItem);
		$MenuItem->setMenu($ParentMenuItem->getMenu());
	    }
	}
	
	$form	    = new Forms\Website\Menu\Item(array("method" => "post"), $MenuItem);
	$form->addElement("button", "cancel", 
		array("onclick" => "location='".$this->_History->getPreviousUrl(1)."'")
		);
	
	if($this->isPostAndValid($form))
	{
	    try 
	    {
		$menuitem_data	= $this->_params["website_menu_item"];
		/* @var $Menu \Entities\Website\Menu */
		$Menu		= $this->_em->find("Entities\Website\Menu", $menuitem_data["menu_id"]);
		
		$MenuItem->populate($menuitem_data);
		
		if($menuitem_data["parent_id"])
		{
		    $Parent = $this->_em->find("Entities\Website\Menu", $menuitem_data["parent_id"]);
		    
		    if($Parent)$MenuItem->setParent($MenuItem);
		}
		
		$MenuItem->setMenu($Menu);
		$this->_em->persist($MenuItem);
		$this->_em->flush();
		$this->_FlashMessenger->addSuccessMessage("Menu Item '".$MenuItem->getLabel()."' Added/Edited");
	    } 
	    catch (Exception $exc)
	    {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
	    }
	    
	    $this->_History->goBack();
	}
	
	$this->view->form = $form;
    }

    public function removeAction()
    {
	$this->_helper->viewRenderer->setNoRender(true);
	$this->_helper->layout->disableLayout();
	
//	$ACL = new Dataservice_Controller_Plugin_ACL();
//	
//	$ACL->preDispatch($this->_request);
	
	$menu_id	= isset($this->_params["menu_id"]) ? $this->_params["menu_id"] : null;
	$menuitem_id	= isset($this->_params["menuitem_id"]) ? $this->_params["menuitem_id"] : null;
	
	if($menuitem_id){
	    /* @var $em \Doctrine\ORM\EntityManager */
	    $em		= $this->_helper->EntityManager();
	    /* @var $Resource \Entities\Website\Menu */
	    $Menu	= $em->find("Entities\Website\Menu", $menu_id);
	    $MenuItem	= $em->find("Entities\Website\Menu\Item", $menuitem_id);
	    
	    if($Menu && $MenuItem)
	    {
		if(!$Menu->removeItem($MenuItem))
		{
		    $this->_FlashMessenger->addErrorMessage("Could Not Remove MenuItem");
		}
		
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

