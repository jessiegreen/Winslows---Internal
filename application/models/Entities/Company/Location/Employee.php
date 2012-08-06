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
namespace Entities\Company\Location;
use Doctrine\Common\Collections\ArrayCollection;
use Entities\Person as Person;

/** 
 * @Entity (repositoryClass="Repositories\Company\Employee") 
 * @Table(name="company_employees") 
 */
class Employee extends Person
{
    /** 
     * @Column(type="string", length=255) 
     * @var string $title
     */
    private $title;
    
    /**
     * @ManyToOne(targetEntity="Location", inversedBy="Employees")
     * @JoinColumn(name="location_id", referencedColumnName="id")
     * @var \Entities\Company\Location $Location
     */
    private $Location;
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="Quote", mappedBy="Employee", cascade={"persist"})
     */
    private $Quotes;
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="Order", mappedBy="Employee", cascade={"persist"})
     */
    private $Orders;
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="Lead", mappedBy="Employee", cascade={"persist"})
     */
    private $Leads;
    
    public function __construct()
    {
	$this->Quotes	= new ArrayCollection();
	$this->Orders	= new ArrayCollection();
	$this->Leads	= new ArrayCollection();
	parent::__construct();
    }
    
    public function getLeads(){
	return $this->Leads;
    }
    
    public function AddQuote(\Entities\Company\Lead\Quote $Quote)
    {
	$Quote->setEmployee($this);
	$this->Quotes[] = $Quote;
    }
    
    public function getQuotes()
    {
	return $this->Quotes;
    }
    
    public function getOrders()
    {
	return $this->Orders;
    }
    
    public function AddOrder(\Entities\Company\Customer\Order $Order)
    {
	$Order->setEmployee($this);
	$this->Orders[] = $Order;
    }    
    
    public function getLocation()
    {
	return $this->Location;
    }
    
    public function setLocation(\Entities\Company\Location $Location)
    {
	$this->Location = $Location;
    }
    
    public function getTitle()
    {
        return $this->title;
    }

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