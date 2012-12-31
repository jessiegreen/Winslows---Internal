<?php
namespace Entities\File;

/** 
 * @Entity (repositoryClass="Repositories\File\FileAbstract") 
 * @MappedSuperclass
 * @HasLifecycleCallbacks
 * @Table(name="file_fileabstracts") 
 * @InheritanceType("JOINED")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({"file_image_resizedclone" = "\Entities\File\Image\ResizedClone",
 *			"company_supplier_product_file_image" = "\Entities\Company\Supplier\Product\File\Image",
 * 			"company_supplier_product_category_file_image" = "\Entities\Company\Supplier\Product\Category\File\Image",
 *			"company_supplier_product_instance_file_image" = "\Entities\Company\Supplier\Product\Instance\File\Image"
 *		    })
 */
abstract class FileAbstract extends \Dataservice_Doctrine_Entity
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     * @var integer
     */
    protected $id;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $original_file_name
     */
    protected $original_file_name;

    /** 
     * @Column(type="string", length=8) 
     * @var string $extension
     */
    protected $extension;
    
    /** 
     * @Column(type="string", length=100) 
     * @var string $file_type
     */
    protected $file_type;
    
    /** 
     * @Column(type="integer", length=20) 
     * @var integer $file_size
     */
    protected $file_size;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $name
     */
    protected $name;
    
    /** 
     * @Column(type="string", length=1500) 
     * @var string $description
     */
    protected $description;

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
    public function getFileType()
    {
        return $this->file_type;
    }

    /**
     * @param string $file_type
     */
    public function setFileType($file_type)
    {
        $this->file_type = $file_type;
    }
    
    /**
     * @return integer
     */
    public function getFileSize()
    {
        return $this->file_size;
    }

    /**
     * @param string $file_size
     */
    public function setFileSize($file_size)
    {
        $this->file_size = $file_size;
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
    public function getFullPath()
    {
	return $this->getFileStoreDirectoryFromConfig()."/".$this->getId().".".$this->getExtension();
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
    public function getName()
    {
        return $this->name;
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
    
    /**
     * @return integer
     */
    public function getDirectory()
    {
	return $this->getFileStoreDirectoryFromConfig();
    }
    
    /**
     * @param array $file_info_array
     */
    public function setFileParamsFromArray($file_info_array)
    {
	$this->setOriginalFileName(pathinfo($file_info_array["name"], PATHINFO_FILENAME));
	$this->setExtension(pathinfo($file_info_array["name"], PATHINFO_EXTENSION));
	$this->setFileSize($file_info_array["size"]);
	$this->setFileType($file_info_array["type"]);
    }
    
    public function validateUpload()
    {
	$this->validateSize();
	$this->validateType();
    }
    
    /**
     * @throws \Exception
     */
    public function validateType()
    {
	$allowed_types = (array) json_decode($this->getAllowedTypesFromConfig());
	
	if(!in_array($this->getExtension(), $allowed_types))
	    throw new \Exception("File type not allowed. Only ".  implode(", ", $allowed_types));
    }
    
    /**
     * @throws \Exception
     */
    public function validateSize()
    {
	$max_size   = $this->getMaxFileUploadFromConfig();
	$file_size  = $this->getFileSize();
	
	if($file_size > $max_size)
	    throw new \Exception("File size is too big. Upload limited to ".$max_size."MB. ".$file_size."MB uploaded.");
    }
    
    /**
     * @param string $temp_full_path
     * @throws \Exception
     */
    public function uploadFile($temp_full_path)
    {
	$this->validateUpload();
	
	$destination_directory	= $this->getFileStoreDirectoryFromConfig();
	$dest_file_path		= $this->getFileStoreDirectoryFromConfig()."\\".$this->getId().".".$this->getExtension();

	if(!file_exists($temp_full_path))
	    throw new \Exception("Temp file not found for upload: path=".$temp_full_path);

	if(!is_dir($destination_directory))
	    if(!mkdir($destination_directory, 0777, true))
		throw new \Exception("Destination directory not created:".$destination_directory);
	    
	if(!move_uploaded_file($temp_full_path, $dest_file_path))
	    throw new \Exception("Could not move file");
    }
    
    /**
     * @return type
     */
    protected function getConfig()
    {
	return \Zend_Registry::get('config')->dataService->fileStore;
    }

    /**
     * @return string
     */
    protected function getFileStoreDirectoryFromConfig()
    {
	$config = $this->getConfig();
	
	return realpath($config->path);
    }
    
    /**
     * @return int
     */
    protected function getMaxFileUploadFromConfig()
    {
	$config = $this->getConfig();
	
	return $config->max_upload_size;
    }
    
    /**
     * @return array
     */
    protected function getAllowedTypesFromConfig()
    {
	$config = $this->getConfig();

	return $config->allowed_types;
    }
    
    /**
     * @PostPersist
     */
    public function prePersistValidate()
    {
	$this->validateUpload();
    }
}
