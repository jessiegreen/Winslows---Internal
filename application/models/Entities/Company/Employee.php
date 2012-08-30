<?php
/**
 * Name:
 * Location:
 *
 * Description for class (if any)...
 *
 * @author     Jessie Green <jessie.winslows@gmail.com>
 * @copyright  2012 Winslows inc.
 * @version    Release: @package_version@
 */
namespace Entities\Company;
use Doctrine\Common\Collections\ArrayCollection;
use Entities\Person\PersonAbstract as PersonAbstract;

/** 
 * @Entity (repositoryClass="Repositories\Company\Employee") 
 * @Table(name="company_employees") 
 */
class Employee extends PersonAbstract
{
    /** 
     * @Column(type="string", length=255) 
     * @var string $title
     */
    private $title;
    
    /**
     * @ManyToOne(targetEntity="\Entities\Company\Location", inversedBy="Employees")
     * @var \Entities\Company\Location $Location
     */
    private $Location;
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="\Entities\Company\Lead", mappedBy="Employee", cascade={"persist"})
     * @var array $Leads
     */
    private $Leads;
    
    /**
     * @ManytoMany(targetEntity="\Entities\Company\Employee\Role", cascade={"persist"})
     * @JoinTable(name="company_employee_role_joins")
     * @var array $Roles
     */
    private $Roles;
    
    /** 
     * @OneToOne(targetEntity="\Entities\Company\Employee\Account", inversedBy="Employee")
     * @var \Entities\Company\Employee\Account
     */     
    private $Account;
    
    public function __construct()
    {
	$this->Leads	= new ArrayCollection();
	$this->Roles	= new ArrayCollection();
	parent::__construct();
    }
    
    /**
     * @return array
     */
    public function getLeads()
    {
	return $this->Leads;
    }
    
    
    /**
     * @param \Entities\Company\Employee\Role $Role
     */
    public function addRole(Employee\Role $Role)
    {
	$Role->addEmployee($this);
        $this->Roles[] = $Role;
    }
    
    /**
     * @param \Entities\Company\Employee\Role $Role
     * @return boolean
     */
    public function removeRole(Employee\Role $Role)
    {
	$this->getRoles()->removeElement($Role);
    }

    /**
     * @return ArrayCollection
     */
    public function getRoles(){
	return $this->Roles;
    }
    
    /**
     * @param \Entities\Company\Employee\Role $Role
     * @return boolean
     */
    public function hasRole($Role)
    {
	if($this->getLeads()->contains($Role))
	    return true;
	
	return false;
    }
    
    /** 
     * @return \Entities\Company\Location
     */
    public function getLocation()
    {
	return $this->Location;
    }
    
    /**
     * @param \Entities\Company\Location $Location
     */
    public function setLocation(\Entities\Company\Location $Location)
    {
	$this->Location = $Location;
    }
    
    /** 
     * @return \Entities\Company\Employee\Account
     */
    public function getAccount()
    {
	return $this->Account;
    }
    
    /**
     * @param \Entities\Company\Employee\Account $Account
     */
    public function setAccount(\Entities\Company\Employee\Account $Account)
    {
	$this->Account = $Account;
    }
    
    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }  
    
    public function populate(array $array)
    {
	foreach ($array as $key => $value) 
	{
	    if(property_exists($this, $key))
	    {
		$this->$key = $value;
	    }
	}
    }
}