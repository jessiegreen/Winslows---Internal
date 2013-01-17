<?php
namespace Forms\Company\Supplier\Product\Configurable\Instance\Manual;
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
class Option extends \Dataservice_Form
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
    
    public function init($options = array())
    {
	$option_group_id    = $this->_ConfigurableOption->getIndex().time().rand(0, 5000);
	$form		    = new \Forms\Company\Supplier\Product\Configurable\Instance\Manual\Option\Subform($this->_ConfigurableOption, $this->_Option, $options);
	
	$this->addSubForm($form, $option_group_id);
	
	$this->setDecorators(array(
	    'FormElements',
	    array('HtmlTag', array('tag' => 'div', 'class' => 'j_form', 'style' => 'margin-top:10px;'))
	));
    }
}

?>
