<?php
namespace Forms\Company\Supplier\Product\Configurable\Instance\Option;
/**
 * Name:
 * Location:
 *
 * Description for class (if any)...
 *
 * @author     Jessie Green <jessie.winslows@gmail.com>
 * @copyright  2012 Winslows inc.
 * @version    Release: @package_version@
 */
class Subform extends \Zend_Form_SubForm
{    
    private $_Option;
    private $_Instance;
    
    public function __construct
    (
	\Entities\Company\Supplier\Product\Configurable\Instance $Instance,
	\Entities\Company\Supplier\Product\Configurable\Option $Option, 
	$options = null
    ) 
    {
	$this->_Instance    = $Instance;
	$this->_Option	    = $Option;
	
	parent::__construct($options);
    }
    
    public function init() 
    {
	$ids_array = array();
	
	$InstanceValues = $this->_Instance->getValues();
	
	/* @var $Parameter \Entities\Company\Supplier\Product\Configurable\Option\Parameter */
	foreach ($this->_Option->getParameters() as $Parameter) 
	{
	    $options	= array("" => "Please Select...");
	    $value	= "";
	    
	    /* @var $Value \Entities\Company\Supplier\Product\Configurable\Option\Parameter\Value */
	    foreach ($Parameter->getValues() as $Value)
	    {
		$options[$Value->getId()] = $Value->getName();
		if($InstanceValues->contains($Value))$value = $Value->getId();
	    }
	    
	    $this->addElement(
		    "select", 
		    (string) $Parameter->getId(), 
		    array(
			"required"	=> $Parameter->isRequired(),
			"label"		=> $Parameter->getName(),
			"belongsTo"	=> $this->_Option->getId(),
			"multioptions"	=> $options,
			"value"		=> $value
		    )
		);
	    $ids_array[] = $Parameter->getId();
	}
	
	$this->addDisplayGroup(
		$ids_array, 
		(string) $this->_Option->getId(), 
		array(
		    'legend'	=> $this->_Option->getName().
				    ($this->_Option->hasRequiredOption() ? 
					" *required" : ""),
		)
	);
	
	$displaygroup = $this->getDisplayGroup((string) $this->_Option->getId());
		$displaygroup->setDecorators(array(
                    'FormElements',
                    'Fieldset',
                    array('HtmlTag',array('tag'=>'div','style'=>'width:100%;'))
		));
		
	$this->setElementDecorators(array(
	    'ViewHelper',
	    'Errors',
	    array(array('data' => 'HtmlTag'), array('tag' => 'div', 'class' => 'element')),
	    array('Label', array('tag' => 'div', 'style' => 'width:110px;float:left;')),
	    array(array('row' => 'HtmlTag'), array('tag' => '<div')),
	));
	
	$this->setDecorators(array(
	    'FormElements',
	    array('HtmlTag', array('tag' => 'div'))
	));
	
	parent::init();
    }
}