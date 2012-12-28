<?php
namespace Interfaces\Website;

interface Account
{
    /**
     * @return \Entities\Person\PersonAbstract
     */
    public function getPerson();
}
