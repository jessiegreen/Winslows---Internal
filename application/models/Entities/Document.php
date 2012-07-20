<?php

namespace Entities;
use Doctrine\Common\Collections\ArrayCollection;

/** 
 * @Entity (repositoryClass="Repositories\Document") 
 * @Table(name="documents") 
 * @InheritanceType("JOINED")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({"persondocument" = "PersonDocument"})
 * @HasLifecycleCallbacks
 */
class Document  implements \Interfaces\Document
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /** @Column(type="string", length=255) */
    protected $name;
    
    /** @Column(type="string", length=255) */
    protected $type;
    
    /** @Column(type="string", length=255) */
    protected $document_path;
    
    /** @Column(type="string", length=255) */
    protected $extension;
    
    /** @Column(type="string", length=255) */
    protected $original_file_name;
    
    /** @Column(type="string", length=255) */
    protected $uploaded_by;

    /** @Column(type="datetime") */
    protected $created;

    /** @Column(type="datetime") */
    protected $updated;
    
    protected $typeoptions = array(
	"generic"   => "Generic Document"
    );
    
    /**
     * @ManyToOne(targetEntity="WebAccount")
     * @JoinColumn(name="webaccount_id", referencedColumnName="id")
     * @var $WebAccount WebAccount
     */
    private $WebAccount;

    public function __construct()
    {
      $this->created		= $this->updated = new \DateTime("now");
    }

    /**
     * @PreUpdate
     */
    public function updated()
    {
        $this->updated = new \DateTime("now");
    }
    
    public function setWebAccountUploadedBy(WebAccount $WebAccount){
	$this->WebAccount = $WebAccount;
    }
    
    public function getWebAccountUploadedBy(){
	return $this->WebAccount;
    }

    /**
     * Retrieve document id
     */
    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
    
    public function getExtension()
    {
        return $this->extension;
    }

    public function setExtension($extension)
    {
        $this->extension = $extension;
    }
    
    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
	if(!key_exists($type, $this->getTypeOptions()))
	    throw new Exception("Type must be in Type Options");
	$this->type = $type;
    }
    
    public function getTypeDisplay(){
	if(!$this->type)return "";
	$array = $this->getTypeOptions();
	if(!key_exists($this->type, $array))
	    throw new Exception("Could not get Result Display. Key '".$this->type."' does not exist");
	return $array[$this->type];
    }
    
    public function getOriginalFileName()
    {
        return $this->original_file_name;
    }

    public function setOriginalFileName($original_file_name)
    {
        $this->original_file_name = $original_file_name;
    }
    
    public function getDocumentPath()
    {
        return $this->document_path;
    }

    public function setDocumentPath($document_path)
    {
        $this->document_path = $document_path;
    }
    
    public function getCreated()
    {
        return $this->created;
    }

    public function setCreated($created)
    {
        $this->created = $created;
    }

    public function getUpdated()
    {
        return $this->updated;
    }
    
    public function getTypeOptions(){
	return $this->typeoptions;
    }

    public function populate(array $array){
	foreach ($array as $key => $value) {
	    if(property_exists($this, $key)){
		$this->$key = $value;
	    }
	}
    }
}