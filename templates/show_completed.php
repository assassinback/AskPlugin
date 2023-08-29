<?php
$page_name="Completed Case";
use Inc\Api\Functions;
$functions=new Functions();
if(isset($_POST["delete"]))
{
    $data["enabled"]=0;
    $functions->disableData("completed",$data,"id=".$_POST["delete"]);
}
if(isset($_POST["update_btn"]))
{
    $new_data["date"]=$_POST["date"];
    $new_data["full_name"]=$_POST["full_name"];
    $new_data["phone"]=$_POST["phone"];
    $new_data["country"]=$_POST["country"];
    $new_data["course"]=$_POST["course"];
    $new_data["university"]=$_POST["university"];
    $new_data["consultant"]=$_POST["consultant"];
    $new_data["brand"]=$_POST["brand"];
    $new_data["intake"]=$_POST["intake"];
    $new_data["notes"]=$_POST["notes"];
    $new_data["visa_status"]=$_POST["visa_status"];
    $new_data["comments"]=$_POST["comments"];
    $functions->updateData("completed",$new_data,"id=".$_POST["update"]);
}
?>
<?php

// if(checkPrivilage($_SESSION["user_type"],"admin") || checkPrivilage($_SESSION["user_type"],"accounts") || checkPrivilage($_SESSION["user_type"],"case_admin"))
// {
$outcome=$functions->selectData("completed","enabled=1");
$functions->create_forms_completed($page_name);
$functions->show_completed_table();

$functions->show_completed_data($outcome);
// }
?>