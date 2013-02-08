<?php
namespace Entities\Company;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity (repositoryClass="Repositories\Company\PaymentGateway") 
 * @Table(name="company_paymentgateways")
 * @HasLifecycleCallbacks
 * @Crud\Entity\Url(value="payment-gateway")
 * @Crud\Entity\Permissions(view={"Admin"}, edit={"Admin"}, create={"Admin"}, delete={"Admin"})
 */
class PaymentGateway extends \Dataservice_Doctrine_Entity
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
     * @Column(type="string", length=255) 
     * @var string $dba
     */
    protected $dba;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $name_index
     */
    protected $name_index;
    
    /** 
     * @Column(type="string", length=50000)
     * @var string $description
     */
    protected $description;
    
    /** 
     * @ManyToOne(targetEntity="\Entities\Company", inversedBy="RtoProviders")
     * @var \Entities\Company $Company
     */  
    protected $Company;
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="\Entities\Company\Sale\Transaction\Payment\PaymentGateway", mappedBy="PaymentGateway", cascade={"persist"})
     * @var ArrayCollection $Applications
     */
    protected $Payments;
    
    public function __construct()
    {
	$this->Payments = new ArrayCollection();
	
	parent::__construct();
    }
    
    /**
     * @param \Entities\Company $Company
     */
    public function setCompany(\Entities\Company $Company)
    {
	$this->Company = $Company;
    }
    
    /**
     * @return \Entities\Company
     */
    public function getCompany()
    {
	return $this->Company;
    }
    
    /**
     * @return ArrayCollection
     */
    public function getPayments()
    {
	return $this->Payments;
    }
    
    /**
     * @param PaymentGateway\Payment $Application
     */
    public function addPayment(PaymentGateway\Payment $Payment)
    {
	$Payment->setPaymentGateway($this);
	
	$this->Payments[] = $Payment;
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
     * @param type $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    
    /**
     * @return string
     */
    public function getDba()
    {
        return $this->dba;
    }

    /**
     * @param string $dba
     */
    public function setDba($dba)
    {
        $this->dba = $dba;
    }
    
    /**
     * @return string
     */
    public function getNameIndex()
    {
        return $this->name_index;
    }

    /**
     * @param string $name_index
     */
    public function setNameIndex($name_index)
    {
        $this->name_index = $name_index;
    }
    
    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }
    
    public function toString()
    {
	return $this->getName();
    }
    
    public function populate(array $array)
    {
	$Company = $this->_getEntityFromArray($array, "Entities\Company", "company_id");
	
	if($Company && $Company->getId())
	    $this->setCompany($Company);
	
	parent::populate($array);
    }
}