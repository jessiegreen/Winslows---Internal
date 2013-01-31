<?php
namespace Forms\Company\Dealer;
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
class Subform extends \Zend_Form_SubForm
{
    private $_Dealer;
    
    public function __construct($options = null, \Entities\Company\Dealer $Dealer = null)
    {
	$this->_Dealer = $Dealer;
	parent::__construct($options);
    }
    
    public function init()
    {		
	$this->addElement(new \Dataservice_Form_Element_CompanySelect("company_id", array(
            'required'	    => true,
            'label'	    => 'Company:',
	    'belongsTo'	    => 'company_dealer',
	    'value'	    => $this->_Dealer && $this->_Dealer->getCompany() ? $this->_Dealer->getCompany()->getId() : ""
        )));
	
	$this->addElement('text', 'name', array(
            'required'	    => true,
            'label'	    => 'Name:',
	    'belongsTo'	    => 'company_dealer',
	    'value'	    => $this->_Dealer ? $this->_Dealer->getName() : ""
        ));
	
	$this->addElement('text', 'dba', array(
            'required'	    => true,
            'label'	    => 'DBA:',
	    'belongsTo'	    => 'company_dealer',
	    'value'	    => $this->_Dealer ? $this->_Dealer->getDba() : ""
        ));
	
	$this->addElement('text', 'name_index', array(
            'required'	    => true,
            'label'	    => 'Name Index:',
	    'belongsTo'	    => 'company_dealer',
	    'value'	    => $this->_Dealer ? $this->_Dealer->getNameIndex() : ""
        ));
	
	$this->addElement('textarea', 'description', array(
            'required'	    => false,
            'label'	    => 'Description:',
	    'belongsTo'	    => 'company_dealer',
	    'rows'	    => '10',
	    'cols'	    => '35',
	    'value'	    => $this->_Dealer ? $this->_Dealer->getDescription() : ""
        ));
    }
}