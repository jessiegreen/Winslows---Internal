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
namespace Entities\Company\Customer;
use Entities\Company\Lead\Quote;
/** 
 * @Entity (repositoryClass="Repositories\Company\Customer\Order") 
 * @Table(name="company_customer_orders") 
 */

class Order extends Quote
{
    /** 
     * @Column(type="datetime", nullable=true) 
     * @var \DateTime $purchased_date
     */
    private $purchased_date;
    
    /** 
     * @ManyToOne(targetEntity="Company\Customer", inversedBy="Orders")
     */     
    private $Customer;
    
    /**
     * @param \DateTime $DateTime
     */
    public function setPurchasedDate(\DateTime $DateTime)
    {
        $this->purchased_date = $DateTime;
    }    
    
    /**
     * @return \DateTime
     */
    public function getPurchasedDate()
    {
	return $this->purchased_date;
    }
    
    /**
     * @param \Entities\Company\Customer $Customer
     */
    public function setCustomer(\Entities\Company\Customer $Customer)
    {
        $this->Customer = $Customer;
    }
    
    /**
     * @return \Entities\Company\Customer
     */
    public function getCustomer()
    {
	return $this->Customer;
    }
    
    /**
     * @param array $array
     */
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
