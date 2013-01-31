<?php
namespace Entities\Company\Supplier\Product;

/** 
 * @Entity (repositoryClass="Repositories\Company\Supplier\Product\Simple") 
 * @Table(name="company_supplier_product_simples") 
 * @Crud\Entity\Url(value="supplier-product-simple")
 * @Crud\Entity\Permissions(view={"Admin"}, edit={"Admin"}, create={"Admin"}, delete={"Admin"})
 */
class Simple extends ProductAbstract
{
    /**
     * @Column(type="decimal", precision=40, scale=2)
     * @var decimal $price
     */
    protected $price;
    
    /**
     * @return \Dataservice_Price
     */
    public function getPrice()
    {
	$Price = new \Dataservice_Price();
	
	$Price->setPrice($this->price);
	
	return $Price;
    }
    
    /**
     * @param integer $price
     */
    public function setPrice($price)
    {
	$this->price = $price;
    }
    
    /**
     * @return string
     */
    public function getDescriminator() {
	return parent::TYPE_Simple;
    }
}