<?php

namespace Entities\Company;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity (repositoryClass="Repositories\Company\Website") 
 * @Table(name="company_websites")
 * @HasLifecycleCallbacks
 */
class Website extends \Dataservice_Doctrine_Entity
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
     * @Column(type="string", length=255) 
     * @var string $type
     */
    private $type;

    /** 
     * @Column(type="string", length=255) 
     * @var string $url
     */
    protected $url;
    
    /** 
     * @ManyToOne(targetEntity="\Entities\Company", inversedBy="Websites")
     * @var \Entities\Company
     */     
    private $Company;
    
    /**
     * @OneToMany(targetEntity="\Entities\Company\Website\Account", mappedBy="Website", cascade={"persist"})
     * @var array $Accounts
     */
    private $Accounts;
    
    /**
     * @OneToMany(targetEntity="\Entities\Company\Website\Resource", mappedBy="Website", cascade={"persist"})
     * @var array $Resources
     */
    private $Resources;
    
    /**
     * @OneToMany(targetEntity="\Entities\Company\Website\Menu", mappedBy="Website", cascade={"persist"})
     * @var array $Menus
     */
    private $Menus;
    
    public function __construct()
    {
	$this->Accounts	    = new ArrayCollection();
	$this->Resources    = new ArrayCollection();
	$this->Menus	    = new ArrayCollection();
    }
    
    /**
     * @return \Entities\Company
     */
    public function getCompany(){
	return $this->Company;
    }
    
    /**
     * @param \Entities\Company $Company
     */
    public function setCompany(\Entities\Company $Company){
	$this->Company = $Company;
    }
    
    /**
     * @param \Entities\Company\Website\Account $Account
     */
    public function addAccount(\Entities\Company\Website\Account $Account)
    {
	$Account->setWebsite($this);
        $this->Accounts[] = $Account;
    }
    
    /**
     * @return array
     */
    public function getAccounts()
    {
	return $this->Accounts;
    }
    
    /**
     * @param \Entities\Company\Website\Resource $Resource
     */
    public function addResource(\Entities\Company\Website\Resource $Resource)
    {
	$Resource->setWebsite($this);
        $this->Resources[] = $Resource;
    }
    
    /**
     * @return array
     */
    public function getResources()
    {
	return $this->Resources;
    }
    
    /**
     * @param \Entities\Company\Website\Resource $Resource
     * @return boolean
     */
    public function removeResource(Website\Resource $Resource)
    {
	foreach ($this->Resources as $key => $Resource2) 
	{
	    if($Resource->getId() == $Resource2->getId())
	    {
		$this->Resources[$key];
		unset($this->Resources[$key]);
		return true;
	    }
	}
	return false;
    }
    
    /**
     * @param \Entities\Company\Website\Menu $Menu
     */
    public function addMenu(\Entities\Company\Website\Menu $Menu)
    {
	$Menu->setWebsite($this);
        $this->Menus[] = $Menu;
    }
    
    /**
     * @return array
     */
    public function getMenus()
    {
	return $this->Menus;
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
    
    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }
    
    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @throws \Exception
     */
    public function setType($type)
    {
	if(!key_exists($type, $this->getTypeOptions()))
	    throw new \Exception("Type option of ".htmlspecialchars ($type)." does not exist");
        $this->type = $type;
    }
    
    /**
     * @param string $type
     * @return string
     * @throws \Exception
     */
    public function getTypeDisplay($type = null)
    {
	if($type === null)
	{
	    $type = $this->type; 
	}
	
	if(!$type)return "";
	
	$array = $this->getTypeOptions();
	
	if(!key_exists($type, $array))
	    throw new \Exception("Could not get Type Display. Key '".$type."' does not exist");
	
	return $array[$type];
    }
    
    /**
     * @return array
     */
    public function getTypeOptions()
    {
	return array(
	    "sales"	    => "Sales",
	    "management"    => "Management"
	);
    }
    
    public function populate(array $array)
    {
	foreach ($array as $key => $value) 
	{
	    if(property_exists($this, $key))
	    {
		$this->$key = $value;
	    }
	}
    }
}