<?php

/**
 * ProfileLink helper
 *
 * Call as $this->profileLink() in your layout script
 */
class Dataservice_View_Helper_CRUD_Body  extends Zend_View_Helper_Abstract
{
    public function CRUD_Body()
    {
	return $this;
    }
    
    public function start()
    {
	?><div id="tabs" style="width: 951px;"><?php
    }
    
    public function end()
    {
	?>
	</div>
	<script>
	    $(function() {
		$( "#tabs" ).tabs({
		    select: function(event, ui) {                   
			window.location.hash = ui.tab.hash;
		    }
		}).addClass( "ui-tabs-vertical ui-helper-clearfix" );
		$( "#tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );
	    });
	</script>
	<?php
    }
}