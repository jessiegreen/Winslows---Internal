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
}