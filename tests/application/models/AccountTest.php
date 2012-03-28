<?php

class AccountModelTest extends ModelTestCase
{
  
  public function testCanInstantiateAccount()
  {
    $this->assertInstanceOf('\Entities\Account', new \Entities\Account);
  }

  public function testCanSaveAndRetrieveUser()
  {
    
    $account = new \Entities\Account;
    $account->setUsername('dataservice-test');
    $account->setEmail('jessie.winslows@gmail.com');
    $account->setPassword('jason');
    $account->setZip('43201');
    $this->em->persist($account);
    $this->em->flush();
    
    $account = $this->em->getRepository('Entities\Account')->findOneByUsername('dataservice-test');
    
    $this->assertEquals('dataservice-test', $account->getUsername());
    
    
  }
  
}
