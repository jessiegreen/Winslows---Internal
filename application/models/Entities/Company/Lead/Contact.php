<?php

namespace Entities\Company\Lead;

/** 
 * @Entity (repositoryClass="Repositories\Company\Lead\Contact") 
 * @Table(name="company_lead_contacts") 
 * @HasLifecycleCallbacks
 */
class Contact extends \Dataservice_Doctrine_Entity
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     * @var integer $id
     */
    protected $id;

    /** 
     * @Column(type="string", length=50000) 
     * @var string $note
     */
    protected $note;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $type
     */
    protected $type;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $type_detail
     */
    protected $type_detail;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $result
     */
    protected $result;
    
    /**
     * @ManyToOne(targetEntity="\Entities\Company\Lead", inversedBy="Contacts")
     * @var \Entities\Company\Lead $Lead
     */
    protected $Lead;
    
    /** 
     * @ManyToOne(targetEntity="\Entities\Company\Employee", cascade="persist")
     * @var \Entities\Company\Employee $Employee
     */     
    protected $Employee;

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
     * @param \Entities\Company\Employee $Employee
     */
    public function setEmployee(\Entities\Company\Employee $Employee)
    {
	$this->Employee = $Employee;
    }
    
    /**
     * @return \Entities\Company\Employee
     */
    public function getEmployee()
    {
	return $this->Employee;
    }
    
    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @param string $note
     */
    public function setNote($note)
    {
	$this->note = $note;
    }
    
    /**
     * @return string
     */
    public function getNote()
    {
	return $this->note;
    }
    
    /**
     * @param string $type
     * @throws \Exception
     */
    public function setType($type)
    {
	if(!key_exists($type, $this->getTypeOptions()))
	    throw new \Exception("Type must be in Type Options");
	$this->type = $type;
    }
    
    /**
     * @param string $type
     * @return string
     * @throws \Exception
     */
    public function getTypeDisplay($type = null)
    {
	$array = $this->getTypeOptions();
	
	if($type === null)$type = $this->type;
	
	if(!$type)return "";
	
	if(!key_exists($type, $array))
	    throw new \Exception("Could not get Result Display. Key '".$type."' does not exist");
	
	return $array[$type];
    }
    
    /**
     * @return string
     */
    public function getType()
    {
	return $this->type;
    }
    
    /**
     * @param string $type_detail
     */
    public function setTypeDetail($type_detail)
    {
	$this->type_detail = $type_detail;
    }
    
    /**
     * @return string
     */
    public function getTypeDetail()
    {
	return $this->type_detail;
    }
    
    /**
     * @param string $result
     * @throws \Exception
     */
    public function setResult($result)
    {
	if(!key_exists($result, $this->getResultOptions()))
	    throw new \Exception("Result must be in Result Options");
	$this->result = $result;
    }
    
    /**
     * @return string
     */
    public function getResult()
    {
	return $this->result;
    }
    
    /**
     * @return string
     * @throws \Exception
     */
    public function getResultDisplay()
    {
	$array = $this->getResultOptions();
	
	if(!key_exists($this->result, $array))
	    throw new \Exception("Could not get Result Display. Key '".$this->result."' does not exist");
	
	return $array[$this->result];
    }
    
    /**
     * @return array
     */
    public function getTypeOptions()
    {
	return array(
	    "phone"	=> "Phone",
	    "email"	=> "Email",
	    "location"	=> "Walk In"
	);
    }
    
    /**
     * @return array
     */
    public function getResultOptions()
    {
	return array(
	    "quote"	    => "Quote",
	    "information"   => "Information",
	    "sale"	    => "Sale"
	);
    }
}
