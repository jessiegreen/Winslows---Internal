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
    
    public function getTimeClockEntriesForToday(\Entities\Company\Employee $Employee)
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
    
    public function getAutocompleteLeadsArrayFromTerm($term = "", $max_results = 20, \Entities\Company\Employee $Employee = null)
    {
	$max_results	= 20;
	$conn		= $this->_em->getConnection();
	
	$sql = "SELECT DISTINCT 
			p0_.id AS id,
			p0_.first_name AS first_name,
			p0_.last_name AS last_name,
			p3_.area_code AS area_code, 
			p3_.num1 AS num1, 
			p3_.num2 AS num2,
			a4_.address_1 AS address_1
		FROM company_leads l1_ 
		INNER JOIN person_personabstracts p0_ ON l1_.id = p0_.id 
		LEFT JOIN company_leads c2_ ON l1_.id = c2_.id 
		LEFT JOIN person_phonenumbers p6_ ON p0_.id = p6_.person_id 
		LEFT JOIN phonenumber_phonenumberabstracts p3_ ON p3_.id = p6_.id 
		LEFT JOIN person_addresses p5_ ON p0_.id = p5_.person_id 
		LEFT JOIN address_addressabstracts a4_ ON p5_.id = a4_.id 
		WHERE 
		    CONCAT(CONCAT(IFNULL(p0_.first_name,''), ' ', IFNULL(p0_.last_name,'')), ' ' , CONCAT(IFNULL(p3_.area_code,''), ' ', IFNULL(p3_.num1,''), ' ', IFNULL(p3_.num2,'')), ' ', IFNULL(a4_.address_1,''))
		    LIKE :term  
		    and 
		    p0_.discr='company_lead' ".
		    ($Employee && $Employee->getId() ? " and l1_.Employee_id=".$Employee->getId() : "").
		" ORDER BY p0_.first_name ASC, p0_.last_name ASC 
		LIMIT $max_results";
	
	/* @var $sth Doctrine\DBAL\Statement */
	$sth = $conn->prepare($sql);
	
	$sth->execute(array(":term" => "%".$term."%"));
	
	$results    = $sth->fetchAll();
	$return	    = array();
	
	foreach($results as $result)
	{
	    $label = $result["first_name"]." ".$result["last_name"];
	    
	    if($result["area_code"])$label .= " :: (".$result["area_code"].")".$result["num1"]."-".$result["num2"];
	    
	    if($result["address_1"])$label .= " :: ".$result["address_1"];
	    
	    $return[] = array(
			    "id" => $result["id"],
			    "value" => $result["first_name"]." ".$result["last_name"],
			    "label" => $label
		);
	}
	return $return;
    }
    
    public function getEmployees()
    {
	return $this->_em->getRepository("Entities\Company\Employee")
		->findBy(array(), array("first_name" => "ASC"));
    }
}