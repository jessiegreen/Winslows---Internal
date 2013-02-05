<?php
namespace Entities\Company\TimeClock;

/** 
 * @Entity (repositoryClass="Repositories\Company\TimeClock\Entry") 
 * @Table(name="company_timeclock_items") 
 * @HasLifecycleCallbacks
 * @Crud\Entity\Url(value="time-clock-entry")
 * @Crud\Entity\Permissions(view={"Admin"}, edit={"Admin"}, create={"Admin"}, delete={"Admin"})
 */
class Entry extends \Dataservice_Doctrine_Entity
{    
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     * @var integer $id
     */
    protected $id;
    
    /** 
     * @Column(type="datetime") 
     * @var \DateTime $updated
     */
    protected $datetime;
    
    /**
     * @Column(type="string", length=32, unique=false, nullable=false)
     * @var ip_address
     */
    protected $ip_address;
    
    /** 
     * @ManyToOne(targetEntity="\Entities\Company\TimeClock", inversedBy="Entries", cascade="persist")
     * @Crud\Relationship\Permissions()
     * @var \Entities\Company\TimeClock $TimeClock
     */
    protected $TimeClock;
    
    /** 
     * @ManyToOne(targetEntity="\Entities\Company\Employee", inversedBy="TimeClockEntries", cascade="persist")
     * @Crud\Relationship\Permissions(add={"Admin"}, remove={"Admin"})
     * @var \Entities\Company\Employee $Employee
     */
    protected $Employee;
    
    /**
     * @param \Entities\Company\TimeClock $TimeClock
     */
    public function setTimeClock(\Entities\Company\TimeClock $TimeClock)
    {
	$this->TimeClock = $TimeClock;
    }
    
    /**
     * @return \Entities\Company\TimeClock
     */
    public function getTimeClock()
    {
	return $this->TimeClock;
    }
    
    /**
     * @return \Entities\Company\Employee
     */
    public function getEmployee()
    {
        return $this->Employee;
    }

    /**
     * @param \Entities\Company\Employee $Employee
     */
    public function setEmployee(\Entities\Company\Employee $Employee)
    {
        $this->Employee = $Employee;
    }
    
    /**
     * @return \Dataservice\DateTime
     */
    public function getDateTime()
    {
        return $this->datetime;
    }

    /**
     * @param \DateTime $DateTime
     */
    public function setDateTime(\DateTime $DateTime)
    {
        $this->datetime = $DateTime;
    }
    
    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @param string $ip_address
     */
    public function setIpAddress($ip_address)
    {
	$this->ip_address = $ip_address;
    }
    
    /**
     * @return string
     */
    public function getIpAddress()
    {
	return $this->ip_address;
    }
    
    public function toString()
    {
	return $this->getEmployee()->getFirstName()." ".$this->getEmployee()->getLastName()." - ".
		$this->getDateTime()->format("Y-m-d H:i");
    }
    
    public function populate(array $array)
    {
	$Employee = $this->_getEntityFromArray($array, "Entities\Company\Employee", "employee_id");
	
	if($Employee)
	{
	    $this->setEmployee($Employee);
	    
	    $this->setTimeClock($Employee->getCompany()->getTimeClock());
	}	
	
	if(isset($array["date_time_value"]))
	{
	    $DateTime = \DateTime::createFromFormat("Y-m-d H:i:s", $array["date_time_value"]);

	    if($DateTime)
		$this->setDateTime($DateTime);
	}
	
	parent::populate($array);
    }
}
