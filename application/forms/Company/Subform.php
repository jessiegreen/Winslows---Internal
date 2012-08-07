<?php
namespace Form\Company;
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
    private $_Company;
    
    public function __construct($options = null, \Entities\Company $Company = null)
    {
	$this->_Company = $Company;
	parent::__construct($options);
    }
    
    public function init()
    {		
	$this->addElement('text', 'name', array(
            'required'	    => true,
            'label'	    => 'Name:',
	    'belongsTo'	    => 'company',
	    'value'	    => $this->_Company ? $this->_Company->getName() : ""
        ));
	
	$this->addElement('text', 'dba', array(
            'required'	    => true,
            'label'	    => 'DBA:',
	    'belongsTo'	    => 'company',
	    'value'	    => $this->_Company ? $this->_Company->getDba() : ""
        ));
	
	$this->addElement('text', 'name_index', array(
            'required'	    => true,
            'label'	    => 'Name Index:',
	    'belongsTo'	    => 'company',
	    'value'	    => $this->_Company ? $this->_Company->getNameIndex() : ""
        ));
	
	$this->addElement('textarea', 'description', array(
            'required'	    => false,
            'label'	    => 'Description:',
	    'belongsTo'	    => 'company',
	    'rows'	    => '10',
	    'cols'	    => '35',
	    'value'	    => $this->_Company ? $this->_Company->getDescription() : ""
        ));
    }
}

?>
