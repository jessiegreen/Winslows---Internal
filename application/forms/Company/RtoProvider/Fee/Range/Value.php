<?php
namespace Forms\Company\RtoProvider\Fee\Range;
/**
 * Name:
 * Company:
 *
 * Description for class (if any)...
 *
 * @author     Jessie Green <jessie.winslows@gmail.com>
 * @copyright  2012 Winslows inc.
 * @version    Release: @package_version@
 */
class Value extends \Dataservice_Form
{
    private $_Value;
    
    public function __construct(\Entities\Company\RtoProvider\Fee\Range\Value $Value, $options = null)
    {
	$this->_Value = $Value;
	
	parent::__construct($options);
    }
    
    public function init($options = array())
    {	
        $form = new Value\Subform($this->_Value, $options);
	
	$this->addSubForm($form, "company_rto_provider_fee_range_value");
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}