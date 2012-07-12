<?php

namespace Entities;
use Doctrine\Common\Collections\ArrayCollection;

/** 
 * @Entity (repositoryClass="Repositories\CbValueOption") 
 * @Table(name="cb_value_options") 
 * @HasLifecycleCallbacks
 */
class CbValueOption
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /** @Column(type="integer", length=11) */
    private $value_id;

    /** @Column(type="string", length=255) */
    private $index_string;
    
    /** @Column(type="string", length=255) */
    private $name;
    
    /** @Column(type="string", length=255) */
    private $code;
    
    /** @Column(type="string", length=1000) */
    private $description;
        
    /**
     * @ManyToOne(targetEntity="CbValue", inversedBy="value_options")
     * @JoinColumn(name="value_id", referencedColumnName="id")
     * @var $value null | CbValue
     */
    private $value;
    
    public function __construct()
    {
	
    }
    
    public function setValue(CbValue $value){
	$this->value = $value;
    }
    
    public function getValue(){
	return $this->value;
    }

    /**
     * Retrieve Option id
     */
    public function getId()
    {
        return $this->id;
    }
    
    public function getIndex()
    {
        return $this->index_string;
    }

    public function setIndex($index)
    {
        $this->index_string = $index;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
    
    public function getCode()
    {
        return $this->code;
    }

    public function setCode($code)
    {
        $this->code = $code;
    }
    
    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }
    
    public function toArray(){
	$array			= array();
	$array['name']		= $this->getName();
	$array['code']		= $this->getCode();
	$array['description']	= $this->getDescription();
	return $array;
    }
}
