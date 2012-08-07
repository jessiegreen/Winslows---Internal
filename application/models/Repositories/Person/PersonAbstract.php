<?php

namespace Repositories\Person;

use Doctrine\ORM\EntityRepository;

class PersonAbstract extends EntityRepository
{  
    public function findNewestPeople() 
    {
	$now	    = new \DateTime("now");
	$oneDayAgo  = $now->sub(new \DateInterval('P1D'))
			 ->format('Y-m-d h:i:s');
	$qb	    = $this->_em->createQueryBuilder();
	$qb->select('p.first_name, p.middle_name, p.last_name, p.suffix')
	    ->from('Entities\Person\PersonAbstract', 'p')
	    ->where('p.created >= :date')
	    ->setParameter('date', $oneDayAgo);

	return $qb->getQuery()->getResult();
    }  
}