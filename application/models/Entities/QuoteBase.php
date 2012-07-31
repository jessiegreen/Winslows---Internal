<?php

namespace Entities;

/** 
 * @Entity (repositoryClass="Repositories\Quote") 
 * @Table(name="quote_bases") 
 * @InheritanceType("JOINED")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({"quote" = "Quote", "order" = "Order"})
 * @HasLifecycleCallbacks
 */
class QuoteBase
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
    * @Column(type="decimal", precision=40, scale=2)
    */
    private $total;
    
    /** @Column(type="datetime") */
    protected $created;

    /** @Column(type="datetime") */
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
     * Retrieve address id
     */
    public function getId()
    {
        return $this->id;
    }
    
    public function getTotal()
    {
        return $this->total;
    }

    public function setTotal($total)
    {
        $this->total = $total;
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
    
    public function populate(array $array){
	foreach ($array as $key => $value) {
	    if(property_exists($this, $key)){
		$this->$key = $value;
	    }
	}
    }
}