<?php
namespace Forms\Company\Lead\Quote\Sale\Transaction\Payment\CreditCard;
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
class Subform extends \Zend_Form_SubForm
{    
    public function init() 
    {
	$this->addElement("text", "amount", 
			    array(
				"label"		=> "Amount",
				"required"	=> true,
				"belongsTo"	=> "company_lead_quote_sale_payment_transaction_payment_creditcard",
				"validators"	=> array(
							array('float', true, array('locale' => 'en_US')),
							array('greaterThan', true, array('min' => 0))
						    )
			    ));
	
	$this->addElement("text", "cc_num", 
			    array(
				"label"		=> "Credit Card Number",
				"required"	=> true,
				"belongsTo"	=> "company_lead_quote_sale_payment_transaction_payment_creditcard",
				"validators"	=> array(
							 new \Zend_Validate_CreditCard(
							    array("type" =>
								array(
								    \Zend_Validate_CreditCard::AMERICAN_EXPRESS,
								    \Zend_Validate_CreditCard::DISCOVER,
								    \Zend_Validate_CreditCard::MASTERCARD,
								    \Zend_Validate_CreditCard::VISA
								)
							    )
							)
						    )
			    ));
	
	
        // The Expiry Month field
        $expMonth = new \Zend_Form_Element_Select('exp_month');
	
        $expMonth->setLabel('Card Expiry Date:')
            ->addMultiOptions(
                array('1' => '01', '2' => '02', '3' => '03', '4' => '04', '5' => '05', '6' => '06',
                    '7' => '07', '8' => '08', '9' => '09', '10' => '10', '11' => '11', '12' => '12'))
            ->setRequired(true)
            ->setDescription('/');
	
        $this->addElement($expMonth);

        // Generate the Expiry Year options
        $expYearOptions = array();
        $thisYear	= date('Y');
	
        for ($i = 0; $i < 15; ++$i)
	{
            $val		    = $thisYear + $i;
            $expYearOptions[$val]   = $val;
        }

        // The Expiry Year field
        $expYear = new \Zend_Form_Element_Select('exp_year');
	
        $expYear->removeDecorator('label')
            ->addMultiOptions($expYearOptions)
            ->setRequired(true)
            ->setDescription(' (Month / Year)')
            // We hook up our custom validator here
            ->addValidator(new \Dataservice_Validate_Date_OnlyFutureMonthYear('exp_month'));
	
        $this->addElement($expYear);

        // Setup Expiry Month decorators
        $expMonth->setDecorators(array(
        // Show form element
            'ViewHelper',
            // This opens the wrapping DD tag but doesn't close it, we'll close it on 
            // the year field decorator later
            array(array('data' => 'HtmlTag'), array('tag' => 'dd', 'id' => 'card-expire', 
                'openOnly' => true)),
            // Using this to slip in a visual seperator "/" between both fields
            array('Description', array('tag' => 'span', 'class' => 'seperator')),
            // Show the label tag displayed for exp_month
            array('Label', array('tag' => 'dt'))
        ));

        // Now, lets fix the Expiry Year field decorators
        $expYear->setDecorators(array(
            'ViewHelper',
            // Inserting the "(Month / Year)" line using Description
            array('Description', array('tag' => 'small', 'class' => 'greyout')),
            // Show errors for this element
            'Errors',
            // "row" is normally used to wrap a whole row, label + form element. 
            // I'm "misusing" it to close off the DD tag we opened in the month field earlier
            // If you are already using "row", you might choose to echo the form line by line,
            // where you close the dd tag manually like: echo 
            //      $this->form->getElement('exp_year').'</dd>';
            array(array('row' => 'HtmlTag'), array('tag' => 'dd', 'closeOnly' => true))
        ));
	
	parent::init();
    }
}