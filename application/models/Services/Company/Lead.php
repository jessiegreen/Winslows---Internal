<?php
namespace Services\Company;

class Lead extends \Dataservice_Service_ServiceAbstract
{
    public function getAutocompleteLeadsArrayFromTerm($term = "", $descriminator = "company_lead", $max_results = 20)
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
		    p0_.discr='$descriminator' 
		ORDER BY p0_.first_name ASC, p0_.last_name ASC 
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
	    
    public function getAllAllowedLeads()
    {
	$Employee   = \Services\Auth::factory()->getIdentityPerson();
	
	if($Employee->getAccount()->hasRole('Admin') || $Employee->getAccount()->hasRole('Sales_Manager')){
	    return $this->_em->getRepository("Entities\Company\Lead")->findBy(array(), array("last_name" => "ASC", "first_name" => "ASC"));
	}
	/* @var $Employee \Entities\Employee */
	return $Employee->getLeads();
    }
}

?>

