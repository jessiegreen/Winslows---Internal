<?php
class Dataservice_ACL_Factory 
{
    private static $_sessionNameSpace = 'Dataservice';
    private static $_objAclSession;
    /**
     * @var Zend_Acl $_objAcl
     */
    private static $_objAcl;
    private static $_debug = false;
 
    public static function get(\Doctrine\ORM\EntityManager $em, $clearACL=true)
    {
	self::$_objAclSession = new Zend_Session_Namespace(self::$_sessionNameSpace);
 
	if($clearACL) {self::_clear();}
 
	if(isset(self::$_objAclSession->acl))
	{
	    return self::$_objAclSession->acl;
	} 
	else
	{
	    return self::_loadAclFromDB($em);
	}
    }
 
    private static function _clear()
    {
        unset(self::$_objAclSession->acl);
    }
 
    private static function _saveAclToSession()
    {
        self::$_objAclSession->acl = self::$_objAcl;
    }
 
    private static function _loadAclFromDB(\Doctrine\ORM\EntityManager $em)
    {
        $Roles = $em->getRepository("Entities\Role\RoleAbstract")->findAll();
	
	self::$_objAcl = new Zend_Acl();
 
	//self::$_objAcl->addRole(new Zend_Acl_Role(Entities\Company\Employee\Role::getGuestRoleName()));
	//self::$_objAcl->addRole(new Zend_Acl_Role("Guest"));
	
	/* @var $Role \Entities\Company\Employee\Role */
	foreach($Roles as $Role)
	{
	    if(self::$_debug)echo $Role->getName()."-<ul> ";
	    
	    self::$_objAcl->addRole(new Zend_Acl_Role($Role->getName()));

	    /* @var $Resource \Entities\Company\Website\Resource */
	    foreach($Role->getResources() as $Resource)
	    {
		$url_key = $Resource->getModule() .'::' .$Resource->getController() .'::' .$Resource->getAction();
		
		if(!self::$_objAcl->has($url_key))
		{
		    self::$_objAcl->add(new Zend_Acl_Resource($url_key));
		}
		
		if(self::$_debug)echo "<li>".$url_key."</li>";
		
		self::$_objAcl->allow($Role->getName(), $url_key);
	    }
	    
	    if(self::$_debug)echo "</ul>";
	}
	
	self::_saveAclToSession();
	
	return self::$_objAcl;
    }
}