<?php
namespace Services\Company\Lead\Quote\Item;

class SaleType extends \Dataservice_Service_ServiceAbstract
{
    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getAllSaleTypes()
    {
	return $this->_em->getRepository("Entities\Company\Lead\Quote\Item\SaleType\SaleTypeAbstract")->findBy(array());
    }
    
    public function find($sale_type_id)
    {
	return $this->_em->getRepository("Entities\Company\Lead\Quote\Item\SaleType\SaleTypeAbstract")->find($sale_type_id);
    }
}