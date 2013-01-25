<?php
namespace Entities\Contact;
/** 
 * @Entity (repositoryClass="Repositories\Contact\Party") 
 * @Table(name="contact_parties") 
 */
class Party
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     * @var integer $id
     */
    protected $id;
    
    protected $Initiator;
    
    protected $Receiver;
    
    /**
     * @param \Entities\Contact\Initiator $Inititator
     */
    public function setInitiator(Initiator $Inititator)
    {
	$this->Initiator = $Inititator;
    }
    
    /**
     * @param \Entities\Contact\Receivor $Receiver
     */
    public function setReceiver(Receivor $Receiver)
    {
	$this->Receiver = $Receiver;
    }
}