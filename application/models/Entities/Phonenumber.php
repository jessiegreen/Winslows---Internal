<?php

namespace Entities;
use Doctrine\Common\Collections\ArrayCollection;

/** 
 * @Entity (repositoryClass="Repositories\Phonenumber") 
 * @Table(name="phonenumbers")
 */
class Phonenumber
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** @Column(type="string", length=255) */
    private $type;
    
    /** @Column(type="integer", length=3) */
    private $area_code;
    
    /** @Column(type="integer", length=3) */
    private $num1;
    
    /** @Column(type="string", length=4) */
    private $num2;
    
    /** @Column(type="string", length=7) */
    private $extension;

    /** @Column(type="datetime") */
    private $created;

    /** @Column(type="datetime") */
    private $updated;

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
     * Retrieve phonenumber id
     */
    public function getId()
    {
        return $this->id;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }
    
    public function getAreaCode()
    {
        return $this->area_code;
    }

    public function setAreaCode($area_code)
    {
        $this->area_code = $area_code;
    }

    public function getNum1()
    {
        return $this->num1;
    }

    public function setNum1($num1)
    {
        $this->num1 = $num1;
    }

    public function getNum2()
    {
        return $this->num2;
    }

    public function setNum2($num2)
    {
        $this->num2 = $num2;
    }
    
    public function getNumberDisplay(){
	return "(".$this->area_code.")".$this->num1."-".$this->num2;
    }
    
    public function getExtension()
    {
        return $this->extension;
    }

    public function setExtension($extension)
    {
        $this->extension = $extension;
    }

    public function getCreated()
    {
        return $this->created;
    }

    public function setCreated($created)
    {
        $this->created = $created;
    }

    public function getUpdated()
    {
        return $this->updated;
    }
    
    public function getTypeOptions(){
	return array(
	    "home" => "Home",
	    "cell" => "Cell",
	    "work" => "Work",
	    "fax"  => "Fax"
	);
    }

}
