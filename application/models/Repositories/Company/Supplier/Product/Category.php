<?php

namespace Repositories\Company\Supplier\Product;

use Doctrine\ORM\EntityRepository;

class Category extends EntityRepository
{  
    /**
     * @param \Entities\Company $Company
     * @return array
     */
    public function findByCompany(\Entities\Company $Company)
    {
	$qb = $this->createQueryBuilder("C");
	
	return $qb
		    ->leftJoin("C.Products", "P")
		    ->leftJoin("P.Supplier", "S")
		    ->leftJoin("S.Companies", "CO")
		    ->where($qb->expr()->eq('CO.id', ':company_id'))
		    ->setParameter("company_id", $Company->getId())
		    ->orderBy("C.name", "ASC")
		    ->getQuery()
		    ->getResult();
    }
    
    /**
     * @param \Entities\Company $Company
     * @return array
     */
    public function findByCompanyAndBeingTop(\Entities\Company $Company)
    {
	$qb = $this->createQueryBuilder("C");
	
	return $qb
		    ->leftJoin("C.Products", "P")
		    ->leftJoin("P.Supplier", "S")
		    ->leftJoin("S.Companies", "CO")
		    ->where($qb->expr()->eq('CO.id', ':company_id'))
		    ->andWhere($qb->expr()->isNull("C.parent"))
		    ->setParameter("company_id", $Company->getId())
		    ->orderBy("C.name", "ASC")
		    ->getQuery()
		    ->getResult();
    }
}