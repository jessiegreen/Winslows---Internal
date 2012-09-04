<?php
namespace Entities\Website\Guest;

/** 
 * @Entity (repositoryClass="Repositories\Website\Guest\Account") 
 * @Table(name="website_guest_accounts") 
 */
class Account extends \Entities\Website\Account\AccountAbstract
{
    public function getDescriminator()
    {
	return self::TYPE_Guest;
    }
}
