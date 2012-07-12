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
    
    public function navigationviewAction(){
	$this->view->headScript()->appendFile("/javascript/maintenance/navigation/navigation.js");
	
	$MenuService = new \Services\Menu\Menu;
	$this->view->menu_items = $MenuService->getMenuParentItems("Top");
    }
    
    public function navigationeditAction()
    {
	/* @var $em \Doctrine\ORM\EntityManager */
	$em = $this->_helper->EntityManager();
	$MenuService    = new \Services\Menu\Menu;
	
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
	    $Menu	    = $MenuService->getMenuByName("Top");
	    $ParentMenuItem = $em->getRepository("Entities\MenuItem")->findOneById($this->_params['parent_id']);
	    $MenuItem->setParent($ParentMenuItem);
	    $MenuItem->setMenu($Menu);
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
    
    public function navigationremoveAction()
    {
	$this->_helper->viewRenderer->setNoRender(true);
	$ACL = new Dataservice_Controller_Plugin_ACL();
	$ACL->preDispatch($this->_request);
	$this->_helper->layout->disableLayout();
	
	$menu_id	= isset($this->_params["menu_id"]) ? $this->_params["menu_id"] : null;
	$menuitem_id	= isset($this->_params["menuitem_id"]) ? $this->_params["menuitem_id"] : null;
	$flashMessenger = $this->_helper->getHelper('FlashMessenger');
	
	if($menuitem_id){
	    /* @var $em \Doctrine\ORM\EntityManager */
	    $em		= $this->_helper->EntityManager();
	    /* @var $Resource \Entities\Menu */
	    $Menu	= $em->find("Entities\Menu", $menu_id);
	    $MenuItem	= $em->find("Entities\MenuItem", $menuitem_id);
	    if($Menu && $MenuItem){
		if(!$Menu->removeMenuItem($MenuItem)){
		    $flashMessenger->addMessage(array('message' => "Could Not Remove MenuItem", 'status' => 'error'));
		    $this->_redirect('/maintenance/navigationview/');
		}
		$em->persist($Menu);
		$em->flush();
		$flashMessenger->addMessage(array('message' => "Menu Item Removed", 'status' => 'success'));
		$this->_redirect('/maintenance/navigationview');
	    }
	    else{
		$flashMessenger->addMessage(array('message' => "Error Removing Menu Item - Not Found", 'status' => 'error'));
		$this->_redirect('/maintenance/navigationview');
	    }
	}
	else{
	    $flashMessenger->addMessage(array('message' => "Error Removing Menu Item, Id Not Sent", 'status' => 'error'));
	    $this->_redirect('/maintenance/resourcesview');
	}
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
    
    public function resourcesviewAction(){
	$this->view->headScript()->appendFile("/javascript/maintenance/resource/resource.js");
	/* @var $em \Doctrine\ORM\EntityManager */
	$em = $this->_helper->EntityManager();
	$this->view->Resources = $em->getRepository("Entities\Resource")->findAll();
    }
    
    public function resourceeditAction(){
	$this->view->headScript()->appendFile("/javascript/maintenance/resource/resource.js");
	
	if(isset($this->_params["id"])){
	    /* @var $em \Doctrine\ORM\EntityManager */
	    $em			    = $this->_helper->EntityManager();
	    /* @var $Resource \Entities\Resource */
	    $Resource		    = $em->find("\Entities\Resource",$this->_params["id"]); 
	    $this->view->Resource   = $Resource;
	    $this->view->Roles	    = $em->getRepository("Entities\Role")->findAll();
	}
    }
    
    public function removeroleAction(){
	$this->_helper->viewRenderer->setNoRender(true);
	$ACL = new Dataservice_Controller_Plugin_ACL();
	$ACL->preDispatch($this->_request);
	$this->_helper->layout->disableLayout();
	
	$resource_id	= isset($this->_params["resource_id"]) ? $this->_params["resource_id"] : null;
	$role_id	= isset($this->_params["role_id"]) ? $this->_params["role_id"] : null;
	$flashMessenger = $this->_helper->getHelper('FlashMessenger');
	
	if($resource_id && $role_id){
	    /* @var $em \Doctrine\ORM\EntityManager */
	    $em		= $this->_helper->EntityManager();
	    /* @var $Resource \Entities\Resource */
	    $Resource	= $em->find("Entities\Resource", $resource_id);
	    if($Resource){
		if(!$Resource->removeRole($role_id)){
		    $flashMessenger->addMessage(array('message' => "Could Not Remove Role", 'status' => 'error'));
		    $this->_redirect('/maintenance/resourceedit/id/'.$resource_id);
		}
		$em->persist($Resource);
		$em->flush();
		$flashMessenger->addMessage(array('message' => "Role Removed", 'status' => 'success'));
		$this->_redirect('/maintenance/resourceedit/id/'.$resource_id);
	    }
	    else{
		$flashMessenger->addMessage(array('message' => "Error Removing Role - Resource or Role Not Found", 'status' => 'error'));
		$this->_redirect('/maintenance/resourceedit/id/'.$resource_id);
	    }
	}
	else{
	    $flashMessenger->addMessage(array('message' => "Error Removing Role - Resource or Role Not Sent", 'status' => 'error'));
	    $this->_redirect('/maintenance/resourcesview');
	}
    }
    
    public function addroleAction(){
	$this->_helper->viewRenderer->setNoRender(true);
	$ACL = new Dataservice_Controller_Plugin_ACL();
	$ACL->preDispatch($this->_request);
	$this->_helper->layout->disableLayout();
	
	$resource_id	= isset($this->_params["resource_id"]) ? $this->_params["resource_id"] : null;
	$role_id	= isset($this->_params["role_id"]) ? $this->_params["role_id"] : null;
	$flashMessenger = $this->_helper->getHelper('FlashMessenger');
	
	if($resource_id && $role_id){
	    /* @var $em \Doctrine\ORM\EntityManager */
	    $em		= $this->_helper->EntityManager();
	    /* @var $Resource \Entities\Resource */
	    $Resource	= $em->find("Entities\Resource", $resource_id);
	    $Role	= $em->find("Entities\Role", $role_id);
	    if($Resource && $Role){
		$Resource->addRole($Role);
		$em->persist($Resource);
		$em->flush();
		$flashMessenger->addMessage(array('message' => "Role Added", 'status' => 'success'));
		$this->_redirect('/maintenance/resourceedit/id/'.$resource_id);
	    }
	    else{
		$flashMessenger->addMessage(array('message' => "Error Adding Role - Resource or Role Not Available", 'status' => 'error'));
		$this->_redirect('/maintenance/resourcesview');
	    }
	}
	else{
	    $flashMessenger->addMessage(array('message' => "Error Adding Role - Resource or Role Not Sent", 'status' => 'error'));
	    $this->_redirect('/maintenance/resourcesview');
	}
    }
    
    public function employeesviewAction(){
	$this->view->headScript()->appendFile("/javascript/maintenance/employee/employee.js");
	
	$em			= $this->_helper->EntityManager();
	$EmployeeRepos		= $em->getRepository("Entities\Employee");
	$this->view->Employees	= $EmployeeRepos->findAll();
    }
    
    public function employeeeditAction(){
	$em		= $this->_helper->EntityManager();
	$Employee	= isset($this->_params["id"]) ? $em->find("Entities\Employee", $this->_params["id"]) :"";
	$Employee	= $Employee ? $Employee : null;
	$form		=  new Form_Employee_AddComplete(array("method" => "post"), $Employee);
	$new		= false;

	$form->addElement("button", "cancel", array("label" => "cancel", "onclick" => "location='/maintenance/employeesview'"));

	if($this->_request->isPost())
	{
	    if($form->isValid($this->_params))
	    {
		$flashMessenger = $this->_helper->getHelper('FlashMessenger');
		try {
		    $new = false;
		    if(!$Employee){
			$Employee	= new Entities\Employee(); 
			$new		= true;
		    }
		    $Employee->setTitle($this->_params['employee']['title']);
		    $Employee->setFirstName($this->_params['person']['first_name']);
		    $Employee->setMiddleName($this->_params['person']['middle_name']);
		    $Employee->setLastName($this->_params['person']['last_name']);
		    $Employee->setSuffix($this->_params['person']['suffix']);
		    
		    if(!$new){
			$PersonAddresses    = $Employee->getPersonAddresses();
			$address_count	    = count($PersonAddresses);
			$address_i	    = 0;
			if($address_count > 0){
			    foreach($this->_params['address'] as $address_params){
				/* @var $PersonAddress \Entities\PersonAddress */
				$PersonAddress = $PersonAddresses[$address_i];
				$PersonAddress->setName($address_params['name']);
				$PersonAddress->setAddress1($address_params['address_1']);
				$PersonAddress->setAddress2($address_params['address_2']);
				$PersonAddress->setCity($address_params['city']);
				$PersonAddress->setState($address_params['state']);
				$PersonAddress->setZip1($address_params['zip_1']);
				$PersonAddress->setZip2($address_params['zip_2']);
				$address_i++;
			    }
			}
		    }
		    else{
			$address_params = $this->_params["address"][1];
			$PersonAddress = new \Entities\PersonAddress();
			$PersonAddress->setName($address_params['name']);
			$PersonAddress->setAddress1($address_params['address_1']);
			$PersonAddress->setAddress2($address_params['address_2']);
			$PersonAddress->setCity($address_params['city']);
			$PersonAddress->setState($address_params['state']);
			$PersonAddress->setZip1($address_params['zip_1']);
			$PersonAddress->setZip2($address_params['zip_2']);
			$Employee->addPersonAddress($PersonAddress);
		    }
		    
		    $em->persist($Employee);
		    $em->flush();
		    $flashMessenger->addMessage(array('message' => "Employee '".$Employee->getFullName()."' ".($new ? "Added" : "Edited"), 'status' => 'success'));
		} catch (Exception $exc) {
		    $flashMessenger->addMessage(array('message' => $exc->getMessage(), 'status' => 'error'));
		}
		$this->_redirect('/maintenance/employeesview');
	    }
	    else $form->populate($this->_params);
	}
	$this->view->form = $form;
    }
    
    public function addaddressAction(){
	$em		= $this->_helper->EntityManager();
	$flashMessenger = $this->_helper->getHelper('FlashMessenger');
	
	try {
	    if(!isset($this->_params["id"]))throw new Exception("Can not edit web account. No Id");
	    /* @var $Employee Entities\Employee */
	    $Employee	= $em->find("Entities\Employee", $this->_params["id"]);
	    
	    if(!$Employee)throw new Exception("Can not add address. No Employee with that Id");
	    
	    $form = new Form_PersonAddress_PersonAddress(array("method" => "post"));
	    
	    $form->addElement(
		    "button", 
		    "cancel", 
		    array(
			"label" => "cancel", 
			"onclick" => "location='/maintenance/employeesview/'"
			)
		    );
	} catch (Exception $exc) {
	    $flashMessenger->addMessage(array('message' => $exc->getMessage(), 'status' => 'error'));
	    $this->_redirect('/maintenance/employeesview');
	}
	
	if($this->_request->isPost())
	{
	    if($form->isValid($this->_params))
	    {
		try {
		    $address_params = $this->_params["address"];
		    $PersonAddress = new \Entities\PersonAddress();
		    $PersonAddress->setName($address_params['name']);
		    $PersonAddress->setAddress1($address_params['address_1']);
		    $PersonAddress->setAddress2($address_params['address_2']);
		    $PersonAddress->setCity($address_params['city']);
		    $PersonAddress->setState($address_params['state']);
		    $PersonAddress->setZip1($address_params['zip_1']);
		    $PersonAddress->setZip2($address_params['zip_2']);
		    $Employee->addPersonAddress($PersonAddress);
		    
		    $em->persist($Employee);
		    $em->flush();
		    $flashMessenger->addMessage(
			    array(
				'message' => "Employee Address '".$PersonAddress->getName()."' for '".
						$Employee->getFullName()."' Added", 
				'status' => 'success'
				)
			    );
		} catch (Exception $exc) {
		    $flashMessenger->addMessage(array('message' => $exc->getMessage(), 'status' => 'error'));
		}
		$this->_redirect('/maintenance/employeesview');
	    }
	    else $form->populate($this->_params);
	}
	$this->view->form	= $form;
	$this->view->Employee	= $Employee;
    }
    
    public function editwebaccountAction()
    {
	$em		= $this->_helper->EntityManager();
	$flashMessenger = $this->_helper->getHelper('FlashMessenger');
	$new		= false;
	
	try {
	    if(!isset($this->_params["id"]))throw new Exception("Can not edit web account. No Id");
	    /* @var $Employee Entities\Employee */
	    $Employee	= $em->find("Entities\Employee", $this->_params["id"]);
	    
	    if(!$Employee)throw new Exception("Can not edit web account. No Employee with that Id");
	    /* @var $Webaccount \Entities\Webaccount */
	    $Webaccount = $Employee->getWebAccount();
	    
	    $form = new Form_Webaccount_Webaccount(array("method" => "post"), $Webaccount, false);
	    
	    $form->addElement(
		    "button", 
		    "cancel", 
		    array(
			"label" => "cancel", 
			"onclick" => "location='/maintenance/employeesview'"
			)
		    );
	} catch (Exception $exc) {
	    $flashMessenger->addMessage(array('message' => $exc->getMessage(), 'status' => 'error'));
	    $this->_redirect('/maintenance/employeesview');
	}
	
	if($this->_request->isPost())
	{
	    if($form->isValid($this->_params))
	    {
		try {
		    $new = false;
		    if(!$Webaccount){
			$Webaccount	= new Entities\Webaccount(); 
			$new		= true;
		    }
		    
		    $Webaccount->setUsername($this->_params['webaccount']['username']);
		    $Webaccount->setPassword($this->_params['webaccount']['password']);
		    $Employee->setWebaccount($Webaccount);
		    
		    $em->persist($Employee);
		    $em->flush();
		    $flashMessenger->addMessage(array('message' => "Employee Web Account for '".$Employee->getFullName()."' ".($new ? "Added" : "Edited"), 'status' => 'success'));
		} catch (Exception $exc) {
		    $flashMessenger->addMessage(array('message' => $exc->getMessage(), 'status' => 'error'));
		}
		$this->_redirect('/maintenance/employeesview');
	    }
	    else $form->populate($this->_params);
	}
	$this->view->form	= $form;
	$this->view->Employee	= $Employee;
    }
    
    public function editrolesAction(){
	$this->view->headScript()->appendFile("/javascript/maintenance/employee/employee.js");
	
	if(isset($this->_params["id"])){
	    /* @var $em \Doctrine\ORM\EntityManager */
	    $em			    = $this->_helper->EntityManager();
	    /* @var $Resource \Entities\Employee */
	    $Employee		    = $em->find("\Entities\Employee",$this->_params["id"]); 
	    
	    $this->view->Employee   = $Employee;
	    $this->view->Roles	    = $em->getRepository("Entities\Role")->findAll();
	}
    }
    
    public function employeeaddroleAction(){
	$this->_helper->viewRenderer->setNoRender(true);
	$ACL = new Dataservice_Controller_Plugin_ACL();
	$ACL->preDispatch($this->_request);
	$this->_helper->layout->disableLayout();
	
	$employee_id	= isset($this->_params["employee_id"]) ? $this->_params["employee_id"] : null;
	$role_id	= isset($this->_params["role_id"]) ? $this->_params["role_id"] : null;
	$flashMessenger = $this->_helper->getHelper('FlashMessenger');
	
	if($employee_id && $role_id){
	    /* @var $em \Doctrine\ORM\EntityManager */
	    $em		= $this->_helper->EntityManager();
	    /* @var $Employee \Entities\Employee */
	    $Employee	= $em->find("Entities\Employee", $employee_id);
	    /* @var $Webaccount \Entities\Webaccount */
	    $Webaccount = $Employee->getWebAccount();
	    $Role	= $em->find("Entities\Role", $role_id);
	    if($Webaccount && $Role){
		$Webaccount->addRole($Role);
		$em->persist($Webaccount);
		$em->flush();
		$flashMessenger->addMessage(array('message' => "Role Added", 'status' => 'success'));
		$this->_redirect('/maintenance/editroles/id/'.$Employee->getId());
	    }
	    else{
		$flashMessenger->addMessage(array('message' => "Error Adding Role - WebAccount or Role Not Available", 'status' => 'error'));
		$this->_redirect('/maintenance/employeesview');
	    }
	}
	else{
	    $flashMessenger->addMessage(array('message' => "Error Adding Role - Employee or Role Not Sent", 'status' => 'error'));
	    $this->_redirect('/maintenance/employeesview');
	}
    }
    
    public function employeeremoveroleAction(){
	$this->_helper->viewRenderer->setNoRender(true);
	$ACL = new Dataservice_Controller_Plugin_ACL();
	$ACL->preDispatch($this->_request);
	$this->_helper->layout->disableLayout();
	
	$employee_id	= isset($this->_params["employee_id"]) ? $this->_params["employee_id"] : null;
	$role_id	= isset($this->_params["role_id"]) ? $this->_params["role_id"] : null;
	$flashMessenger = $this->_helper->getHelper('FlashMessenger');
	
	if($employee_id && $role_id){
	    /* @var $em \Doctrine\ORM\EntityManager */
	    $em		= $this->_helper->EntityManager();
	    /* @var $Resource \Entities\Employee */
	    $Employee	= $em->find("Entities\Employee", $employee_id);
	    $Webaccount = $Employee->getWebAccount();
	    if($Webaccount){
		if(!$Webaccount->removeRole($role_id)){
		    $flashMessenger->addMessage(array('message' => "Could Not Remove Role", 'status' => 'error'));
		    $this->_redirect('/maintenance/editroles/id/'.$employee_id);
		}
		$em->persist($Webaccount);
		$em->flush();
		$flashMessenger->addMessage(array('message' => "Role Removed", 'status' => 'success'));
		$this->_redirect('/maintenance/editroles/id/'.$employee_id);
	    }
	    else{
		$flashMessenger->addMessage(array('message' => "Error Removing Role - Resource or Role Not Found", 'status' => 'error'));
		$this->_redirect('/maintenance/editroles/id/'.$employee_id);
	    }
	}
	else{
	    $flashMessenger->addMessage(array('message' => "Error Removing Role - Resource or Role Not Sent", 'status' => 'error'));
	    $this->_redirect('/maintenance/editroles');
	}
    }
}

