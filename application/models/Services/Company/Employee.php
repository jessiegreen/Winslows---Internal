<?php
namespace Services\Company;

class Employee extends \Dataservice_Service_ServiceAbstract
{
    /**
     * @return Employee 
     */
    public static function factory()
    {
	return parent::factory();
    }

    public function clockInOutEmployee(\Entities\Company\Employee $Employee)
    {
	$Entry = new \Entities\Company\TimeClock\Entry;
	
	$Entry->setTimeClock($Employee->getCompany()->getTimeClock());
	$Entry->setDateTime(new \Dataservice\DateTime);
	$Entry->setIpAddress($_SERVER['REMOTE_ADDR']);
	
	$Employee->addTimeClockEntry($Entry);
	
	$this->_em->persist($Employee);
	$this->_em->flush();
    }
    
    public function isEmployeeClockedIn(\Entities\Company\Employee $Employee)
    {
	$qb	= $this->_em->createQueryBuilder();
	$Today	= new \Dataservice\DateTime();
	
	$qb->select('E')
	    ->from("Entities\Company\TimeClock\Entry", 'E')
	    ->where($qb->expr()->eq('E.Employee', $Employee->getId()))
	    ->andWhere($qb->expr()->gte('E.datetime', "'".$Today->format("Y-m-d 00:00:00")."'"))
	    ->andWhere($qb->expr()->lte('E.datetime', "'".$Today->format("Y-m-d 23:59:59")."'"))
	    ->orderBy('E.datetime');
	
	return $qb->getQuery()->getResult();
	
    }
    
    public function getEmployees()
    {
	return $this->_em->getRepository("Entities\Company\Employee")
		->findBy(array(), array("first_name" => "ASC"));
    }
}