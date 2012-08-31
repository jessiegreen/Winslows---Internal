<?php

namespace Entities\Website;

use Doctrine\Common\Collections\ArrayCollection;

/** 
 * @Entity (repositoryClass="Repositories\Website\Resource") 
 * @Table(name="website_resources") 
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
     * @ManytoMany(targetEntity="\Entities\Role\RoleAbstract", mappedBy="Resources", cascade={"persist"})
     * @var ArrayCollection
     */
    private $Roles;
    
    /**
     * @ManyToOne(targetEntity="\Entities\Website\WebsiteAbstract", inversedBy="Resources")
     * @var \Entities\Company\Website
     */
    private $Website;
    
    public function __construct()
    {
	$this->created	= $this->updated = new \DateTime("now");
	$this->Roles    = new ArrayCollection();
	
	parent::__construct();
    }
    
    /**
     * @param \Entities\Website\WebsiteAbstract $Website
     */
    public function setWebsite(\Entities\Website\WebsiteAbstract $Website)
    {
	$this->Website = $Website;
    }
    
    /**
     * @return \Entities\Website\WebsiteAbstract
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
     * @param \Entities\Role\RoleAbstract $Role
     */
    public function addRole(\Entities\Role\RoleAbstract $Role)
    {
	$Role->addResource($this);
	$this->Roles[] = $Role;
    }
    
    /**
     * @param \Entities\Role\RoleAbstract $Role
     * @return boolean
     */
    public function removeRole(\Entities\Role\RoleAbstract $Role)
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
}
