<?php
namespace Entities\Company\Supplier\Product\Category\File;

/** 
 * @Entity (repositoryClass="Repositories\Company\Supplier\Product\File\Image") 
 * @Table(name="company_supplier_product_category_file_images") 
 * @Crud\Entity\Url(value="supplier-product-category-file-image")
 * @Crud\Entity\Permissions(view={"Admin"}, edit={"Admin"}, create={"Admin"}, delete={"Admin"})
 */
class Image extends \Entities\Company\File\Image\ImageAbstract
{
    /** 
     * @ManyToOne(targetEntity="\Entities\Company\Supplier\Product\Category", inversedBy="Images")
     * @var \Entities\Company\Supplier\Product\Category $Product
     */     
    protected $Category;
    
    /**
     * @param \Entities\Company\Supplier\Product\ProductAbstract $Product
     */
    public function setCategory(\Entities\Company\Supplier\Product\Category $Category)
    {
	$this->Category = $Category;
    }
    
    /**
     * @return \Entities\Company\Supplier\Product\Category
     */
    public function getCategory()
    {
	return $this->Category;
    }
}