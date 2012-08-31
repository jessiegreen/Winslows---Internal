<?php

namespace Entities\Company\Employee\Role;

/** 
 * @Entity (repositoryClass="Repositories\Role\Privilege") 
 * @Table(name="role_privileges") 
 * @HasLifecycleCallbacks
 */
class Privilege extends \Dataservice_Doctrine_Entity
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     * @var integer $id
     */
    private $id;

    /** 
     * @Column(type="string", length=255) 
     * @var string $name
     */
    private $name;
    
    /**
     * @ManyToOne(targetEntity="\Entities\Role", inversedBy="Privileges")
     * @var $Role null | \Entities\Role
     */
    private $Role;
    
    /**
     * @param \Entities\Role $Role
     */
    public function setRole(\Entities\Role $Role)
    {
	$this->Role = $Role;
    }
    
    /**
     * @return \Entities\Role
     */
    public function getRole()
    {
	return $this->Role;
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
}
