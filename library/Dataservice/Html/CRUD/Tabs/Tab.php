<?php
namespace Dataservice\Html\CRUD\Tabs;

class Tab
{
    /**
     * @var string 
     */
    private $name	    = "";
    
    /**
     * @var string 
     */
    private $header_html    = "";
    
    /**
     * @var string 
     */
    private $content_html    = "";
    
    /**
     * @var array 
     */
    private $permissions    = array("add" => array("Admin"), "edit" => array("Admin"), "delete" => array("Admin"));
    
    public function header($tabs)
    {
	$html = '<ul>';
	
	foreach($tabs as $tab)
	{
	    $html .= '<li><a href="#'.str_ireplace(" ", "_", $tab).'">'.$tab.'</a></li>';
	}
	
	$html .= "</ul>";
    }
    
    public function contentHeaderStart()
    {
	return "<h4>";
    }
    
    public function contentHeaderEnd()
    {
	return "</h4>";
    }
    
    public function permissionRender($content, $permissions)
    {
	
    }
    
    public function contentHeader()
    {
	?>
	<h4>
	    Leads
	    <?php echo $Anchor->addIcon("", "/lead/edit/id/0/company_id/".$Company->getId(), "Add Lead");?>
	</h4>
	<?php
    }
    
    public function collectionTab($title, $permissions)
    {
	?>
	<div id="Leads">
	    <h4>
		Leads
		<?php echo $Anchor->addIcon("", "/lead/edit/id/0/company_id/".$Company->getId(), "Add Lead");?>
	    </h4>
	    <ul>
	    <?php	
	    if(!$Leads->count())echo "<li>No leads</li>";
	    else
		foreach ($Leads as $Lead)
		{
		    echo "<li>";
		    echo $Anchor->editIcon("", "/lead/edit/id/".$Lead->getId(), "Edit Lead");
		    echo $Anchor->deleteIcon("", "/lead/delete/id/".$Lead->getId(), true, "Delete Lead");
		    echo htmlspecialchars($Address->toString());
		    echo "</li>";
		}
	    ?>
	    </ul>
	</div>
	<?php
    }
}