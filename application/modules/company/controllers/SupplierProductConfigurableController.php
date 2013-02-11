<?php
class Company_SupplierProductConfigurableController extends Dataservice_Controller_Company_Supplier_Product_ProductAbstract_Action
{    
    public function init()
    {
	$this->_EntityClass = "Entities\Company\Supplier\Product\Configurable";
	
	parent::init();
    }
    
    public function manageOptionsAction()
    {
	$this->_requireEntity();
	
	$form = new Forms\Company\Supplier\Product\Configurable\ManageOptions($this->_Entity, array("method" => "post"));

	$form->addCancelButton($this->_History->getPreviousUrl());

	if($this->isPostAndValid($form))
	{
	    try 
	    {
		$data	    = $this->_getParam("company_supplier_product_configurable_manageoptions");
		$options    = $data["configurable_manageoptions"];

		foreach ($this->_Entity->getOptions() as $Option)
		{
		    if(!in_array($Option->getId(), $options))
		    {
			$this->_Entity->removeOption($Option);
		    }

		    $current_groups[] = $Option->getId();
		}

		foreach ($options as $value) 
		{
		    if(!in_array($value, $current_groups))
		    {
			$Option = $this->_em->find("\Entities\Company\Supplier\Product\Configurable\Option", $value);

			$this->_Entity->addOption($Option);
		    }
		}

		$this->_em->persist($this->_Entity);
		$this->_em->flush();

		$this->_FlashMessenger->addSuccessMessage("Configurable Option saved.");
	    }
	    catch (Exception $exc)
	    {
		$this->_FlashMessenger->addErrorMessage($exc->getMessage());
	    }
	    
	    $this->_History->goBack();
	}
	
	$this->view->form = $form;
    }
}

