<?php
namespace Forms\Company\Location\PhoneNumber;
use Entities\Company\Location\PhoneNumber as PhoneNumber;
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
class Subform extends \Forms\PhoneNumber\Subform
{
    private $_PhoneNumber;
    
    public function __construct($options = null, PhoneNumber $PhoneNumber = null) {
	$this->_PhoneNumber = $PhoneNumber;
	parent::__construct($options, $this->_PhoneNumber);
    }
}

?>
