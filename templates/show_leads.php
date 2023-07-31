<?php
/**
 * @package Ask_Portal
 */
namespace Templates;
use Inc\Api\Functions;
?>
<script>
    if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>
<?php

class show_leads
{
    public $page_name="<h1>Show Leads</h1>";
    public $min=0;
    public $max=2000;
    public function heading()
    {
        echo $this->page_name;
    }
    public function makeSessions()
    {
        if(!isset($_SESSION["min"]) || !isset($_SESSION["max"]))
        {
            $_SESSION["min"]=0;
            $_SESSION["max"]=2000;
        }
        if(isset($_POST["pagenumber"]))
        {
            $_SESSION["min"]=0;
            $_SESSION["max"]=1000;
            for($i=1;$i<$_POST["pagenumber"];$i++)
            {
                $_SESSION["min"]=$_SESSION["min"]+1000;
                $_SESSION["max"]=$_SESSION["max"]+1000;
            }
            
        }
        if(isset($_SESSION["min"]) || isset($_SESSION["max"]))
        {
            $this->min=$_SESSION["min"];
            $this->max=$_SESSION["max"];
        }
    }
    public function create_page()
    {
        // $user = wp_get_current_user();
        // var_dump($user);
        $this->makeSessions();
        $functions=new Functions();
        $user_data=$functions->get_all_data($this->min,$this->max);
        $functions->create_forms($this->page_name);
        $functions->show_leads_table();
        $functions->show_leads_data($user_data);
    }
}
?>
<h1>Show Leads</h1>