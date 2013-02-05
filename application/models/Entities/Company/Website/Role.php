<?php
namespace Entities\Company\Website;

use Doctrine\Common\Collections\ArrayCollection;

/** 
 * @Entity (repositoryClass="Repositories\Company\Website\Role") 
 * @Table(name="company_website_roles")
 * @Crud\Entity\Url(value="website-role")
 * @Crud\Entity\Permissions(view={"Admin"}, edit={"Admin"}, create={"Admin"}, delete={"Admin"})
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
     * @OneToMany(targetEntity="\Entities\Company\Website\Role\Privilege", mappedBy="Role", cascade={"persist"}, orphanRemoval=true)
     * @Crud\Relationship\Permissions()
     * @var ArrayCollection Privileges
     */
    protected $Privileges;
    
    /**
     * @ManytoMany(targetEntity="\Entities\Company\Website\Resource", mappedBy="Roles", cascade={"persist, remove"})
     * @Crud\Relationship\Permissions()
     * @var ArrayCollection $Resources
     */
    protected $Resources;
    
    /**
     * @ManyToMany(targetEntity="\Entities\Company\Website\Account\AccountAbstract", mappedBy="Roles", cascade={"persist"})
     * @Crud\Relationship\Permissions()
     * @var ArrayCollection Accounts
     */
    protected $Accounts;
    
    /**
     * @ManyToOne(targetEntity="\Entities\Company\Website", inversedBy="Resources")
     * @Crud\Relationship\Permissions()
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
     * @param \Entities\Company\Website\Role\Privilege $Privilege
     */
    public function addPrivilege(\Entities\Company\Website\Role\Privilege $Privilege)
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
     * @param \Entities\Company\Website\Resource $Resource
     */
    public function addResource(\Entities\Company\Website\Resource $Resource)
    {
        $this->Resources[] = $Resource;
    }
    
    /**
     * @param \Entities\Company\Website\Resource $Resource
     */
    public function removeResource(\Entities\Company\Website\Resource $Resource)
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
     * @param \Entities\Company\Website\WebsiteAbstract $Website
     */
    public function setWebsite(\Entities\Company\Website\WebsiteAbstract $Website)
    {
	$this->Website = $Website;
    }
    
    /**
     * @return \Entities\Company\Website\WebsiteAbstract
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
    
    public function toString()
    {
	return $this->getName();
    }
    
    public function populate(array $array)
    {
	$Website = $this->_getEntityFromArray($array, "Entities\Company\Website", "website_id");
	
	if($Website)$this->setWebsite($Website);
	
	parent::populate($array);
    }
}