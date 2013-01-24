<?php
namespace Dataservice\Html\CRUD;

class Body
{   
    /**
     * @return \Dataservice\Html\CRUD\Body
     */
    public static function factory()
    {
	return new Body;
    }
    
    public function start()
    {
	?><div id="tabs" style="width: 951px;"><?php
    }
    
    public function end()
    {
	?>
	</div>
	<?php
    }
}