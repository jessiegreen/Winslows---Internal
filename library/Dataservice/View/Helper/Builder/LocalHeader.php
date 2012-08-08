<?php

/**
 * Builder Local Header helper
 *
 */
class Builder_View_Helper_LocalHeader // extends Zend_View_Helper_Abstract
{
    public $view;

    public function setView(Zend_View_Interface $view)
    {
        $this->view = $view;
    }

    public function localHeader()
    {
        $return = '';
	
	$return .= implode("", $this->view->local_messages);
	
	return $return;
    }
}

?>