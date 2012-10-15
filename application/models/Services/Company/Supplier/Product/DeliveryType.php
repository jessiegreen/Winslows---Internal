<?php
namespace Services\Company\Supplier\Product;

class DeliveryType extends \Dataservice_Service_ServiceAbstract
{
    public function getAllDeliveryTypes()
    {
	return $this->_em->getRepository("Entities\Company\Supplier\Product\DeliveryType\DeliveryTypeAbstract")->findBy(array(), array("name" => "ASC"));
    }
}