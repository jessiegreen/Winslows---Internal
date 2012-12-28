<?php

namespace Entities\Website;
use Doctrine\Common\Collections\ArrayCollection;

/** 
 * @Entity (repositoryClass="Repositories\Website\WebsiteAbstract") 
 * @Table(name="website_websiteabstracts") 
 * @InheritanceType("JOINED")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({"company_website" = "\Entities\Company\Website"})
 * @HasLifecycleCallbacks
 */
class WebsiteAbstract extends \Dataservice_Doctrine_Entity
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     * @var integer $id
     */
    protected $id;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $name
     */
    protected $name;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $name_index
     */
    protected $name_index;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $type
     */
    protected $type;

    /** 
     * @Column(type="string", length=255) 
     * @var string $url
     */
    protected $url;
    
    /** 
     * @Column(type="integer", length=1) 
     * @var string $guest_allowed
     */
    protected $guest_allowed = 0;
    
    /**
     * @OneToMany(targetEntity="\Entities\Website\Account\AccountAbstract", mappedBy="Website", cascade={"persist"})
     * @var ArrayCollection $Accounts
     */
    protected $Accounts;
    
    /**
     * @OneToMany(targetEntity="\Entities\Website\Resource", mappedBy="Website", cascade={"persist"})
     * @var ArrayCollection $Resources
     */
    protected $Resources;
    
    /**
     * @OneToMany(targetEntity="\Entities\Website\Menu", mappedBy="Website", cascade={"persist"})
     * @var ArrayCollection $Menus
     */
    protected $Menus;
    
    /**
     * @OneToMany(targetEntity="\Entities\Website\Role", mappedBy="Website", cascade={"persist"})
     * @var ArrayCollection $Roles
     */
    protected $Roles;
    
    public function __construct()
    {
	$this->Accounts	    = new ArrayCollection();
	$this->Resources    = new ArrayCollection();
	$this->Roles	    = new ArrayCollection();
	$this->Menus	    = new ArrayCollection();
	
	parent::__construct();
    }
    
    /**
     * @param \Entities\Website\Account\AccountAbstract $Account
     */
    public function addAccount(\Entities\Website\Account\AccountAbstract $Account)
    {
	$Account->setWebsite($this);
	
        $this->Accounts[] = $Account;
    }
    
    /**
     * @return ArrayCollection
     */
    public function getAccounts()
    {
	return $this->Accounts;
    }
    
    /**
     * @return false|\Services\Website\Guest\Account
     */
    public function getGuestAccount()
    {
	$GuestAccounts = $this->getAccounts()->filter(
		    function ($Account)
		    {
			return $Account->isGuestAccount();
		    }
		);
		
	return $GuestAccounts->count() > 0 ? $GuestAccounts->first() : false;
    }
    
    /**
     * @param \Zend_Auth $Auth Instance of Zend_Auth
     * @return false|Entities\Website\Account\AccountAbstract
     */
    public function getCurrentUserAccount(\Zend_Auth $Auth)
    {
	return $this->getAccountById($Auth->getIdentity());
    }
    
    /**
     * @param integer|float|string $id
     * @return false|Account\AccountAbstract
     */
    public function getAccountById($id)
    {
	$MatchedAccount = $this->getAccounts()->filter(
		    function ($Account) use ($id)
		    {
			return $Account->getId() === $id ? true : false;
		    }
		);
		
	return $MatchedAccount->count() > 0 ? $MatchedAccount->first() : false;
    }
    
    /**
     * @param \Entities\Website\Resource $Resource
     */
    public function addResource(\Entities\Website\Resource $Resource)
    {
	$Resource->setWebsite($this);
	
        $this->Resources[] = $Resource;
    }
    
    /**
     * @return ArrayCollection
     */
    public function getResources()
    {
	return $this->Resources;
    }
    
    /**
     * @param \Entities\Website\Resource $Resource
     * @return boolean
     */
    public function removeResource(Website\Resource $Resource)
    {
	$this->getResources()->removeElement($Resource);
    }
    
    /**
     * @param \Entities\Website\Role $Role
     */
    public function addRole(\Entities\Website\Role $Role)
    {
	$Role->setWebsite($this);
	
        $this->Roles[] = $Role;
    }
    
    /**
     * @return ArrayCollection
     */
    public function getRoles()
    {
	return $this->Roles;
    }
    
    /**
     * @param \Entities\Website\Role $Role
     * @return boolean
     */
    public function removeRole(\Entities\Website\Role $Role)
    {
	$this->getResources()->removeElement($Role);
    }
    
    /**
     * @param \Entities\Website\Menu $Menu
     */
    public function addMenu(\Entities\Website\Menu $Menu)
    {
	$Menu->setWebsite($this);
	
        $this->Menus[] = $Menu;
    }
    
    /**
     * @return ArrayCollection
     */
    public function getMenus()
    {
	return $this->Menus;
    }
    
    /**
     * @param type $index
     * @return false|\Entities\Website\Menu
     */
    public function getMenuByIndex($index)
    {
	$MatchedMenus = $this->getMenus()->filter(
		    function ($Menu) use ($index)
		    {
			return $Menu->getNameIndex() == $index ? true : false;
		    }
		);
		
	if($MatchedMenus->count() > 0)
	    return $MatchedMenus->first();
	
	return false;
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    
    /**
     * @return string
     */
    public function getNameIndex()
    {
        return $this->name_index;
    }

    /**
     * @param string $name_index
     */
    public function setNameIndex($name_index)
    {
        $this->name_index = $name_index;
    }
    
    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }
    
    /**
     * @return bool
     */
    public function isGuestAllowed()
    {
        return $this->guest_allowed === 1 ? true : false;
    }

    /**
     * @param integer $guest_allowed
     */
    public function setGuestAllowed($guest_allowed)
    {
        $this->guest_allowed = $guest_allowed;
    }
    
    /**
     * @return int
     */
    public function getGuestAllowed()
    {
	return $this->guest_allowed;
    }
    
    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @throws \Exception
     */
    public function setType($type)
    {
	if(!key_exists($type, $this->getTypeOptions()))
	    throw new \Exception("Type option of ".htmlspecialchars ($type)." does not exist");
	
        $this->type = $type;
    }
    
    /**
     * @param string $type
     * @return string
     * @throws \Exception
     */
    public function getTypeDisplay($type = null)
    {
	if($type === null)
	{
	    $type = $this->type; 
	}
	
	if(!$type)return "";
	
	$array = $this->getTypeOptions();
	
	if(!key_exists($type, $array))
	    throw new \Exception("Could not get Type Display. Key '".$type."' does not exist");
	
	return $array[$type];
    }
    
    /**
     * @return array
     */
    public function getTypeOptions()
    {
	return array(
	    "sales"	    => "Sales",
	    "management"    => "Management"
	);
    }
}