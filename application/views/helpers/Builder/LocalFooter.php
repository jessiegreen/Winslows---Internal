<?php

/**
 * Builder Local Footer helper
 *
 */
class Builder_View_Helper_LocalFooter // extends Zend_View_Helper_Abstract
{
    public $view;

    public function setView(Zend_View_Interface $view)
    {
        $this->view = $view;
    }

    public function localFooter()
    {
        $return = '';
	$return.= "<script type='text/javascript'>";
	$return.= "b = new Builder();
		    b.update(
			'".$this->view->code."','".$this->view->price."', ".$this->view->hints.", ".json_encode($this->view->details).", ".json_encode($this->view->price_details).");
		    </script>";
	return $return;
    }
}