<?php
class Winslows_IndexController extends Dataservice_Controller_Action
{        
    public function indexAction()
    {
	$Categories = Services\Winslows\Product::factory()->getTopProductCategories();
	echo "<br />";
	foreach ($Categories as $Category) {
	    echo $Category->getName()."<br />";
	    foreach($Category->getChildren() as $ChildCategory)
	    {
		echo "->".$ChildCategory->getName()."<br />";
	    }
	};
    }
}

