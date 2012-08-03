<?php

namespace Entities;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity (repositoryClass="Repositories\CbOption") 
 * @Table(name="cb_options")
 * @HasLifecycleCallbacks
 */
class CbOption
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /** @Column(type="string", length=255) */
    private $index_string;

    /** @Column(type="string", length=2) */
    private $code;
    
    /** @Column(type="string", length=255) */
    private $name;
    
    /** @Column(type="string", length=1000) */
    private $description;

    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="CbValue", mappedBy="option", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $values;
    
    private $length;
    
    public function __construct()
    {
	$this->Products	    = new ArrayCollection();
	$this->values	    = new ArrayCollection();
    }
    
    /**
     * Add value to Option.
     * @param BcValue $value
     */
    public function addValue(CbValue $value)
    {
	$value->setOption($this);
        $this->values[] = $value;
    }
    
    /**
     * Retrieve person's associated addresses.
     */
    public function getValues()
    {
      return $this->values;
    }
    
    /**
     * Retrieve length of values
     */
    public function getLength(){
	$this->_calculateLength();
	return $this->length;
    }
    
    /**
     * Calculate length of values
     */
    private function _calculateLength(){
	$length = 0;
	if(is_array($this->values)){
	    /* @var $value \Entities\CbValue */
	    foreach ($this->values as $value) {
		$length += (int) $value->getLength();
	    }
	}
	
	$this->length = $length;
    }

    /**
     * Retrieve supplier id
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