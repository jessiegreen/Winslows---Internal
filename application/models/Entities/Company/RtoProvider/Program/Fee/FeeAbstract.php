<?php

namespace Entities\Company\RtoProvider\Program\Fee;

use Doctrine\Common\Collections\ArrayCollection;

/** 
 * @Entity (repositoryClass="Repositories\Company\RtoProvider\Program\Fee\FeeAbstract") 
 * @Table(name="company_rtoprovider_program_fee_feeabstracts") 
 * @InheritanceType("JOINED")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({
 *			"company_rtoprovider_program_fee_range"	     = "\Entities\Company\RtoProvider\Program\Fee\Range",
 *			"company_rtoprovider_program_fee_percentage" = "\Entities\Company\RtoProvider\Program\Fee\Percentage",
 *		    })
 * @HasLifecycleCallbacks
 */
class FeeAbstract extends \Dataservice_Doctrine_Entity implements \Interfaces\Company\RtoProvider\Program\Fee
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
     * @var string $name_index
     */
    protected $name_index;
    
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
}