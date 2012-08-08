<?php
namespace Forms\Company\Lead\Quote\Item;
use Entities\Company\Lead\Quote\Item as Item;
/**
 * Name:
 * QuoteProduct:
 *
 * Description for class (if any)...
 *
 * @author     Jessie Green <jessie.winslows@gmail.com>
 * @copyright  2012 Winslows inc.
 * @version    Release: @package_version@
 */
class Subform extends \Zend_Form_SubForm
{
    private $_Item;
    
    public function __construct(Item $Item, $options = null)
    {
	$this->_Item = $Item;
	parent::__construct($options);
    }
    
    public function init()
    {	
	if($this->_Item->getInstance()){
	    /* @var $Option \Entities\Company\Supplier\Product\Configurable\Option */
	    foreach ($this->_Item->getInstance()->getProduct()->getOptions() as $Option) {
		$ids_array = array();
		/* @var $Parameter \Entities\Company\Supplier\Product\Configurable\Option\Parameter */
		foreach ($Option->getParameters() as $Parameter) {
		    $options = array("" => "Please Select...");
		    /* @var $Value \Entities\Company\Supplier\Product\Configurable\Option\Parameter\Value */
		    foreach ($Parameter->getValues() as $Value) {
			$options[$Value->getId()] = $Value->getName();
		    }
		    $this->addElement(
			    "select", 
			    $Option->getIndex()."-".$Parameter->getIndex(), 
			    array(
				"required"	=> false,
				"label"		=> $Parameter->getName(),
				"belongsTo"	=> $Option->getIndex(),
				"multioptions"	=> $options
			    )
			);
		    $ids_array[] = $Option->getIndex()."-".$Parameter->getIndex();
		}
		$this->addDisplayGroup(
			$ids_array, 
			$Option->getIndex(), 
			array(
			    'legend'	=> $Option->getName(),
			)
		);
		$displaygroup = $this->getDisplayGroup($Option->getIndex());
		$displaygroup->setDecorators(array(
                    'FormElements',
                    'Fieldset',
                    array('HtmlTag',array('tag'=>'div','style'=>'width:30%;min-height:180px;float:left;'))
		));
	    }
	}
    }
}

?>
