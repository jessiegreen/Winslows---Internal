<?php
namespace Forms\RtoProvider\Application;
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
    private $_Application;
    
    public function __construct(\Entities\Company\RtoProvider\Application $Application, $options = null)
    {
	$this->_Application = $Application;
	parent::__construct($options);
    }
    
    public function init()
    {	
	$this->addElement("text", "points", 
			    array(
				"label"		=> "Points",
				"size"		=> 3,
				"description"	=> "Please fill out the paper application and put the total points here.",
				'validators'	=> array(
				    array('Digits', false, array(
					    'messages' => array(
						'notDigits' => "Must be a number",
						'digitsStringEmpty' => ""
					))),
				    array('notEmpty', true, array(
					    'messages' => array(
						'isEmpty' => 'Points are required'
					    )
				    )),

				),
				"required"	=> true
			    ));
    }
}
