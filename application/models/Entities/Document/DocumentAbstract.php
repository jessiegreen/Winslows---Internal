<?php

namespace Entities\Document;

/** 
 * @Entity (repositoryClass="Repositories\Document\DocumentAbstract") 
 * @Table(name="document_documentabstracts") 
 * @InheritanceType("JOINED")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({"person_document" = "\Entities\Person\Document"})
 * @HasLifecycleCallbacks
 */
class DocumentAbstract  extends \Dataservice_Doctrine_Entity implements \Interfaces\Document
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
     * @var string $type
     */
    protected $type;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $document_path
     */
    protected $document_path;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $extension
     */
    protected $extension;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $original_file_name
     */
    protected $original_file_name;

    /** 
     * @Column(type="datetime") 
     * @var \DateTime $created
     */
    protected $created;

    /** 
     * @Column(type="datetime") 
     * @var \DateTime $created
     */
    protected $updated;
    
    /**
     * @var array $typeoptions
     */
    protected $typeoptions = array(
	"generic"   => "Generic Document"
    );
    
    /**
     * @ManyToOne(targetEntity="\Entities\Company\Location\Employee")
     * @var \Entities\Company\Location\Employee $Employee
     */
    private $Employee;

    public function __construct()
    {
	$this->created = $this->updated = new \DateTime("now");
    }

    /**
     * @PreUpdate
     */
    public function updated()
    {
        $this->updated = new \DateTime("now");
    }
    
    /**
     * @param \Entities\Company\Location\Employee $Employee
     */
    public function setEmployee(\Entities\Company\Location\Employee $Employee)
    {
	$this->Employee = $Employee;
    }
    
    /**
     * @return \Entities\Company\Location\Employee
     */
    public function getEmployee()
    {
	return $this->Employee;
    }

    /**
     * @var integer
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
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * @param string $extension
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;
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
	    throw new \Exception("Type must be in Type Options");
	$this->type = $type;
    }
    
    /**
     * @return string
     */
    public function getTypeDisplay(){
	if(!$this->type)return "";
	$array = $this->getTypeOptions();
	if(!key_exists($this->type, $array))
	    throw new Exception("Could not get Result Display. Key '".$this->type."' does not exist");
	return $array[$this->type];
    }
    
    /**
     * @return string
     */
    public function getOriginalFileName()
    {
        return $this->original_file_name;
    }

    /**
     * @param string $original_file_name
     */
    public function setOriginalFileName($original_file_name)
    {
        $this->original_file_name = $original_file_name;
    }
    
    /**
     * @return string
     */
    public function getDocumentPath()
    {
        return $this->document_path;
    }

    /**
     * @param string $document_path
     */
    public function setDocumentPath($document_path)
    {
        $this->document_path = $document_path;
    }
    
    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param \DateTime $created
     */
    public function setCreated(\DateTime $created)
    {
        $this->created = $created;
    }

    /**
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }
    
    /**
     * @return array
     */
    public function getTypeOptions()
    {
	return $this->typeoptions;
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