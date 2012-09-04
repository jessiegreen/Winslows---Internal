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
class Dataservice_Auth_Adapter_Doctrine implements Zend_Auth_Adapter_Interface
{
    /**
    * Doctrine EntityManager
    *
    * @var Doctrine\ORM\EntityManager
    */
    protected $_em;

    /**
     * The fiels used to store username.
     *
     * @var string
     */
    protected $identity;

    /**
     * The fild that store password
     *
     * @var string
     *
     */
    protected $credential;
    
    protected $account_id;

    /**
    * Constructor sets configuration options.
    *
    * @param string
    * @param string
    * @return void
    */
    public function __construct(\Doctrine\ORM\EntityManager $entity_manager, $identity, $credential)
    {
        $this->_em		= $entity_manager;
        $this->identityField	= 'username';
        $this->credentialField	= 'password';
        $this->identity		= $identity;
        //create encryped password
        $this->credential	= $credential;
    }

    /**
    * Defined by Zend_Auth_Adapter_Interface. This method is called to
    * attempt an authentication. Previous to this call, this adapter would have already
    * been configured with all necessary information to successfully connect to a database
    * table and attempt to find a record matching the provided identity.
    *
    * @throws Zend_Auth_Adapter_Exception if answering the authentication query is impossible
    * @return Zend_Auth_Result
    */
    public function authenticate()
    {
        $this->_authenticateSetup();
        // get details of the user from table
	
	/* @var $Account \Entities\Website\Account\AccountAbstract */
	$repos	    = $this->_em->getRepository('Entities\Website\Account\AccountAbstract');
	$Account    = $repos->findOneBy(array("username" => $this->identity));
	
        $authResult = array(
            'code'	=> Zend_Auth_Result::FAILURE,
            'identity'	=> null,
            'messages'	=> array()
        );
	
        try 
	{
            $resultCount = count($Account);

            if ($resultCount > 1)
	    {
                $authResult['code']	    = Zend_Auth_Result::FAILURE_IDENTITY_AMBIGUOUS;
                $authResult['messages'][]   = 'More than one entity matches the supplied identity.';
            } 
	    else if ($resultCount < 1)
	    {
                $authResult['code']	    = Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND;
                $authResult['messages'][]   = 'Username not found.';
            } 
	    else if (1 == $resultCount)
	    {
		$this->setCredentialTreatment($this->credential, $Account->getSalt() );
		
                if ($Account->getPassword() != $this->credentialTreatment )
		{
                    $authResult['code']		= Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID;
                    $authResult['messages'][]	= 'Password is invalid.';
                } 
		else
		{
                    $authResult['code']		= Zend_Auth_Result::SUCCESS;
                    $authResult['identity']	= $this->identity;
                    $authResult['messages'][]	= 'Authentication successful.';

                    $this->setAccountId($Account->getId());
                }
            }
        } 
	catch (\Doctrine\ORM\Query\QueryException $qe)
	{
            $authResult['code']		= Zend_Auth_Result::FAILURE_UNCATEGORIZED;
            $authResult['messages'][]	= $qe->getMessage();
        }

        return new Zend_Auth_Result(
            $authResult['code'],
            $authResult['identity'],
            $authResult['messages']
        );
    }

    /**
    * This method abstracts the steps involved with
    * making sure that this adapter was indeed setup properly with all
    * required pieces of information.
    *
    * @throws Zend_Auth_Adapter_Exception - in the event that setup was not done properly
    */
    protected function _authenticateSetup()
    {
        $exception = null;

        if (null === $this->_em || !$this->_em instanceof \Doctrine\ORM\EntityManager) {
            $exception = 'A Doctrine2 EntityManager must be supplied for the Zend_Auth_Adapter_Doctrine2 authentication adapter.';
        } elseif (empty($this->identityField)) {
            $exception = 'An identity field must be supplied for the Zend_Auth_Adapter_Doctrine2 authentication adapter.';
        } elseif (empty($this->credentialField)) {
            $exception = 'A credential field must be supplied for the Zend_Auth_Adapter_Doctrine2 authentication adapter.';
        } elseif (empty($this->identity)) {
            $exception = 'A value for the identity was not provided prior to authentication with Zend_Auth_Adapter_Doctrine2.';
        } elseif (empty($this->credential)) {
            $exception = 'A credential value was not provided prior to authentication with Zend_Auth_Adapter_Doctrine2.';
        }

        if (null !== $exception) {
            /**
            * @see Zend_Auth_Adapter_Exception
            */
            throw new Zend_Auth_Adapter_Exception($exception);
        }
    }

    /**
    * Construct the Doctrine query.
    *
    * @return Doctrine\ORM\Query
    */
    protected function _getQuery()
    {
        $qb = $this->_em->createQueryBuilder()
            ->select('e')
            ->from('\Entities\Website\Account\AccountAbstract', 'e')
            ->where('e.username=:username')
            ->setParameter('username', $this->identity);
        return $qb->getQuery();
    }

    public function setCredentialTreatment($credential, $salt)
    {
	$this->credentialTreatment = (SHA1($credential . $salt));
    } 
    
    public function setAccountId($account_id)
    {
	$this->account_id = $account_id;
    }
    
    public function getAccountId()
    {
	return $this->account_id;
    }
}
