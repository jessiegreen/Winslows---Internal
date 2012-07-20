<?php

namespace Entities;
use Doctrine\Common\Collections\ArrayCollection;

/** 
 * @Entity (repositoryClass="Repositories\Privilege") 
 * @Table(name="privileges") 
 * @HasLifecycleCallbacks
 */
class Privilege
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** @Column(type="string", length=255) */
    private $name;
    
    /**
     * @ManyToOne(targetEntity="Role", inversedBy="Privileges")
     * @var $Role null | Role
     */
    private $Role;
    
    public function __construct()
    {
	
    }
    
    public function setRole(Role $Role){
	$this->Role = $Role;
    }
    
    public function getRole(){
	return $this->Role;
    }

    /**
     * Retrieve Privilege id
     */
    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function populate(array $array){
	foreach ($array as $key => $value) {
	    if(property_exists($this, $key)){
		$this->$key = $value;
	    }
	}
    }
}
