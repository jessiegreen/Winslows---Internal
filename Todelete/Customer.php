<?php
namespace Entities\Company;

/** 
 * @Entity (repositoryClass="Repositories\Company\Customer") 
 * @Table(name="company_customers") 
 */
class Customer extends \Entities\Company\Lead
{
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="\Entities\Company\Customer\Order", mappedBy="Customer", cascade={"persist"})
     * @var array $Orders
     */
    protected $Orders;
    
    public function __construct()
    {
	$this->Orders = new ArrayCollection();
	parent::__construct();
    }
    
    /**
     * @param \Entities\Company\Customer\Order $Order
     */
    public function AddOrder(Customer\Order $Order)
    {
	$Order->setCustomer($this);
	$this->Orders[] = $Order;
    }
    
    /**
     * @return array
     */
    public function getOrders()
    {
	return $this->Orders;
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