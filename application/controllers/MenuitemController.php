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
	$Menu	    = \Services\Menu::factory()->getMenuByName("Top");
	/* @var $MenuItem \Entities\MenuItem */
	$MenuItem   = $this->getEntityFromParamFields("MenuItem", array("id"));
	
	#-- Update
	if($MenuItem->getId()){	    
	    $form = new Form_MenuItem(array("method" => "post"), $MenuItem);
	}
	#-- Add Sub Item
	elseif (isset($this->_params['parent_id']))
	{
	    $MenuItem	    = new \Entities\MenuItem;
	    $ParentMenuItem = $this->_em->getRepository("Entities\MenuItem")->findOneById($this->_params['parent_id']);
	    $MenuItem->setParent($ParentMenuItem);
	    $MenuItem->setMenu($Menu);	    
	}
	#-- Add Top level Item
	else
	{
	    $MenuItem	    = new \Entities\MenuItem;
	    $MenuItem->setMenu($Menu);
	}
	
	$form	    = new Form_Menuitem(array("method" => "post"), $MenuItem);
	
	if($this->isPostAndValid($form)){
	    try {
		$MenuItem->populate($this->_params["menuitem"]);
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

