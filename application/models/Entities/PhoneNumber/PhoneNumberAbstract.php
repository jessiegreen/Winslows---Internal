<?php

namespace Entities\PhoneNumber;

/** 
 * @Entity (repositoryClass="Repositories\PhoneNumber\PhoneNumberAbstract") 
 * @Table(name="phonenumber_phonenumberabstracts") 
 * @InheritanceType("JOINED")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({"person_phonenumber" = "\Entities\Person\PhoneNumber", "location_phonenumber" = "\Entities\Company\Location\PhoneNumber"})
 * @HasLifecycleCallbacks
 */
class PhoneNumberAbstract
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
     * @Column(type="string", length=7) 
     * @var string $extension
     */
    protected $extension;

    /** 
     * @Column(type="datetime") 
     * @var \DateTime $created
     */
    protected $created;

    /** 
     * @Column(type="datetime") 
     * @var \DateTime $updated
     */
    protected $updated;

    public function __construct()
    {
	$this->created	= $this->updated = new \DateTime("now");
    }
   
    /**
     * @PreUpdate
     */
    public function updated()
    {
        $this->updated = new \DateTime("now");
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
    public function getNumberDisplay(){
	return "(".$this->area_code.")".$this->num1."-".$this->num2;
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

    /** 
     * @return array
     */
    public function getTypeOptions(){
	return array(
	    "home" => "Home",
	    "cell" => "Cell",
	    "work" => "Work",
	    "fax"  => "Fax"
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
