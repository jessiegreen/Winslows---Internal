<?php
namespace Forms\Company\RtoProvider\Program\ManageFees;
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
class Subform extends \Zend_Form_SubForm
{
    private $_Program;
    
    public function __construct(\Entities\Company\RtoProvider\Program $Program, $options = null)
    {
	$this->_Program = $Program;
	
	parent::__construct($options);
    }
    
    public function init()
    {	
	$values = array();
	
	if($this->_Program)
	{
	    foreach($this->_Program->getFees() as $Fee)
	    {
		$values[] = $Fee->getId();
	    }
	}
	
	$this->addElement(new \Dataservice_Form_Element_Company_RtoProvider_Program_FeesMultiCheckbox("fees_checks", array(
            'required'	    => false,
            'label'	    => 'Fees:',
	    'belongsTo'	    => 'company_rto_provider_program_managefees',
	    'value'	    => $values
        )));
    }
}