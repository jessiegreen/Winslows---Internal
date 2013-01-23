<?php
namespace Dataservice\Html\CRUD;

class Header
{
    public function CRUD_Header($title)
    {
        ?>
	<h1 class="header1"><?php echo $title?></h1>
	<?php
    }
}