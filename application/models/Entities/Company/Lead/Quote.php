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
namespace Entities\Company\Lead;
use Doctrine\Common\Collections\ArrayCollection;

/** 
 * @Entity (repositoryClass="Repositories\Company\Lead\Quote") 
 * @Table(name="company_lead_quotes") 
 */

class Quote extends Quote\QuoteAbstract
{    
    /** 
     * @ManyToOne(targetEntity="\Entities\Company\Lead", inversedBy="Quotes")
     * @var \Entities\Company\Lead $Lead
     */     
    private $Lead;
    
    /** 
     * @ManyToOne(targetEntity="\Entities\Company\Location\Employee", inversedBy="Quotes")
     * @var \Entities\Company\Location\Employee $Employee 
     */     
    private $Employee;
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="\Entities\Company\Lead\Quote\Item", mappedBy="Quote", cascade={"persist"})
     * @var array $Items
     */
    private $Items;
    
    public function __construct()
    {
	$this->Items = new ArrayCollection();
	parent::__construct();
    }
    
    /**
     * @param \Entities\Company\Lead\Quote\Item $Item
     */
    public function addItem(Quote\Item $Item)
    {
	$Item->setQuote($this);
        $this->Items[] = $Item;
    }
    
    /**
     * @return array
     */
    public function getItems()
    {
	return $this->Items;
    }
    
    /**
     * @param \Entities\Company\Lead $Lead
     */
    public function setLead(\Entities\Company\Lead $Lead)
    {
        $this->Lead = $Lead;
    }
    
    /**
     * @return \Entities\Company\Lead
     */
    public function getLead()
    {
	return $this->Lead;
    }
    
    /**
     * @param \Entities\Company\Location\Employee $Employee
     */
    public function setEmployee(\Entities\Company\Location\Employee $Employee)
    {
        $this->Employee = $Employee;
    }
    
    /**
     * @return \Entities\Company\Location\Employee
     */
    public function getEmployee()
    {
	return $this->Employee;
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
