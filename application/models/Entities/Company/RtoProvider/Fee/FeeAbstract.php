<?php

namespace Entities\Company\RtoProvider\Fee;

use Doctrine\Common\Collections\ArrayCollection;

/** 
 * @Entity (repositoryClass="Repositories\Company\RtoProvider\Fee\FeeAbstract") 
 * @Table(name="company_rtoprovider_fee_feeabstracts") 
 * @InheritanceType("JOINED")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({
 *			"company_rtoprovider_fee_range"	     = "\Entities\Company\RtoProvider\Fee\Range",
 *			"company_rtoprovider_fee_percentage" = "\Entities\Company\RtoProvider\Fee\Percentage",
 *		    })
 * @HasLifecycleCallbacks
 */
class FeeAbstract extends \Dataservice_Doctrine_Entity implements \Interfaces\Company\RtoProvider\Fee
{
    const TYPE_Range	    = "Range";
    const TYPE_Percentage   = "Percentage";
    const TYPE_Base	    = "Base";
    
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
     * @var string $name_index
     */
    protected $name_index;
    
    /** 
     * @ManyToOne(targetEntity="\Entities\Company\RtoProvider", inversedBy="Fees")
     * @var \Entities\Company\RtoProvider $RtoProvider
     */  
    protected $RtoProvider;
    
    /**
     * @ManytoMany(targetEntity="\Entities\Company\RtoProvider\Program", inversedBy="Fees", cascade={"persist"})
     * @JoinTable(name="company_rtoprovider_program_fee_joins")
     * @var ArrayCollection $Programs
     */
    protected $Programs;
    
    public function __construct()
    {
	$this->Programs = new ArrayCollection();
	
	parent::__construct();
    }
    
    /**
     * @param \Entities\Company\RtoProvider $Company
     */
    public function setRtoProvider(\Entities\Company\RtoProvider $RtoProvider)
    {
	$this->RtoProvider = $RtoProvider;
    }
    
    /**
     * @return \Entities\Company\RtoProvider
     */
    public function getRtoProvider()
    {
	return $this->RtoProvider;
    }
    
    /**
     * @param \Entities\Company\RtoProvider\Program $Program
     */
    public function addProgram(\Entities\Company\RtoProvider\Program $Program)
    {
	if(!$this->Programs->contains($Program))
	    $this->Programs[] = $Program;
    }
    
    /**
     * @param \Entities\Company\RtoProvider\Program $Program
     */
    public function removeProgram(\Entities\Company\RtoProvider\Program $Program)
    {
	$this->Programs->removeElement($Program);
    }
    
    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getPrograms()
    {
	return $this->Programs;
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
    
    public function getFeePrice()
    {
	
    }
    
    /**
     * @return string
     */
    public function getDescriminator()
    {
	return static::TYPE_Base;
    }
    
    public function getUrlKey()
    {
	return strtolower($this->getDescriminator());
    }
}