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
use Entities\Person\PersonAbstract as PersonAbstract;

/** 
 * @Entity (repositoryClass="Repositories\Company\Location\Employee") 
 * @Table(name="company_location_employees") 
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
     * @JoinColumn(name="location_id", referencedColumnName="id")
     * @var \Entities\Company\Location $Location
     */
    private $Location;
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="\Entities\Company\Lead\Quote", mappedBy="Employee", cascade={"persist"})
     * @var array $Quotes
     */
    private $Quotes;
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="\Entities\Company\Customer\Order", mappedBy="Employee", cascade={"persist"})
     * @var array $Orders
     */
    private $Orders;
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="\Entities\Company\Lead", mappedBy="Employee", cascade={"persist"})
     * @var array $Leads
     */
    private $Leads;
    
    public function __construct()
    {
	$this->Quotes	= new ArrayCollection();
	$this->Orders	= new ArrayCollection();
	$this->Leads	= new ArrayCollection();
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
     * @param \Entities\Company\Lead\Quote $Quote
     */
    public function AddQuote(\Entities\Company\Lead\Quote $Quote)
    {
	$Quote->setEmployee($this);
	$this->Quotes[] = $Quote;
    }
    
    /**
     * @return array
     */
    public function getQuotes()
    {
	return $this->Quotes;
    }
    
    /**
     * @return array
     */
    public function getOrders()
    {
	return $this->Orders;
    }
    
    /**
     * @param \Entities\Company\Customer\Order $Order
     */
    public function AddOrder(\Entities\Company\Customer\Order $Order)
    {
	$Order->setEmployee($this);
	$this->Orders[] = $Order;
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
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title)
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