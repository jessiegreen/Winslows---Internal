<?php

namespace Entities;
use Doctrine\Common\Collections\ArrayCollection;

/** 
 * @Entity (repositoryClass="Repositories\Resource") 
 * @Table(name="resources") 
 */
class Resource
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** @Column(type="string", length=255) */
    private $module;
    
    /** @Column(type="string", length=255) */
    private $controller;
    
    /** @Column(type="string", length=255) */
    private $action;
    
    /** @Column(type="string", length=255) */
    private $name;
    
    /** @Column(type="string", length=255) */
    private $routeName;
    
    /** @Column(type="datetime") */
    private $created;

    /** @Column(type="datetime") */
    private $updated;
    
    /**
     * @ManytoMany(targetEntity="Role", mappedBy="resources", cascade={"ALL"})
     */
    private $roles;
    
    public function __construct()
    {
	$this->created	= $this->updated = new \DateTime("now");
	$this->roles    = new ArrayCollection();
    }
    
    /**
     * @PreUpdate
     */
    public function updated()
    {
        $this->updated = new \DateTime("now");
    }
    
    public function getRoles(){
	return $this->roles;
    }
    
    public function addRole(\Entities\Role $Role){
	$Role->addResource($this);
	$this->roles[] = $Role;
    }
    
    public function removeRole($role_id)
    {
	foreach ($this->roles as $key => $Role) {
	    if($Role->getId() == $role_id){
		$Role->removeResource($this);
		$removed = $this->roles[$key];
		unset($this->roles[$key]);
		return $removed;
	    }
	}
	return false;
    }


    /**
     * Retrieve Role id
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
    
    public function getModule()
    {
        return $this->module;
    }

    public function setModule($module)
    {
        $this->module = $module;
    }
    
    public function getController()
    {
        return $this->controller;
    }

    public function setController($controller)
    {
        $this->controller = $controller;
    }
    
    public function getAction()
    {
        return $this->action;
    }

    public function setAction($action)
    {
        $this->action = $action;
    }
    
    public function getRouteName()
    {
        return $this->routeName;
    }

    public function setRouteName($routeName)
    {
        $this->routeName = $routeName;
    }
    
    public function setCreated($created)
    {
        $this->created = $created;
    }
    
    public function getCreated(){
	return $this->created;
    }

    public function getUpdated()
    {
        return $this->updated;
    }

}
