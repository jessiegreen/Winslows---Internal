<?php

namespace Entities\PhoneNumber;

use Doctrine\Common\Collections\ArrayCollection;

/** 
 * @Entity (repositoryClass="Repositories\PhoneNumber\PhoneNumberAbstract") 
 * @Table(name="phonenumber_phonenumberabstracts") 
 * @InheritanceType("JOINED")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({
 *			"company_lead_phonenumber" = "\Entities\Company\Lead\PhoneNumber", 
 *			"company_employee_phonenumber" = "\Entities\Company\Employee\PhoneNumber", 
 *			"location_phonenumber" = "\Entities\Location\PhoneNumber"
 *		    })
 * @HasLifecycleCallbacks
 */
class PhoneNumberAbstract extends \Dataservice_Doctrine_Entity
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     * @var integer $id
     */
    protected $id;

    /** 
     * @Column(type="string", length=255) 
     * @var string $type
     */
    protected $type;
    
    /** 
     * @Column(type="string", length=3) 
     * @var integer $area_code
     */
    protected $area_code;
    
    /** 
     * @Column(type="string", length=3) 
     * @var integer $num1
     */
    protected $num1;
    
    /** 
     * @Column(type="string", length=4) 
     * @var integer $num2
     */
    protected $num2;
    
    /** 
     * @Column(type="string", length=7) 
     * @var string $extension
     */
    protected $extension;

    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="\Entities\PhoneNumber\Call", mappedBy="PhoneNumber", cascade={"persist", "remove"})
     * @var \Doctrine\Common\Collections\ArrayCollection $Emails
     */
    protected $Calls;
    
    public function __construct()
    {
	$this->Calls = new ArrayCollection();
	
	parent::__construct();
    }

    /**
     * @param Call $Call
     */
    public function addCall(Call $Call)
    {
	$Call->setPhoneNumber($this);
	
        $this->Calls->add($Call);
    }
    
    /**
     * @return ArrayCollection
     */
    public function getCalls()
    {
	return $this->Calls;
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
    public function getType()
    {
        return $this->type;
    }
    
    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }
    
    /**
     * @return integer
     */
    public function getAreaCode()
    {
        return $this->area_code;
    }
    
    /**
     * @param integer $area_code
     */
    public function setAreaCode($area_code)
    {
        $this->area_code = $area_code;
    }

    /**
     * @return string
     */
    public function getNum1()
    {
        return $this->num1;
    }

    /**
     * @param string $num1
     */
    public function setNum1($num1)
    {
        $this->num1 = $num1;
    }

    /**
     * @return string
     */
    public function getNum2()
    {
        return $this->num2;
    }

    /**
     * @param string $num2
     */
    public function setNum2($num2)
    {
        $this->num2 = $num2;
    }
    
    /**
     * @return string
     */
    public function getNumberDisplay()
    {
	return "(".$this->area_code.") ".$this->num1."-".$this->num2;
    }
    
    /**
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * @param string $extension
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /** 
     * @param \DateTime $created
     */
    public function setCreated(\DateTime $created)
    {
        $this->created = $created;
    }

    /**
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }
    
    public function toString()
    {
	return \Dataservice\Inflector::humanize($this->getType())." - ".$this->getNumberDisplay();
    }

    /** 
     * @return array
     */
    public function getTypeOptions(){
	return array(
	    "home" => "Home",
	    "cell" => "Cell",
	    "work" => "Work"
	);
    }
}
