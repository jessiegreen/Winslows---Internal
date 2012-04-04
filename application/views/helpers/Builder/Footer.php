<?php

/**
 * Builder Footer helper
 *
 */
class Builder_View_Helper_Footer // extends Zend_View_Helper_Abstract
{
    public $view;

    public function setView(Zend_View_Interface $view)
    {
        $this->view = $view;
    }

    public function footer()
    {
        $return = '</div>
		   </div>
		   <div id="dirty" style=""></div>';
	$return.= "<script type='text/javascript'>$('#example').tabs({ cache: false });</script>";
	$return.= "<script type='text/javascript'>
			B = new Builder;
			B.reset_click_bind();
		    </script>";
	return $return;
    }
}