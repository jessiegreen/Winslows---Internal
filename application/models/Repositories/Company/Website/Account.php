<?php

namespace Repositories\Company\Website;

use Doctrine\ORM\EntityRepository;

class Account extends EntityRepository
{  
    public function __construct($em, \Doctrine\ORM\Mapping\ClassMetadata $class) {
	parent::__construct($em, $class);
    }
}