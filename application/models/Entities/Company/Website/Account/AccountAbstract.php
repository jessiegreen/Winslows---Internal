<?php
namespace Entities\Company\Website\Account;

use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
/** 
 * @Entity (repositoryClass="Repositories\Company\Website\Account\AccountAbstract") 
 * @Table(name="company_website_account_accountabstracts") 
 * @InheritanceType("JOINED")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({
 *			"company_employee_account" = "\Entities\Company\Employee\Account",
 * 			"company_lead_account" = "\Entities\Company\Lead\Account",
 *			"company_website_guest_account" = "\Entities\Company\Website\Guest\Account"
 *		    })
 * @HasLifecycleCallbacks
 * @Crud\Entity\Url(value="")
 * @Crud\Entity\Permissions()
 */
abstract class AccountAbstract extends \Dataservice_Doctrine_Entity implements \Interfaces\Company\Website\Account
{
    const TYPE_Employee	    = "Employee";
    const TYPE_Lead	    = "Lead";
    const TYPE_Guest	    = "Guest";
    
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     * @var integer
     */
    protected $id;

    /** 
     * @Column(type="string", length=255) 
     * @var string $username
     */
    protected $username;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $password
     */
    protected $password;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $salt
     */
    protected $salt;
    
    /**
     * @ManyToOne(targetEntity="\Entities\Company\Website", inversedBy="Accounts")
     * @Crud\Relationship\Permissions()
     * @var \Entities\Company\Website
     */
    protected $Website;
    
    /**
     * @ManytoMany(targetEntity="\Entities\Company\Website\Role", cascade={"persist"})
     * @JoinTable(name="company_website_account_role_joins")
     * @Crud\Relationship\Permissions(add={"Admin"}, remove={"Admin"})
     * @var ArrayCollection $Roles
     */
    protected $Roles;
    
    public function __construct()
    {
	$this->Roles = new ArrayCollection();
	
	parent::__construct();
    }
    
    /**
     * @param \Entities\Company\Website\Guest\Role $Role
     */
    public function addRole(\Entities\Company\Website\Role $Role)
    {
	if($Role->getWebsite() === $this->getWebsite())
	{
	    $Role->addAccount($this);
	    
	    $this->Roles[] = $Role;
	}
	else throw new \Exception("Role does not belong to this website");
    }
    
    /**
     * @param \Entities\Company\Website\Guest\Role $Role
     */
    public function removeRole(Guest\Role $Role)
    {
	$this->getRoles()->removeElement($Role);
    }

    /**
     * @return ArrayCollection
     */
    public function getRoles()
    {
	return $this->Roles;
    }
    
    /**
     * @param \Entities\Company\Website\Guest\Role $Role
     * @return boolean
     */
    public function hasRole($Role)
    {
	if($this->getRoles()->contains($Role))
	    return true;
	
	return false;
    }
    
    /**
     * @param string $name
     * @return boolean
     */
    public function hasRoleByRoleName($name)
    {
	foreach ($this->getRoles() as $Role)
	{
	    if($Role->getName() == $name)return true;
	}
	
	return false;
    }
    
    /**
     * @param array $name
     * @return boolean
     */
    public function hasRoleByRoleNames($name_array)
    {
	if(!$name_array || empty($name_array))return false;
	
	foreach ($this->getRoles() as $Role)
	{
	    if(in_array($Role->getName(),$name_array))return true;
	}
	
	return false;
    }
    
    /**
     * @param \Entities\Company\Website $Website
     */
    public function setWebsite(\Entities\Company\Website $Website)
    {
	$this->Website = $Website;
    }
    
    /**
     * @return \Entities\Company\Website
     */
    public function getWebsite()
    {
	return $this->Website;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }
    
    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
	$this->_setSalt(sha1(rand(5, 20000)));
	
        $this->password = sha1($password.$this->salt);
    }
    
    /**
     * @param string $salt
     */
    private function _setSalt($salt)
    {
	$this->salt = $salt;
    }
    
    /**
     * @return string
     */
    public function getSalt()
    {
	return $this->salt;
    }
    
    /**
     * @return bool
     */
    public function isGuestAccount()
    {
	return $this->getDescriminator() == self::TYPE_Guest ? true : false;
    }
    
    /**
     * @return bool
     */
    public function isEmployeeAccount()
    {
	return $this->getDescriminator() == self::TYPE_Employee ? true : false;
    }
    
    /**
     * @return bool
     */
    public function isLeadAccount()
    {
	return $this->getDescriminator() == self::TYPE_Lead ? true : false;
    }
    
    /**
     * @param array $route_array
     * @param \Zend_Acl $Acl
     * @return boolean
     * @throws \Exception
     */
    public function isAllowedToAccessRouteArray($route_array, \Zend_Acl $Acl)
    {
	if(
	    !isset($route_array["module"]) ||
	    !isset($route_array["controller"]) || 
	    !isset($route_array["action"])
	)
	    throw new \Exception("Array passed to isAllowedToAccessRouteArray is missing required parameter");
	
	return $this->isAllowedToAccessRoute(
		    $route_array["module"], 
		    $route_array["controller"], 
		    $route_array["action"], $Acl
		);
    }
    
    /**
     * 
     * @param \Zend_Controller_Request_Abstract $Request
     * @param \Zend_Acl $Acl
     * @return boolean
     */
    public function isAllowedToAccessRequest(\Zend_Controller_Request_Abstract $Request, \Zend_Acl $Acl)
    {
	return $this->isAllowedToAccessRoute(
		    $Request->getModuleName(),
		    $Request->getControllerName(),
		    $Request->getActionName(), 
		    $Acl
		);
    }
    
    /**
     * @param string $module
     * @param string $controller
     * @param string $action
     * @param \Zend_Acl $Acl
     * @return boolean
     */
    public function isAllowedToAccessRoute($module, $controller, $action, \Zend_Acl $Acl)
    {
	$AllowedRoles = $this->getRoles()->filter(
		    function ($Role) use ($module, $controller, $action, $Acl)
		    {
			$allowed = false;
			
			try 
			{
			    $allowed = $Acl->isAllowed(
					    $Role->getName(), 
					    $module.'::'.$controller.'::'.$action
					) ? 
					true : false;
			} 
			catch (\Exception $exc)
			{
			    //TODO: Handle this better
			    echo $exc->getMessage();
			}
			
			return $allowed;
		    }
		);
		
	return $AllowedRoles->count() > 0 ? true : false;
    }
    
    /**
     * @return string
     */
    public function getDescriminator()
    {
	return null;
    }
    
    public function populate(array $array) 
    {
	$Website = $this->_getEntityFromArray($array, "Entities\Company\Website", "website_id");
	
	if($Website)$this->setWebsite($Website);
	
	parent::populate($array);
	
	if(isset($array["password"]) && $array["password"])
	{
	    $this->setPassword($array["password"]);
	}
    }
}
