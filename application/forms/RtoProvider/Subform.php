<?php
namespace Forms\RtoProvider;
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
    private $_RtoProvider;
    
    public function __construct($options = null, \Entities\RtoProvider $RtoProvider = null)
    {
	$this->_RtoProvider = $RtoProvider;
	parent::__construct($options);
    }
    
    public function init()
    {		
	$this->addElement('text', 'name', array(
            'required'	    => true,
            'label'	    => 'Name:',
	    'belongsTo'	    => 'rto_provider',
	    'value'	    => $this->_RtoProvider ? $this->_RtoProvider->getName() : ""
        ));
	
	$this->addElement('text', 'dba', array(
            'required'	    => true,
            'label'	    => 'DBA:',
	    'belongsTo'	    => 'rto_provider',
	    'value'	    => $this->_RtoProvider ? $this->_RtoProvider->getDba() : ""
        ));
	
	$this->addElement('text', 'name_index', array(
            'required'	    => true,
            'label'	    => 'Name Index:',
	    'belongsTo'	    => 'rto_provider',
	    'value'	    => $this->_RtoProvider ? $this->_RtoProvider->getNameIndex() : ""
        ));
	
	$this->addElement('textarea', 'description', array(
            'required'	    => false,
            'label'	    => 'Description:',
	    'belongsTo'	    => 'rto_provider',
	    'rows'	    => '10',
	    'cols'	    => '35',
	    'value'	    => $this->_RtoProvider ? $this->_RtoProvider->getDescription() : ""
        ));
    }
}

?>
