<?php
namespace Entities\Company;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity (repositoryClass="Repositories\Company\Location") 
 * @Table(name="company_locations")
 * @Crud\Entity\Url(value="location")
 * @Crud\Entity\Permissions(view={"Admin"}, edit={"Admin"}, create={"Admin"}, delete={"Admin"})
 * @HasLifecycleCallbacks
 */
class Location extends \Entities\Company\Location\LocationAbstract
{
    /** 
     * @ManyToOne(targetEntity="\Entities\Company", inversedBy="Locations")
     * @Crud\Relationship\Permissions()
     * @var \Entities\Company
     */     
    protected $Company;
    
    /**
     * @OneToOne(targetEntity="\Entities\Company\Location\Address", mappedBy="Location", cascade={"persist"}, orphanRemoval=true)
     * @Crud\Relationship\Permissions(add={"Admin"}, remove={"Admin"})
     * @var Entities\Company\Location\Address $Address
     */
    protected $Address;
    
    /**
     * @OneToOne(targetEntity="\Entities\Company\Location\PhoneNumber", mappedBy="Location", cascade={"persist"}, orphanRemoval=true)
     * @Crud\Relationship\Permissions(add={"Admin"}, remove={"Admin"})
     * @var \Entities\Company\Location\PhoneNumber $PhoneNumber
     */
    protected $PhoneNumber;
    
    /**
     * @OneToOne(targetEntity="\Entities\Company\Location\FaxNumber", mappedBy="Location", cascade={"persist"}, orphanRemoval=true)
     * @Crud\Relationship\Permissions(add={"Admin"}, remove={"Admin"})
     * @var \Entities\Company\Location\FaxNumber $FaxNumber
     */
    protected $FaxNumber;
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="\Entities\Company\Employee", mappedBy="Location", cascade={"persist"})
     * @Crud\Relationship\Permissions()
     * @var ArrayCollection $Employees
     */
    protected $Employees;
    
    public function __construct()
    {
	$this->Employees = new ArrayCollection();
	
	parent::__construct();
    }
    
    /**
     * @return \Entities\Company
     */
    public function getCompany()
    {
	return $this->Company;
    }
    
    /**
     * @param \Entities\Company $Company
     */
    public function setCompany(\Entities\Company $Company)
    {
	$this->Company = $Company;
    }
    
    /**
     * @param \Entities\Company\Employee $Employee
     */
    public function addEmployee(\Entities\Company\Employee $Employee)
    {
	$Employee->setLocation($this);
	
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
     * @param \Entities\Company\Location\PhoneNumber $PhoneNumber
     */
    public function setPhoneNumber(\Entities\Company\Location\PhoneNumber $PhoneNumber)
    {
	$PhoneNumber->setLocation($this);
	
        $this->PhoneNumber = $PhoneNumber;
    }
    
    /**
     * @return \Entities\Company\Location\PhoneNumber
     */
    public function getPhoneNumber()
    {
        return $this->PhoneNumber;
    }
    
    /**
     * @param \Entities\Company\Location\FaxNumber $FaxNumber
     */
    public function setFaxNumber(\Entities\Company\Location\FaxNumber $FaxNumber)
    {
	$FaxNumber->setLocation($this);
	
        $this->FaxNumber = $FaxNumber;
    }
    
    /**
     * @return \Entities\Company\Location\FaxNumber
     */
    public function getFaxNumber()
    {
        return $this->FaxNumber;
    }

    /**
     * @param \Entities\Company\Location\Address $Address
     */
    public function setAddress(\Entities\Company\Location\Address $Address)
    {
	$Address->setLocation($this);
	
        $this->Address = $Address;
    }
    
    /**
     * @return \Entities\Company\Location\Address
     */
    public function getAddress()
    {
        return $this->Address;
    }
    
    public function populate(array $array)
    {
	$Company = $this->_getEntityFromArray($array, "Entities\Company", "company_id");
	
	if($Company && $Company->getId())
	    $this->setCompany($Company);
	
	parent::populate($array);
    }
}