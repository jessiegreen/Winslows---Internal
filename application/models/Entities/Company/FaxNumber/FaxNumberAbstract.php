<?php
namespace Entities\Company\FaxNumber;

/** 
 * @Entity (repositoryClass="Repositories\Company\FaxNumber\FaxNumberAbstract") 
 * @Table(name="company_faxnumber_faxnumberabstracts") 
 */
abstract class FaxNumberAbstract extends \Entities\Company\ContactLog\Contact\MediumAbstract
{
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
