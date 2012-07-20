<?php
/**
 * Name:
 * Location:
 *
 * Description for class (if any)...
 *
 * @author     Jessie Green <jessie.winslows@gmail.com>
 * @copyright  2012 Winslows inc.
 * @version    Release: @package_version@
 */
namespace Entities;
/** 
 * @Entity (repositoryClass="Repositories\Lead") 
 * @Table(name="leads") 
 */

use Entities\Person as Person;
use Doctrine\Common\Collections\ArrayCollection;

class Lead extends Person
{
    /** 
     * @ManyToOne(targetEntity="Employee", inversedBy="Leads")
     */     
    protected $Employee;
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="Contact", mappedBy="Lead", cascade={"persist"})
     */
    protected $Contacts;
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="Employee", mappedBy="Employee", cascade={"persist"})
     */
    protected $Leads;
    
    public function __construct(){
	$this->Contacts = new ArrayCollection();
	parent::__construct();
    }
    
    public function AddContact(Contact $Contact){
	$Contact->setLead($this);
	$this->Contacts[] = $Contact;
    }
    
    public function getContacts(){
	return $this->Contacts;
    }
    
    public function getEmployee()
    {
        return $this->Employee;
    }

    public function setEmployee(Employee $Employee)
    {
        $this->Employee = $Employee;
    }    
    
    public function populate(array $array){
	foreach ($array as $key => $value) {
	    if(property_exists($this, $key)){
		$this->$key = $value;
	    }
	}
    }
}