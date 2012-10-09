<?php
namespace Forms\Company\RtoProvider\Fee\Percentage;
/**
 * Name:
 * Product:
 *
 * Description for class (if any)...
 *
 * @author     Jessie Green <jessie.winslows@gmail.com>
 * @copyright  2012 Winslows inc.
 * @version    Release: @package_version@
 */
class Subform extends \Forms\Company\RtoProvider\Fee\Subform
{
    private $_Percentage;
    
    public function __construct(\Entities\Company\RtoProvider\Fee\Percentage $Percentage, $options = null)
    {
	$this->_Percentage = $Percentage;
	
	parent::__construct($Percentage, $options);
    }
    
    public function init()
    {
	parent::init();
	
	$this->addElement('text', 'percentage', array(
            'required'	    => true,
            'label'	    => 'Percentage:',
	    'belongsTo'	    => 'company_rto_provider_fee_percentage',
	    'value'	    => $this->_Percentage ? $this->_Percentage->getPercentage() : ""
        ));
    }
}
