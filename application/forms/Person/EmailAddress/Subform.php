<?php
namespace Forms\Person\EmailAddress;
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
class Subform extends \Forms\EmailAddress\Subform
{
    private $_EmailAddress;
    
    public function __construct($options = null, \Entities\Person\EmailAddress $EmailAddress = null)
    {
	$this->_EmailAddress = $EmailAddress;
	
	parent::__construct($options, $this->_EmailAddress);
    }
}

?>
