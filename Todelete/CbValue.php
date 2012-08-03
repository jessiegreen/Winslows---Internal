<?php

namespace Entities;
use Doctrine\Common\Collections\ArrayCollection;

/** 
 * @Entity (repositoryClass="Repositories\CbValue") 
 * @Table(name="cb_values") 
 * @HasLifecycleCallbacks
 */
class CbValue
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** @Column(type="integer", length=11) */
    private $option_id;
    
    /** @Column(type="string", length=255) */
    private $index_string;
    
    /** @Column(type="string", length=255) */
    private $name;
    
    /** @Column(type="string", length=1000) */
    private $description;
    
    /** @Column(type="integer", length=10) */
    private $length;
    
    /**
     * @ManyToOne(targetEntity="CbOption", inversedBy="values")
     * @JoinColumn(name="option_id", referencedColumnName="id")
     * @var $option null | CbOption
     */
    private $option;
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="CbValueOption", mappedBy="value", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $value_options;
    
    public function __construct()
    {
	$this->value_options = new ArrayCollection();
    }
    
    public function setOption(CbOption $option){
	$this->option = $option;
    }
    
    public function getOption(){
	return $this->option;
    }
    
    public function AddValueOption(CbValueOption $value_option){
	$value_option->setValue($this);
	$this->value_options[] = $value_option;
    }
    
    public function getValueOptions(){
	return $this->value_options;
    }

    /**
     * Retrieve Value id
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
    
    public function getLength()
    {
        return $this->length;
    }

    public function setLength($length)
    {
        $this->length = $length;
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
	$array['description']	= $this->getDescription();
	return $array;
    }
}
