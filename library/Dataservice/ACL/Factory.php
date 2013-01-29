<?php
class Dataservice_ACL_Factory 
{
    private static $_sessionNameSpace = 'Dataservice';
    private static $_objAclSession;
    /**
     * @var Zend_Acl $_objAcl
     */
    private static $_objAcl;
    //TODO: Create easy way to switch clearAcl manually so we can use the session but clear easily when needed. 
    // Also need to do it at login etc
    public static function get(\Entities\Company\Website\WebsiteAbstract $Website, $clearACL = true)
    {
	self::$_objAclSession = new Zend_Session_Namespace(self::$_sessionNameSpace);
 
	if($clearACL) {self::_clear();}
 
	if(isset(self::$_objAclSession->acl))
	{
	    return self::$_objAclSession->acl;
	} 
	else
	{
	    return self::_loadAclFromDB($Website);
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
 
    private static function _loadAclFromDB(\Entities\Company\Website\WebsiteAbstract $Website)
    {
        $Roles = $Website->getRoles();
	
	self::$_objAcl = new Zend_Acl();
	
	foreach($Website->getResources() as $Resource)
	{
	    $url_key = $Resource->getModule() .'::' .$Resource->getController() .'::' .$Resource->getAction();
	    
	    if(!self::$_objAcl->has($url_key))
	    {
		self::$_objAcl->add(new Zend_Acl_Resource($url_key));
	    }
	}
	
	/* @var $Role \Entities\Company\Employee\Role */
	foreach($Roles as $Role)
	{	    
	    self::$_objAcl->addRole(new Zend_Acl_Role($Role->getName()));
	    
	    /* @var $Resource \Entities\Company\Website\Resource */
	    foreach($Role->getResources() as $Resource)
	    {
		$url_key = $Resource->getModule() .'::' .$Resource->getController() .'::' .$Resource->getAction();
		
		if(!self::$_objAcl->has($url_key))
		{
		    self::$_objAcl->add(new Zend_Acl_Resource($url_key));
		}
		
		self::$_objAcl->allow($Role->getName(), $url_key);
	    }
	}
	
	self::_saveAclToSession();
	
	return self::$_objAcl;
    }
}