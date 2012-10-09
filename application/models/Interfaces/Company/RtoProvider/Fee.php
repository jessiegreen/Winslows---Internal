<?php
namespace Interfaces\Company\RtoProvider;

interface Fee
{
    public function getFeePrice(\Dataservice_Price $Price);
}