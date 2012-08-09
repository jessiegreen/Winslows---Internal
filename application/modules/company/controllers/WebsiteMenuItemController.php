<?php

/**
 * 
 * @author jessie
 *
 */

class Company_WebsiteMenuItemController extends Dataservice_Controller_Action
{    
    public function editAction()
    {	
	/* @var $MenuItem \Entities\Company\Website\Menu\Item */
	$MenuItem   = $this->getEntityFromParamFields("Company\Website\Menu\Item", array("id"));
	$parent_id  = $this->_request->getParam("parent_id", null);
	
	if(!$MenuItem->getId() && $parent_id)
	{
	    $ParentMenuItem = $this->_em->getRepository("Entities\Company\Website\Menu\Item")->findOneById($this->_params['parent_id']);
	    
	    if($ParentMenuItem){
		$MenuItem->setParent($ParentMenuItem);
		$MenuItem->setMenu($ParentMenuItem->getMenu());
	    }
	}
	
	$form	    = new Forms\Company\Website\Menu\Item(array("method" => "post"), $MenuItem);
	$form->addElement("button", "cancel", 
		array("onclick" => "location='".$this->_History->getPreviousUrl(1)."'")
		);
	
	if($this->isPostAndValid($form)){
	    try {
		$menuitem_data	= $this->_params["company_website_menu_item"];
		/* @var $Menu \Entities\Company\Website\Menu */
		$Menu		= $this->_em->find("Entities\Company\Website\Menu", $menuitem_data["menu_id"]);
		$MenuItem->populate($menuitem_data);
		
		if($menuitem_data["parent_id"]){
		    $Parent = $this->_em->find("Entities\Company\Website\Menu", $menuitem_data["parent_id"]);
		    if($Parent)$MenuItem->setParent($MenuItem);
		}
		
		$MenuItem->setMenu($Menu);
		$this->_em->persist($MenuItem);
		$this->_em->flush();
		$this->_FlashMessenger->addSuccessMessage("Menu Item '".$MenuItem->getLabel()."' Added/Edited");
	    } catch (Exception $exc) {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
	    }
	    $this->_redirect('/maintenance/navigationview');
	}
	
	$this->view->form = $form;
    }

}

