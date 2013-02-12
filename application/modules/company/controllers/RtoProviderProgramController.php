<?php
class Company_RtoProviderProgramController extends Dataservice_Controller_Crud_Action
{    
    public function init()
    {
	$this->_EntityClass = "Entities\Company\RtoProvider\Program";
	
	parent::init();
    }
    
    public function manageProductsAction()
    {
	$this->_requireEntity();
	
	$form = new Forms\Company\RtoProvider\Program\ManageProducts($this->_Entity, array("method" => "post"));

	$form->addCancelButton($this->_History->getPreviousUrl());

	if($this->isPostAndValid($form))
	{
	    try 
	    {
		$data			= $this->_getParam("company_rto_provider_program_manageproducts");
		$products		= $data["products_checks"];
		$current_products	= array();

		foreach ($this->_Entity->getProducts() as $Product)
		{
		    if(!in_array($Product->getId(), $products))
		    {
			$this->_Entity->removeProduct($Product);
		    }

		    $current_products[] = $Product->getId();
		}

		foreach ($products as $product) 
		{
		    if(!in_array($product, $current_products))
		    {
			$Product = $this->_em->find("\Entities\Company\Supplier\Product\ProductAbstract", $product);
			$this->_Entity->addProduct($Product);
		    }
		}

		$this->_em->persist($this->_Entity);
		$this->_em->flush();
		
		$this->_FlashMessenger->addSuccessMessage("Product saved.");
	    }
	    catch (\Exception $exc)
	    {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
	    }
	    
	    $this->_History->goBack();
	}
	
	$this->view->form = $form;
    }
    
    public function manageFeesAction()
    {
	$this->_requireEntity();
	
	$form = new Forms\Company\RtoProvider\Program\ManageFees($this->_Entity, array("method" => "post"));

	$form->addCancelButton($this->_History->getPreviousUrl());

	if($this->isPostAndValid($form))
	{
	    try 
	    {
		$data		= $this->_getParam("company_rto_provider_program_managefees");
		$fees		= $data["fees_checks"];
		$current_fees	= array();

		foreach ($this->_Entity->getFees() as $Fee)
		{
		    if(!in_array($Fee->getId(), $fees))
		    {
			$this->_Entity->removeFee($Fee);
		    }

		    $current_fees[] = $Fee->getId();
		}

		foreach ($fees as $fee) 
		{
		    if(!in_array($fee, $current_fees))
		    {
			$Fee = $this->_em->find("\Entities\Company\RtoProvider\Fee\FeeAbstract", $fee);
			
			$this->_Entity->addFee($Fee);
		    }
		}

		$this->_em->persist($this->_Entity);
		$this->_em->flush();
		
		$this->_FlashMessenger->addSuccessMessage("Fees saved.");
		$this->_History->goBack();
	    }
	    catch (Exception $exc)
	    {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
		$this->_History->goBack();
	    }
	}
	
	$this->view->form = $form;
    }
}

