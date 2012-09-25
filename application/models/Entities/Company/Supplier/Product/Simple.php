<?php
/**
 * Name:
 * Location:
 *
 * @author     Jessie Green <jessie.winslows@gmail.com>
 * @copyright  2012 Winslows inc.
 * @version    Release: @package_version@
 */

namespace Entities\Company\Supplier\Product;

/** 
 * @Entity (repositoryClass="Repositories\Company\Supplier\Product\Simple") 
 * @Table(name="company_supplier_product_simples") 
 */
class Simple extends ProductAbstract
{
    /**
     * @Column(type="decimal", precision=40, scale=2)
     * @var decimal $price
     */
    protected $price;
    
    /**
     * @return decimal
     */
    public function getPrice()
    {
	return $this->price;
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