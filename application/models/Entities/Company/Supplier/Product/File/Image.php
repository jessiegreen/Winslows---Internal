<?php
/**
 * Name:
 * Location:
 *
 * @author     Jessie Green <jessie.winslows@gmail.com>
 * @copyright  2012 Winslows inc.
 * @version    Release: @package_version@
 */

namespace Entities\Company\Supplier\Product\File;

/** 
 * @Entity (repositoryClass="Repositories\Company\Supplier\Product\File\Image") 
 * @Table(name="company_supplier_product_file_images") 
 */
class Image extends \Entities\Company\File\Image\ImageAbstract
{
    /** 
     * @ManyToOne(targetEntity="\Entities\Company\Supplier\Product\ProductAbstract", inversedBy="Images")
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
}