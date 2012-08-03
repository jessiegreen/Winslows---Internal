<?php

namespace Entities\Website\Account\Role;

/** 
 * @Entity (repositoryClass="Repositories\Website\Account\Role\Privilege") 
 * @Table(name="website_account_role_privileges") 
 * @HasLifecycleCallbacks
 */
class Privilege
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
     * @ManyToOne(targetEntity="Role", inversedBy="Privileges")
     * @var $Role null | Role
     */
    private $Role;
    
    /**
     * @param \Entities\Website\Account\Role $Role
     */
    public function setRole(\Entities\Website\Account\Role $Role){
	$this->Role = $Role;
    }
    
    /**
     * @return \Entities\Website\Account\Role
     */
    public function getRole(){
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
    public function setName(string $name)
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
