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
     * @ManyToOne(targetEntity="Role", inversedBy="privileges")
     * @JoinColumn(name="role_id", referencedColumnName="id")
     * @var $person null | Person
     */
    private $role;
    
    public function __construct()
    {
	
    }
    
    public function setRole(Role $role){
	$this->role = $role;
    }
    
    public function getRole(){
	return $this->role;
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

}
