<?php
class Dataservice_ACL_Factory {
    private static $_sessionNameSpace = 'Dataservice';
    private static $_objAuth;
    private static $_objAclSession;
    private static $_objAcl;
 
    public static function get(Zend_Auth $objAuth,  \Doctrine\ORM\EntityManager $em, $clearACL=false) {
 
        self::$_objAuth = $objAuth;
	self::$_objAclSession = new Zend_Session_Namespace(self::$_sessionNameSpace);
 
	if($clearACL) {self::_clear();}
 
	    if(isset(self::$_objAclSession->acl)) {
		return self::$_objAclSession->acl;
	    } else {
	        return self::_loadAclFromDB($em);
	    }
	}
 
    private static function _clear() {
        unset(self::$_objAclSession->acl);
    }
 
    private static function _saveAclToSession() {
        self::$_objAclSession->acl = self::$_objAcl;
    }
 
    private static function _loadAclFromDB(\Doctrine\ORM\EntityManager $em) {
        $Roles = $em->getRepository("Entities\Role")->findAll();
 
	self::$_objAcl = new Zend_Acl();
 
	//self::$_objAcl->addRole(new Zend_Acl_Role(Entities_RoleTable::getGuestRoleName()));
	self::$_objAcl->addRole(new Zend_Acl_Role("guest"));
	
	/* @var $Role \Entities\Role */
	foreach($Roles as $Role)
	{
	    self::$_objAcl->addRole(new Zend_Acl_Role($Role->getName()));

	    /* @var $Resource \Entities\Resource */
	    foreach($Role->getResources() as $Resource) {
		self::$_objAcl->add(new Zend_Acl_Resource($Resource->getModule() .'::' .$Resource->getController() .'::' .$Resource->getAction()));
		self::$_objAcl->allow($Role->getName(),$Resource->getModule().'::' .$Resource->getController() .'::' .$Resource->getAction());
	    }
	}
	
	self::_saveAclToSession();
	return self::$_objAcl;
    }
}