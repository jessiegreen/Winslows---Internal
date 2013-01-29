<?php
namespace Interfaces\Company\Website;

interface Account
{
    /**
     * @return \Entities\Company\Person\PersonAbstract
     */
    public function getPerson();
}
