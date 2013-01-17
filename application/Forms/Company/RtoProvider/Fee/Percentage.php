<?php
namespace Forms\Company\RtoProvider\Fee;
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
class Percentage extends \Dataservice_Form
{
    private $_Percentage;
    
    public function __construct(\Entities\Company\RtoProvider\Fee\Percentage $Percentage, $options = null)
    {
	$this->_Percentage = $Percentage;
	
	parent::__construct($options);
    }
    
    public function init($options = array())
    {	
        $form = new Percentage\Subform($this->_Percentage, $options);
	
	$this->addSubForm($form, "company_rto_provider_fee_percentage");
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}