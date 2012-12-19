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
	    'Label'	    => 'Enter your zipcode OR city and state',
	    'description'   => "ex: 75169 or Wills Point, TX"
        ));
	
	$this->addElement('select', 'range', array(
	    'required'	    => true,
	    'Label'	    => 'Search Range (Miles)',
	    'multioptions'  => array("10" => "10", "25" => "25", "50" => "50", "100" => "100", "200" => "200"),
	    'value'	    => "50"
        ));

        $this->addElement('submit', 'Search', array(
            'ignore'   => true,
        ));
    }
}
