<?php

/**
 * 
 * @author jessie
 *
 */

class MaintenanceController extends Zend_Controller_Action
{
    protected $_request;
    protected $_params;
    
    public function init()
    {
	$session		= new Zend_Session_Namespace('Dataservice');
	$session->redirect	= $_SERVER['REQUEST_URI'];

	$this->_request	    = $this->getRequest();
	$this->_params	    = $this->_request->getParams();
    }
    
    public function indexAction()
    {
    }
    
    public function groupsviewAction()
    {
	$this->view->headScript()->appendFile("/javascript/maintenance/groups/group.js");
	/* @var $em \Doctrine\ORM\EntityManager */
	$em	 = $this->_helper->EntityManager();
	/* @var $roles \Repositories\Role */
	$roles   = $em->getRepository('Entities\Role')->findAll();
	
	$this->view->roles = $roles;
    }
    
    public function groupeditAction()
    {
	$id	= isset($this->_params['id']) ? $this->_params['id'] : null;
	$em	= $this->_helper->EntityManager();
	$Role	= $id ? $em->getRepository('\Entities\Role')->findOneById($id) : null;
	$form	=  new Form_Role_Role(array("method" => "post"), $Role);
	
	$form->addElement("button", "cancel", array("label" => "cancel", "onclick" => "location='/maintenance/groupsview'"));
	
	if($this->_request->isPost())
	{
	    if($form->isValid($this->_params))
	    {
		$flashMessenger = $this->_helper->getHelper('FlashMessenger');
		try {
		    $new = false;
		    if(!$Role){
			$Role	= new \Entities\Role(); 
			$new	= true;
		    }
		    $em = $this->_helper->EntityManager();
		    $Role->setName($this->_params['role']['name']);
		    $Role->setDescription($this->_params['role']['description']);
		    $em->persist($Role);
		    $em->flush();
		    $flashMessenger->addMessage(array('message' => "Group '".$Role->getName()."' ".($new ? "Added" : "Edited"), 'status' => 'success'));
		} catch (Exception $exc) {
		    $flashMessenger->addMessage(array('message' => $exc->getMessage(), 'status' => 'error'));
		}
		$this->_redirect('/maintenance/groupsview');
	    }
	    else $form->populate($this->_params);
	}
	$this->view->form = $form;
    }
    
    public function privilegeeditAction()
    {
	$group_id	= isset($this->_params['group_id']) ? $this->_params['group_id'] : null;
	$privilege_id	= isset($this->_params['privilege_id']) ? $this->_params['privilege_id'] : null;
	$em		= $this->_helper->EntityManager();
	$new		= false;
	
	if($group_id) {
	    /* @var $Privilege \Entities\Privilege */
	    $Privilege	= new \Entities\Privilege;
	    /* @var $Group \Entities\Role */
	    $Group	= $em->getRepository('\Entities\Role')->findOneById($group_id);
	    $new	= true;
	}
	elseif($privilege_id) $Privilege = $em->getRepository('\Entities\Privilege')->findOneById($privilege_id);
	else $this->_redirect('/maintenance/groupsview');
	
	$form	=  new Form_Privilege_Privilege(array("method" => "post"), $Privilege);
	
	$form->addElement("button", "cancel", array("label" => "cancel", "onclick" => "location='/maintenance/groupsview'"));
	
	if($this->_request->isPost())
	{
	    if($form->isValid($this->_params))
	    {
		$flashMessenger = $this->_helper->getHelper('FlashMessenger');
		try {
		    $em = $this->_helper->EntityManager();
		    $Privilege->setName($this->_params['privilege']['name']);
		    if(!$Privilege->getRole()){
			$Group->addPrivilege($Privilege);
			$em->persist($Group);
		    }
		    else $em->persist($Privilege);
		    $em->flush();
		    $flashMessenger->addMessage(array('message' => "Privilege '".$Privilege->getName()."' ".($new ? "Added to ".$Group->getName() : "Edited"), 'status' => 'success'));
		} catch (Exception $exc) {
		    $flashMessenger->addMessage(array('message' => $exc->getMessage(), 'status' => 'error'));
		}
		$this->_redirect('/maintenance/groupsview');
	    }
	    else $form->populate($this->_params);
	}
	$this->view->form	= $form;
	$this->view->group_name = isset($Group) ? $Group->getName() : null;
    }
    
    public function groupviewAction()
    {
	if(isset($this->_params['id'])){
	    $role_id	= $this->_params['id'];
	    /* @var $em \Doctrine\ORM\EntityManager */
	    $em		= $this->_helper->EntityManager();
	    /* @var $employee \Entities\Employee */
	    $employee   = $em->getRepository('Entities\Role')->findOneById($role_id);
	    
	    if(!$employee){
		$flashMessenger = $this->_helper->getHelper('FlashMessenger');
		$flashMessenger->addMessage(array('message' => "Could not find Group.", 'status' => 'error'));
		$this->_redirect('/maintenance/privileges');
	    }
	}
    }
    
    public function privilegedeleteAction()
    {
	$id	= isset($this->_params['privilege_id']) ? $this->_params['privilege_id'] : null;
	$em	= $this->_helper->EntityManager();
	$flashMessenger = $this->_helper->getHelper('FlashMessenger');
	try {
	    $Privilege = $em->getRepository('\Entities\Privilege')->findOneById($id);
	    $em = $this->_helper->EntityManager();
	    if($Privilege){
		$em->remove($Privilege);
		$em->flush();
		$flashMessenger->addMessage(array('message' => "Deleted Privilege '".$Privilege->getName()."'", 'status' => 'success'));
	    }
	    else{
		$flashMessenger->addMessage(array('message' => "Privilege Does Not Exist.", 'status' => 'error'));
	    }
	} catch (Exception $exc) {
	    $flashMessenger->addMessage(array('message' => $exc->getMessage(), 'status' => 'error'));
	}
	$this->_redirect('/maintenance/groupsview');
	$this->view->form = $form;
    }
    
    public function usersviewAction()
    {
	$this->view->headScript()->appendFile("/javascript/maintenance/users/user.js");
	/* @var $em \Doctrine\ORM\EntityManager */
	$em	 = $this->_helper->EntityManager();
	/* @var $roles \Repositories\Role */
	$users   = $em->getRepository('Entities\User')->findAll();
	
	$this->view->users = $users;
    }
    
    public function navigationviewAction(){
	$this->view->headScript()->appendFile("/javascript/maintenance/navigation/navigation.js");
	
	$MenuService = new \Services\Menu\Menu;
	$this->view->menu_items = $MenuService->getMenuParentItems("Top");
    }
    
    public function navigationeditAction()
    {
	/* @var $em \Doctrine\ORM\EntityManager */
	$em = $this->_helper->EntityManager();
	
	if(isset($this->_params['id'])){
	    /* @var $MenuItem \Entities\MenuItem */
	    $MenuItem	= $em->getRepository("Entities\MenuItem")->findOneById($this->_params["id"]);
	    $form	= new Form_Menu_Menuitem(array("method" => "post"), $MenuItem);
	    if($this->_request->isPost())
	    {
		if($form->isValid($this->_params))
		{
		    $flashMessenger = $this->_helper->getHelper('FlashMessenger');
		    try {
			$this->setNavigationFields($MenuItem);
			$em->persist($MenuItem);
			$em->flush();
			$flashMessenger->addMessage(array('message' => "Menu Item '".$MenuItem->getLabel()."' Edited", 'status' => 'success'));
		    } catch (Exception $exc) {
			$flashMessenger->addMessage(array('message' => $exc->getMessage(), 'status' => 'error'));
		    }
		    $this->_redirect('/maintenance/navigationview');
		}
		else $form->populate($this->_params);
	    }
	}
	elseif (isset($this->_params['parent_id']))
	{
	    $MenuItem	    = new \Entities\MenuItem;
	    $ParentMenuItem = $em->getRepository("Entities\MenuItem")->findOneById($this->_params['parent_id']);
	    $MenuItem->setParent($ParentMenuItem);
	    $form	    = new Form_Menu_Menuitem(array("method" => "post"), $MenuItem);
	    if($this->_request->isPost())
	    {
		if($form->isValid($this->_params))
		{
		    $flashMessenger = $this->_helper->getHelper('FlashMessenger');
		    try {
			$MenuItem->setParent($ParentMenuItem);
			$this->setNavigationFields($MenuItem);
			$em->persist($MenuItem);
			$em->flush();
			$flashMessenger->addMessage(array('message' => "Menu Item '".$MenuItem->getLabel()."' Added", 'status' => 'success'));
		    } catch (Exception $exc) {
			$flashMessenger->addMessage(array('message' => $exc->getMessage(), 'status' => 'error'));
		    }
		    $this->_redirect('/maintenance/navigationview');
		}
		else $form->populate($this->_params);
	    }
	}
	else
	{
	    $MenuItem	    = new \Entities\MenuItem;
	    $MenuService    = new \Services\Menu\Menu;
	    $Menu	    = $MenuService->getMenuByName("Top");
	    $MenuItem->setMenu($Menu);
	    $form	    = new Form_Menu_Menuitem(array("method" => "post"), $MenuItem);
	    if($this->_request->isPost())
	    {
		if($form->isValid($this->_params))
		{
		    $flashMessenger = $this->_helper->getHelper('FlashMessenger');
		    try {
			$MenuItem->setMenu($Menu);
			$this->setNavigationFields($MenuItem);
			$em->persist($MenuItem);
			$em->flush();
			$flashMessenger->addMessage(array('message' => "Menu Item '".$MenuItem->getLabel()."' Added", 'status' => 'success'));
		    } catch (Exception $exc) {
			$flashMessenger->addMessage(array('message' => $exc->getMessage(), 'status' => 'error'));
		    }
		    $this->_redirect('/maintenance/navigationview');
		}
		else $form->populate($this->_params);
	    }
	}
	
	$this->view->form = $form;
    }
    
    /**
     *
     * @param array $values
     * @param \Entities\MenuItem $MenuItem 
     */
    private function setNavigationFields($MenuItem)
    {
	$MenuItem->setLabel($this->_params['menuitem']['label']);
	$MenuItem->setNameIndex($this->_params['menuitem']['name_index']);
	$MenuItem->setLinkModule($this->_params['menuitem']['link_module']);
	$MenuItem->setLinkController($this->_params['menuitem']['link_controller']);
	$MenuItem->setLinkAction($this->_params['menuitem']['link_action']);
	$MenuItem->setLinkParams($this->_params['menuitem']['link_params']);
	$MenuItem->setIcon($this->_params['menuitem']['icon']);
    }
    
    public function resourcebuildAction(){
	/* @var $em \Doctrine\ORM\EntityManager */
	$em = $this->_helper->EntityManager();
	$objResources = new Dataservice_ACL_Resources;
	$objResources->buildAllArrays();
	$objResources->writeToDB($em);
    }
}

