<?php
namespace Entities\Company\Supplier\Product\File;

/** 
 * @Entity (repositoryClass="Repositories\Company\Supplier\Product\File\Image") 
 * @Table(name="company_supplier_product_file_images") 
 * @Crud\Entity\Url(value="supplier-product-file-image")
 * @Crud\Entity\Permissions(view={"Admin"}, edit={"Admin"}, create={"Admin"}, delete={"Admin"})
 */
class Image extends \Entities\Company\File\Image\ImageAbstract
{
    /** 
     * @ManyToOne(targetEntity="\Entities\Company\Supplier\Product\ProductAbstract", inversedBy="Images")
     * @Crud\Relationship\Permissions()
     * @var \Entities\Company\Supplier\ProductAbstract $Product
     */     
    protected $Product;
    
    /**
     * @param \Entities\Company\Supplier\Product\ProductAbstract $Product
     */
    public function setProduct(\Entities\Company\Supplier\Product\ProductAbstract $Product)
    {
	$this->Product = $Product;
    }
    
    /**
     * @return ProductAbstract
     */
    public function getProduct()
    {
	return $this->Product;
    }
    
    public function populate(array $array)
    {
	$types = array("configurable_id", "simple_id");
	
	foreach($types as $type)
	{
	    $Product = $this->_getEntityFromArray($array, "Entities\Company\Supplier\Product\ProductAbstract", $type);

	    if($Product && $Product->getId())
	    {
		$this->setProduct($Product);
		
		break;
	    }
	}
	
	parent::populate($array);
    }
}