<?php

/**
 * 
 * @author jessie
 *
 */

class MenuitemController extends Dataservice_Controller_Action
{    
    public function editAction()
    {	
	/* @var $MenuItem \Entities\MenuItem */
	$MenuItem   = $this->getEntityFromParamFields("MenuItem", array("id"));
	$parent_id  = $this->_request->getParam("parent_id", null);
	
	if(!$MenuItem->getId() && $parent_id)
	{
	    $ParentMenuItem = $this->_em->getRepository("Entities\MenuItem")->findOneById($this->_params['parent_id']);
	    if($ParentMenuItem){
		$MenuItem->setParent($ParentMenuItem);
		$MenuItem->setMenu($ParentMenuItem->getMenu());
	    }
	}
	
	$form	    = new Form_Menuitem(array("method" => "post"), $MenuItem);
	$form->addElement("button", "cancel", 
		array("onclick" => "location='".$this->_History->getPreviousUrl(1)."'")
		);
	
	if($this->isPostAndValid($form)){
	    try {
		$menuitem_data	= $this->_params["menuitem"];
		/* @var $Menu \Entities\Menu */
		$Menu		= $this->_em->find("Entities\Menu", $menuitem_data["menu_id"]);
		$MenuItem->populate($menuitem_data);
		
		if($menuitem_data["parent_id"]){
		    $Parent = $this->_em->find("Entities\Menu", $menuitem_data["parent_id"]);
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

