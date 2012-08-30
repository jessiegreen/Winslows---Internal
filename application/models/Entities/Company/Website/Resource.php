<?php

namespace Entities\Company\Website;
use Doctrine\Common\Collections\ArrayCollection;

/** 
 * @Entity (repositoryClass="Repositories\Company\Website\Resource") 
 * @Table(name="company_website_resources") 
 */
class Resource extends \Dataservice_Doctrine_Entity
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
     * @ManytoMany(targetEntity="\Entities\Company\Website\Account\Role", mappedBy="Resources", cascade={"persist"})
     * @var \Entities\Company\Website\Account\Role
     */
    private $Roles;
    
    /**
     * @ManyToOne(targetEntity="\Entities\Company\Website", inversedBy="Resources")
     * @var \Entities\Company\Website
     */
    private $Website;
    
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
     * @param \Entities\Company\Website $Website
     */
    public function setWebsite(\Entities\Company\Website $Website)
    {
	$this->Website = $Website;
    }
    
    /**
     * @return \Entities\Company\Website
     */
    public function getWebsite()
    {
	return $this->Website;
    }
    
    /**
     * @return ArrayCollection
     */
    public function getRoles(){
	return $this->Roles;
    }
    
    /**
     * @param \Entities\Company\Employee\Role $Role
     */
    public function addRole(Account\Role $Role)
    {
	$Role->addResource($this);
	$this->Roles[] = $Role;
    }
    
    /**
     * @param \Entities\Company\Employee\Role $Role
     * @return boolean
     */
    public function removeRole(Account\Role $Role)
    {
	$Role->removeResource($this);
	$this->getRoles()->removeElement($Role);
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
    public function setName($name)
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
    public function setModule($module)
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
    public function setController($controller)
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
    public function setAction($action)
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
    public function setRouteName($routeName)
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
