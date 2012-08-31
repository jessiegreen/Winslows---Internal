<?php

namespace Entities\Company\Lead\Quote;

/** 
 * @Entity (repositoryClass="Repositories\Company\Lead\Quote") 
 * @Table(name="company_lead_quote_quoteabstracts") 
 * @InheritanceType("JOINED")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({"company_lead_quote" = "\Entities\Company\Lead\Quote"})
 * @HasLifecycleCallbacks
 */
class QuoteAbstract extends \Dataservice_Doctrine_Entity
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     * @var integer $id
     */
    protected $id;
    
    /**
     * @Column(type="decimal", precision=40, scale=2)
     * @var integer $total
     */
    protected $total = 0;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}