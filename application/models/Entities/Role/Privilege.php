<?php

namespace Entities\Role;

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
    protected $id;

    /** 
     * @Column(type="string", length=255) 
     * @var string $name
     */
    protected $name;
    
    /**
     * @ManyToOne(targetEntity="\Entities\Role\RoleAbstract", inversedBy="Privileges")
     * @var $Role null | \Entities\Role\RoleAbstract
     */
    protected $Role;
    
    /**
     * @param \Entities\Role\RoleAbstract $Role
     */
    public function setRole(\Entities\Role\RoleAbstract $Role)
    {
	$this->Role = $Role;
    }
    
    /**
     * @return \Entities\Role\RoleAbstract
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