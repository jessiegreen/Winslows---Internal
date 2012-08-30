<?php

namespace Entities\Company\Website\Account\Role;

/** 
 * @Entity (repositoryClass="Repositories\Company\Website\Account\Role\Privilege") 
 * @Table(name="company_website_account_role_privileges") 
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
     * @ManyToOne(targetEntity="\Entities\Company\Website\Account\Role", inversedBy="Privileges")
     * @var $Role null | Role
     */
    private $Role;
    
    /**
     * @param \Entities\Company\Website\Account\Role $Role
     */
    public function setRole(\Entities\Company\Website\Account\Role $Role)
    {
	$this->Role = $Role;
    }
    
    /**
     * @return \Entities\Company\Website\Account\Role
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

    public function populate(array $array){
	foreach ($array as $key => $value) {
	    if(property_exists($this, $key)){
		$this->$key = $value;
	    }
	}
    }
}
