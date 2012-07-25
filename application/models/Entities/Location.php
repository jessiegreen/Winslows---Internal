<?php

namespace Entities;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity (repositoryClass="Repositories\Location") 
 * @Table(name="locations")
 * @HasLifecycleCallbacks
 */
class Location
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /** @Column(type="string", length=255) */
    private $name;
    
    /** @Column(type="string", length=255) */
    private $type;

    /**
     * @OneToOne(targetEntity="LocationAddress", mappedBy="Location", cascade={"persist"}, orphanRemoval=true)
     */
    protected $LocationAddress;
    
    /**
     * @OneToOne(targetEntity="LocationPhoneNumber", mappedBy="Location", cascade={"persist"}, orphanRemoval=true)
     */
    protected $LocationPhoneNumber;
    
    /** 
     * @ManyToOne(targetEntity="Company", inversedBy="locations")
     */     
    private $Company;
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="Employee", mappedBy="Location", cascade={"persist"})
     */
    private $Employees;
    
    public function __construct()
    {
	$this->Employees = new ArrayCollection();
    }
    
    public function getCompany(){
	return $this->Company;
    }
    
    public function setCompany(Company $Company){
	$this->Company = $Company;
    }
    
    /**
     * Add Employee to Location.
     * @param Employee $Employee
     */
    public function addEmployee(Employee $Employee)
    {
	$Employee->setLocation($this);
        $this->Employees[] = $Employee;
    }
    
    /**
     * Retrieve location's associated employees.
     */
    public function getEmployees()
    {
	return $this->Employees;
    }

    public function getId()
    {
        return $this->id;
    }
    
    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
    
    public function setLocationPhoneNumber(LocationPhoneNumber $LocationPhoneNumber)
    {
	$LocationPhoneNumber->setLocation($this);
        $this->LocationPhoneNumber = $LocationPhoneNumber;
    }
    
    public function getLocationPhoneNumber()
    {
        return $this->LocationPhoneNumber;
    }

    public function setLocationAddress(LocationAddress $LocationAddress)
    {
	$LocationAddress->setLocation($this);
        $this->LocationAddress = $LocationAddress;
    }
    
    public function getLocationAddress()
    {
        return $this->LocationAddress;
    }
    
    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
	if(!key_exists($type, $this->getTypeOptions()))
	    throw new Exception("Type option of ".htmlspecialchars ($type)." does not exist");
        $this->type = $type;
    }
    
    public function getTypeDisplay($type = null){
	if($type === null){
	    $type = $this->type; 
	}
	if(!$type)return "";
	$array = $this->getTypeOptions();
	if(!key_exists($type, $array))
	    throw new Exception("Could not get Type Display. Key '".$type."' does not exist");
	return $array[$type];
    }
    
    public function getTypeOptions(){
	return array(
	    "sales" => "Sales",
	);
    }
    
    public function populate(array $array){
	foreach ($array as $key => $value) {
	    if(property_exists($this, $key)){
		$this->$key = $value;
	    }
	}
    }
}