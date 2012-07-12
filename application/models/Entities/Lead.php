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
    /** @Column(type="string", length=255) */
    protected $company;
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="Contact", mappedBy="lead", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    protected $contacts;
    
    public function __construct(){
	$this->contacts = new ArrayCollection();
	parent::__construct();
    }
    
    public function AddContact(Contact $Contact){
	$Contact->setLead($this);
	$this->contacts[] = $Contact;
    }
    
    public function getContacts(){
	return $this->contacts;
    }
    
    public function getCompany()
    {
        return $this->company;
    }

    public function setCompany($company)
    {
        $this->company = $company;
    }
    
}

?>
