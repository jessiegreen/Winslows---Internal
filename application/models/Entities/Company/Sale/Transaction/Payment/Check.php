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
namespace Entities\Company\Sale\Transaction\Payment;

/** 
 * @Entity (repositoryClass="Repositories\Company\Sale\Transaction\Payment\Check") 
 * @Table(name="company_sale_transaction_payment_checks") 
 */
class Check extends \Entities\Company\Sale\Transaction\Payment\PaymentAbstract
{
    /**
     * @Column(type="integer")
     * @var integer $check_number
     */
    protected $check_number;
    
    /**
     * @param integer $check_number
     */
    public function setCheckNumber($check_number)
    {
	$this->check_number = $check_number;
    }
    
    public function getCheckNumber()
    {
	return $this->check_number;
    }
}
