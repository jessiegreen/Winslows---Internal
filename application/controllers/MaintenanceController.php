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
	
	$this->view->menu_items = \Services\Menu::factory()->getMenuParentItems("Top");
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
    
    public function locationaddAction(){
	$em		= $this->_helper->EntityManager();
	$flashMessenger = $this->_helper->getHelper('FlashMessenger');
	
	try {
	    if(!isset($this->_params["id"]))throw new Exception("Can not add Location. No Company Id");
	    /* @var $Company Entities\Company */
	    $Company	= $em->find("Entities\Company", $this->_params["id"]);
	    
	    if(!$Company)throw new Exception("Can not add location. No Company with that Id");
	    
	    $form = new Form_Location_Add(array("method" => "post"));
	    
	    $form->addElement(
		    "button", 
		    "cancel", 
		    array(
			"label" => "cancel", 
			"onclick" => "location='/maintenance/locationsview/'"
			)
		    );
	} catch (Exception $exc) {
	    $flashMessenger->addMessage(array('message' => $exc->getMessage(), 'status' => 'error'));
	    $this->_redirect('/maintenance/locationsview');
	}
	
	if($this->_request->isPost())
	{
	    echo "<pre>";print_r($this->_params);echo "</pre>";
	    if($form->isValid($this->_params))
	    {
		try {
		    $location_params	= $this->_params["location"];
		    $address_params	= $this->_params["locationaddress"];	
		    $Location		= new \Entities\Location();
		    $LocationAddress	= new Entities\LocationAddress;
		    
		    $Location->setName($location_params['name']);
		    $Location->setPhone($location_params['phone']);
		    $Location->setType($location_params['type']);
		    
		    $LocationAddress->setName($address_params['name']);
		    $LocationAddress->setCounty($address_params['county']);
		    $LocationAddress->setAddress1($address_params['address_1']);
		    $LocationAddress->setAddress2($address_params['address_2']);
		    $LocationAddress->setCity($address_params['city']);
		    $LocationAddress->setState($address_params['state']);
		    $LocationAddress->setZip1($address_params['zip_1']);
		    $LocationAddress->setZip2($address_params['zip_2']);
		    
		    $Location->setLocationAddress($LocationAddress);
		    
		    $Company->addLocation($Location);
		    
		    $em->persist($Company);
		    $em->flush();
		    $flashMessenger->addMessage(
			    array(
				'message' => "Company Location '".$Location->getName()."' for '".
						$Company->getName()."' Added", 
				'status' => 'success'
				)
			    );
		} catch (Exception $exc) {
		    $flashMessenger->addMessage(array('message' => $exc->getMessage(), 'status' => 'error'));
		}
		$this->_redirect('/maintenance/companiesview');
	    }
	    else $form->populate($this->_params);
	}
	$this->view->form	= $form;
	$this->view->Company	= $Company;
    }
    
    public function companiesviewAction(){
	$this->view->headScript()->appendFile("/javascript/maintenance/navigation/company.js");
	
	$this->view->companies	= Services\Company::factory()->getCompanies();
    }
}

