<?php
namespace Entities\Company\PhoneNumber;

/** 
 * @Entity (repositoryClass="Repositories\Company\PhoneNumber\PhoneNumberAbstract") 
 * @Table(name="company_phone_number_phonenumberabstracts") 
 */
abstract class PhoneNumberAbstract extends \Entities\Company\Contact\MediumAbstract
{
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
