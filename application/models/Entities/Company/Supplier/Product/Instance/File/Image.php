<?php
/**
 * Name:
 * Location:
 *
 * @author     Jessie Green <jessie.winslows@gmail.com>
 * @copyright  2012 Winslows inc.
 * @version    Release: @package_version@
 */

namespace Entities\Company\Supplier\Product\Instance\File;

/** 
 * @Entity (repositoryClass="Repositories\Company\Supplier\Product\Instance\File\Image") 
 * @Table(name="company_supplier_product_instance_file_images") 
 */
class Image extends \Entities\File\Image\ImageAbstract
{
    /** 
     * @ManyToOne(targetEntity="\Entities\Company\Supplier\Product\Instance\InstanceAbstract", inversedBy="Images")
     * @var \Entities\Company\Supplier\Product\Instance\InstanceAbstract $Instance
     */     
    protected $Instance;
    
    /**
     * @param \Entities\Company\Supplier\Product\Instance\InstanceAbstract $Product
     */
    public function setInstance(\Entities\Company\Supplier\Product\Instance\InstanceAbstract $Instance)
    {
	$this->Instance = $Instance;
    }
    
    /**
     * @return \Entities\Company\Supplier\Product\Instance\InstanceAbstract
     */
    public function getInstance()
    {
	return $this->Instance;
    }
}