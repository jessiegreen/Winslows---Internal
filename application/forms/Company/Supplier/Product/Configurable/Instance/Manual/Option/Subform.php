<?php
namespace Forms\Company\Supplier\Product\Configurable\Instance\Manual\Option;
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
    private $_ConfigurableOption;
    private $_Option;
    
    public function __construct
    (
	\Entities\Company\Supplier\Product\Configurable\Option $ConfigurableOption, 
	\Entities\Company\Supplier\Product\Configurable\Instance\Option $Option,
	$options = null
    ) 
    {
	$this->_ConfigurableOption  = $ConfigurableOption;
	$this->_Option		    = $Option;
	
	parent::__construct($options);
    }
    
    public function init() 
    {
	$Option_Values	    = $this->_Option->getValues();
	$ids_array	    = array();
	$option_group_id    = $this->_ConfigurableOption->getIndex().time().rand(0, 5000);
	
	/* @var $Parameter \Entities\Company\Supplier\Product\Configurable\Option\Parameter */
	foreach ($this->_ConfigurableOption->getParameters() as $Parameter) 
	{
	    $options	= array("" => "Please Select...");
	    $value	= "";
	    
	    /* @var $Value \Entities\Company\Supplier\Product\Configurable\Option\Parameter\Value */
	    foreach ($Parameter->getValues() as $Value)
	    {
		$options[$Value->getId()] = $Value->getName();
		if($Option_Values->contains($Value))$value = $Value->getId();
	    }
	    
	    $this->addElement(
		    "select", 
		    (string) $Parameter->getId(), 
		    array(
			"required"	=> $Parameter->isRequired(),
			"label"		=> $Parameter->getName(),
			"belongsTo"	=> $option_group_id,
			"multioptions"	=> $options,
			"value"		=> $value
		    )
		);
	    $ids_array[] = $Parameter->getId();
	}
	
	$this->addDisplayGroup(
		$ids_array, 
		$option_group_id, 
		array(
		    'legend'	=> $this->_ConfigurableOption->getName().
				    ($this->_ConfigurableOption->hasRequiredOption() ? 
					" *required" : ""),
		)
	);
	
	$displaygroup = $this->getDisplayGroup($option_group_id);
	
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