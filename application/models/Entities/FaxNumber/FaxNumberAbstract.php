<?php

namespace Entities\FaxNumber;

use Doctrine\Common\Collections\ArrayCollection;

/** 
 * @Entity (repositoryClass="Repositories\FaxNumber\FaxNumberAbstract") 
 * @Table(name="faxnumber_faxnumberabstracts") 
 * @InheritanceType("JOINED")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({
 *			"company_lead_faxnumber" = "\Entities\Company\Lead\FaxNumber",
 *			"company_employee_faxnumber" = "\Entities\Company\Employee\FaxNumber",
 *			"company_location_faxnumber" = "\Entities\Location\FaxNumber"
 *		    })
 * @HasLifecycleCallbacks
 */
class FaxNumberAbstract extends \Dataservice_Doctrine_Entity
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     * @var integer $id
     */
    protected $id;
    
    /** 
     * @Column(type="integer", length=3) 
     * @var integer $area_code
     */
    protected $area_code;
    
    /** 
     * @Column(type="integer", length=3) 
     * @var integer $num1
     */
    protected $num1;
    
    /** 
     * @Column(type="integer", length=4) 
     * @var integer $num2
     */
    protected $num2;
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="\Entities\FaxNumber\Fax", mappedBy="FaxNumber", cascade={"persist", "remove"})
     * @var \Doctrine\Common\Collections\ArrayCollection $Faxes
     */
    protected $Faxes;

    public function __construct()
    {
	$this->Faxes = new ArrayCollection();
	
	parent::__construct();
    }
    
    /**
     * @param Fax $Fax
     */
    public function addFax(Fax $Fax)
    {
	$Fax->setFaxNumber($this);
	
        $this->Faxes->add($Fax);
    }
    
    /**
     * @return ArrayCollection
     */
    public function getFaxes()
    {
	return $this->Faxes;
    }
    
    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
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
     * @return integer
     */
    public function getNum1()
    {
        return $this->num1;
    }

    /**
     * @param integer $num1
     */
    public function setNum1($num1)
    {
        $this->num1 = $num1;
    }

    /**
     * @return ineteger
     */
    public function getNum2()
    {
        return $this->num2;
    }

    /**
     * @param integer $num2
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
    
    public function toString()
    {
	return $this->getNumberDisplay();
    }
}
