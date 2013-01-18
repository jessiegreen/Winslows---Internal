<?php
class Dataservice_Form_Element_Company_TimeClock_WorkWeek_Select extends Zend_Form_Element_Select
{
    /**
     * @var DateTime 
     */
    private $StartDate;
    
    public function __construct($spec, $options = null, DateTime $StartDate = null)
    {
	if($StartDate === null)
	{
	    $StartDate = new DateTime();
	    
	    $StartDate->setDate($StartDate->format("Y"), "01", "01");
	}
	
	$this->StartDate = $StartDate;
	
	parent::__construct($spec, $options);
    }
    
    public function init()
    {	
	$TodayDate = new DateTime();
	
	while($this->StartDate->format("l") !== "Saturday")
	{
	    $this->StartDate->sub(new DateInterval("P1D"));
	}
	
        while($this->StartDate < $TodayDate)
	{
	    $this->addMultiOption(
		    $this->StartDate->format("Y-m-d"), 
		    $this->StartDate->format("m-d-Y")." - ".
			$this->StartDate->add(new DateInterval('P6D'))->format("m-d-Y")
		);
	    
	    $this->StartDate->add(new DateInterval('P1D'));
	}
    }
}