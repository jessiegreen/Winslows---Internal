<?php

namespace Entities\Website;
use Doctrine\Common\Collections\ArrayCollection;

/** 
 * @Entity (repositoryClass="Repositories\Website\Resource") 
 * @Table(name="website_resources") 
 */
class Resource
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     * @var integer $id
     */
    private $id;

    /** 
     * @Column(type="string", length=255) 
     * @var string $module
     */
    private $module;
    
    /**
     * @Column(type="string", length=255) 
     * @var string
     */
    private $controller;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $action
     */
    private $action;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $name
     */
    private $name;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $routeName
     */
    private $routeName;
    
    /** 
     * @Column(type="datetime") 
     * @var \DateTime $created
     */
    private $created;

    /** 
     * @Column(type="datetime") 
     * @var \DateTime $updated
     */
    private $updated;
    
    /**
     * @ManytoMany(targetEntity="Website\Role", mappedBy="Resources", cascade={"ALL"})
     * @var \Entities\Website\Account\Role
     */
    private $Roles;
    
    public function __construct()
    {
	$this->created	= $this->updated = new \DateTime("now");
	$this->Roles    = new ArrayCollection();
    }
    
    /**
     * @PreUpdate
     */
    public function updated()
    {
        $this->updated = new \DateTime("now");
    }
    
    /**
     * @return array
     */
    public function getRoles(){
	return $this->Roles;
    }
    
    /**
     * @param \Entities\Website\Account\Role $Role
     */
    public function addRole(Account\Role $Role){
	$Role->addResource($this);
	$this->Roles[] = $Role;
    }
    
    /**
     * @param \Entities\Website\Account\Role $Role
     * @return boolean
     */
    public function removeRole(Account\Role $Role)
    {
	foreach ($this->Roles as $key => $Role2) {
	    if($Role->getId() == $Role2->getId()){
		$Role->removeResource($this);
		$removed = $this->Roles[$key];
		unset($this->Roles[$key]);
		return $removed;
	    }
	}
	return false;
    }

    /**
     * Retrieve Role id
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
    
    /**
     * @return string
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * @param string $module
     */
    public function setModule(string $module)
    {
        $this->module = $module;
    }
    
    /**
     * @return string
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @param string $controller
     */
    public function setController(string $controller)
    {
        $this->controller = $controller;
    }
    
    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param string $action
     */
    public function setAction(string $action)
    {
        $this->action = $action;
    }
    
    /**
     * @return string
     */
    public function getRouteName()
    {
        return $this->routeName;
    }

    /**
     * @param string $routeName
     */
    public function setRouteName(string $routeName)
    {
        $this->routeName = $routeName;
    }
    
    /**
     * @param \DateTime $created
     */
    public function setCreated(\DateTime $created)
    {
        $this->created = $created;
    }
    
    /**
     * @return \DateTime
     */
    public function getCreated(){
	return $this->created;
    }

    /**
     * @return \DateTime
     */
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
