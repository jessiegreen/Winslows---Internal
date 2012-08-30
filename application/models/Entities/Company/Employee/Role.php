<?php
namespace Entities\Company\Website\Account;
use Doctrine\Common\Collections\ArrayCollection;

/** 
 * @Entity (repositoryClass="Repositories\Company\Employee\Role") 
 * @Table(name="company_employee_roles") 
 * @HasLifecycleCallbacks
 */
class Role extends \Dataservice_Doctrine_Entity
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     * @var integer $id
     */
    private $id;

    /** 
     * @Column(type="string", length=255) 
     * @var string $name
     */
    private $name;
    
    /** 
     * @Column(type="string", length=2000) 
     * @var string $description
     */
    private $description;
    
    /**
     * @OneToMany(targetEntity="\Entities\Company\Employee\Role\Privilege", mappedBy="Role", cascade={"persist"}, orphanRemoval=true)
     * @var array Privileges
     */
    private $Privileges;
    
    /**
     * @ManytoMany(targetEntity="\Entities\Company\Website\Resource", inversedBy="Roles", cascade={"persist"})
     * @JoinTable(name="company_employee_role_resource_joins")
     * @var array $Resources
     */
    private $Resources;
    
    /**
     * @ManytoMany(targetEntity="\Entities\Company\Employee", mappedBy="Roles", cascade={"persist"})
     * @var array $Employees
     */
    private $Employees;
    
    public function __construct()
    {
	$this->Privileges   = new ArrayCollection();
	$this->Resources    = new ArrayCollection();
	$this->Employees    = new ArrayCollection();
    }
    
    /**
     * @param \Entities\Company\Website\Account\Role\Privilege $Privilege
     */
    public function addPrivilege(Role\Privilege $Privilege)
    {
	$Privilege->setRole($this);
        $this->Privileges[] = $Privilege;
    }
    
    /**
     * @param \Entities\Company\Employee $Employee
     */
    public function addEmployee(\Entities\Company\Employee $Employee)
    {
        $this->Employees[] = $Employee;
    }
    
    /**
     * @return ArrayCollection
     */
    public function getEmployees()
    {
	return $this->Employees;
    }
    
    /**
     * @param \Entities\Company\Employee $Employee
     */
    public function removeEmployee(\Entities\Company\Employee $Employee)
    {
	$Employee->removeRole($this);
	$this->Employees->removeElement($Employee);
    }

    /**
     * @return array
     */
    public function getPrivileges(){
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
	$Resource->removeRole($this);
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

    public function populate(array $array){
	foreach ($array as $key => $value) {
	    if(property_exists($this, $key)){
		$this->$key = $value;
	    }
	}
    }
}