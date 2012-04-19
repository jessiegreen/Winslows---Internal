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
        $return = '<div id="builder_code"></div></div><div style="clear: both;"></div>
		   </div>
		   <div id="dirty" style=""></div>';
	$return.= "<script type='text/javascript'>$('#example').tabs(
								    { 
									cache: false, 
									select: function(event, ui) { 
									    $('#builder_right_pane').block({ 
										message: null,
										overlayCSS: { backgroundColor: '#EAF4FD' } 
									    }); 
									},
									load: function(event, ui) { $('#builder_right_pane').unblock(); }
								    });
								    </script>";
	$return.= "<script type='text/javascript'>
			B = new Builder;
			B.reset_click_bind();
		    </script>";
	return $return;
    }
}