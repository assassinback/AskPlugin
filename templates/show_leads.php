<?php
/**
 * @package Ask_Portal
 */
namespace Templates;
use Inc\Api\Functions;
$functions=new Functions();
if(isset($_POST["update_btn"]))
{
    $new_data["apply_date"]=$_POST["apply_date"];
    $new_data["priority_id"]=$_POST["priority_id"];
    $new_data["full_name"]=$_POST["full_name"];
    if($functions->selectNumRows("user_info","phone_number='".$_POST["phone_number"]."'")>1)
    {
        goto same_phone;
    }
    else
    {
        $new_data["phone_number"]=$_POST["phone_number"];
    }
    $new_data["apply_source_id"]=$_POST["apply_source_id"];
    $new_data["country_id"]=$_POST["country_id"];
    $new_data["visited"]=$_POST["visited"];
    $new_data["inquiry_form_location_id"]=$_POST["inquiry_form_location_id"];
    $new_data["consultant_id"]=$_POST["consultant_id"];
    $new_data["qualification"]=$_POST["qualification"];
    $new_data["comments"]=$_POST["comments"];
    $new_data["budget"]=$_POST["budget"];
    $functions->updateData("user_info",$new_data,"id=".$_POST["update"]);
    goto done;
    same_phone:
    echo "<script>alert('Phone Number Already Exists')</script>";
    done:

}
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
        if(isset($_POST["delete"]))
        {
            $data["enabled"]=0;
            $functions->disableData("user_info",$data,"id=".$_POST["delete"]);
        }
        $functions->create_forms($this->page_name);
        if(isset($_POST["user_id"]))
        {
            $user_data=$functions->get_single_user_data_new($_POST["user_id"]);
        }
        else if(isset($_POST["type"]))
        {
            // $_SESSION["type"]=$_POST["type"];
            // $_SESSION["date"]=$_POST["date"];
            // $_SESSION["date"] = date("j/n/Y", strtotime($_SESSION["date"]));
            set_transient( 'type', $_POST["type"], 600 );
            set_transient( 'date', date("j/n/Y", strtotime($_POST["date"])), 600) ;
            $combined=get_transient( 'type' )." ".get_transient( 'date' );
            $user_data=$functions->get_all_data_follow_new(strtolower($combined));
            
        }
        else if(!(false === get_transient( 'date' )))
        {
            $combined=get_transient( 'type' )." ".get_transient( 'date' );
            $user_data=$functions->get_all_data_follow_new(strtolower($combined));
        }
        else
        {
            $user_data=$functions->get_all_data($this->min,$this->max);
            
        }
        $functions->show_leads_table();
        $functions->show_leads_data($user_data);
        
    }
}
?>
<h1>Show Leads</h1>