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
class Form_Lead_Add extends Form_Lead_Lead
{        
    public function __construct($options = null) {
	parent::__construct($options, $this->_Lead);
    }
    
    public function init($options = array())
    {
	$i = 1;
	
        ${"form".$i} = new Form_Lead_Lead($options);
	unset(${"form".$i}->submit);
        $this->addElements(${"form".$i}->getElements());
	$i++;
	
	$this->addDisplayGroup(array(
		    'id',
		    'company',
                    'first_name',
                    'middle_name',
                    'last_name',
                    'suffix'
        
            ),'lead',array('legend' => 'Person Information'));
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}

