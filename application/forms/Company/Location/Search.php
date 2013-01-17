<?php
namespace Forms\Company\Location;
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
class Search extends \Dataservice_Form
{
    public function init()
    {
	$this->addElement('text', 'address', array(
	    'required'	    => true,
	    'Label'	    => 'Enter zipcode OR city and state',
	    'description'   => "ex: 75169 or Wills Point, TX",
	    'style'	    => "height:23px;width:208px;margin:0;border:none;padding:0;",
	    'Decorators'    => array(
				    'ViewHelper',
				    array(array('data' => 'HtmlTag'), array('tag' => 'div', 'style' => 'float:left;width:293px;')),
//				    array('Description', array('tag' => 'div', 'style' => 'float:left')),
				    array('Label', array('tag' => 'div', 'style' => 'float:left;width:240px;margin-left:15px;padding-top:3px;'))
				)
        ));
	
	$this->addElement('select', 'range', array(
	    'required'	    => true,
	    'Label'	    => 'Search Range',
	    'multioptions'  => array("10" => "10", "25" => "25", "50" => "50", "100" => "100", "200" => "200"),
	    'value'	    => "50",
	    'style'	    => "height:23px;width:120px;margin:0;border:none;padding:0;",
	    'Decorators'    => array(
				    'ViewHelper',
				    array(array('data' => 'HtmlTag'), array('tag' => 'div', 'style' => 'float:left;width:140px;')),
//				    array('Description', array('tag' => 'div', 'style' => 'float:left')),
				    array('Label', array('tag' => 'div', 'style' => 'float:left;width:125px;padding-top:3px;'))
				)
        ));

        $this->addElement('submit', 'Search', array(
            'ignore'	    => true,
	    'Decorators'    => array(
				    'ViewHelper',
				    array(array('data' => 'HtmlTag'), array('tag' => 'div', 'style' => 'float:left;'))
				)
        ));
	
	$this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'div')),
            'Form',
        ));
    }
}
