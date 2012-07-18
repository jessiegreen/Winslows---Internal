<?php

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
class Form_Lead_Subform extends Form_Person_Subform
{    
    private $_Lead;
    
    public function __construct($options = null, Entities\Lead $Lead = null) {
	$this->_Lead = $Lead;
	parent::__construct($options, $this->_Lead);
    }
    
    public function init($options = array())
    {
	if($this->_Lead){
	    $this->addElement('hidden', 'id', array(
		'required'  => true,
		'belongsTo' => 'lead',
		'value'	    => $this->_Lead ? $this->_Lead->getId() : ""
	    ));
	}
	
        $this->addElement('text', 'company', array(
            'required'	    => false,
            'label'	    => 'Company:',
	    'belongsTo'	    => 'lead',
	    'value'	    => $this->_Lead ? $this->_Lead->getCompany() : ""
        ));
	parent::init($options);
    }
}

?>
