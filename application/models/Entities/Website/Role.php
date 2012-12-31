<?php
namespace Entities\Website;
use Doctrine\Common\Collections\ArrayCollection;

/** 
 * @Entity (repositoryClass="Repositories\Website\Role") 
 * @Table(name="website_roles")
 */
class Role extends \Dataservice_Doctrine_Entity
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
     * @Column(type="string", length=2000) 
     * @var string $description
     */
    protected $description;
    
    /**
     * @OneToMany(targetEntity="\Entities\Website\Role\Privilege", mappedBy="Role", cascade={"persist"}, orphanRemoval=true)
     * @var ArrayCollection Privileges
     */
    protected $Privileges;
    
    /**
     * @ManytoMany(targetEntity="\Entities\Website\Resource", mappedBy="Roles", cascade={"persist, remove"})
     * @var ArrayCollection $Resources
     */
    protected $Resources;
    
    /**
     * @ManyToMany(targetEntity="\Entities\Website\Account\AccountAbstract", mappedBy="Roles", cascade={"persist"})
     * @var ArrayCollection Accounts
     */
    protected $Accounts;
    
    /**
     * @ManyToOne(targetEntity="\Entities\Website\WebsiteAbstract", inversedBy="Resources")
     * @var \Entities\Company\Website
     */
    protected $Website;
    
    public function __construct()
    {
	$this->Privileges   = new ArrayCollection();
	$this->Resources    = new ArrayCollection();
	$this->Accounts	    = new ArrayCollection();
	
	parent::__construct();
    }
    
    /**
     * @param \Entities\Website\Role\Privilege $Privilege
     */
    public function addPrivilege(\Entities\Website\Role\Privilege $Privilege)
    {
	$Privilege->setRole($this);
	
        $this->Privileges[] = $Privilege;
    }

    /**
     * @return array
     */
    public function getPrivileges()
    {
	return $this->Privileges;
    }
    
    /**
     * @param \Entities\Website\Resource $Resource
     */
    public function addResource(\Entities\Website\Resource $Resource)
    {
        $this->Resources[] = $Resource;
    }
    
    /**
     * @param \Entities\Website\Resource $Resource
     */
    public function removeResource(\Entities\Website\Resource $Resource)
    {
	$this->getResources()->removeElement($Resource);
    }
    
    /**
     * @return array
     */
    public function getResources()
    {
	return $this->Resources;
    }
    
    /**
     * @param Account\AccountAbstract $Account
     */
    public function addAccount(Account\AccountAbstract $Account)
    {
        $this->getAccounts()->add($Account);
    }
    
    /**
     * @param Account\AccountAbstract $Account
     */
    public function removeAccount(Account\AccountAbstract $Account)
    {
	$this->getAccounts()->removeElement($Account);
    }
    
    /**
     * @return ArrayCollection
     */
    public function getAccounts()
    {
	return $this->Accounts;
    }
    
    /**
     * @param \Entities\Website\WebsiteAbstract $Website
     */
    public function setWebsite(\Entities\Website\WebsiteAbstract $Website)
    {
	$this->Website = $Website;
    }
    
    /**
     * @return \Entities\Website\WebsiteAbstract
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
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }
}