<?php

namespace Entities\Website\Role;

/** 
 * @Entity (repositoryClass="Repositories\Website\Role\Privilege") 
 * @Table(name="website_role_privileges") 
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
     * @ManyToOne(targetEntity="Entities\Website\Role", inversedBy="Privileges")
     * @var $Role \Entities\Website\Role
     */
    protected $Role;
    
    /**
     * @param \Entities\Website\Role $Role
     */
    public function setRole(\Entities\Website\Role $Role)
    {
	$this->Role = $Role;
    }
    
    /**
     * @return \Entities\Website\Role
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
