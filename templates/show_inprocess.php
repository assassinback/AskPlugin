<?php
$page_name="Show Inprocess Cases";
use Inc\Api\Functions;
$functions=new Functions();

if(isset($_POST["delete"]))
{
    $data["enabled"]=0;
    $functions->disableData("in_process",$data,"id=".$_POST["delete"]);
}
if(isset($_POST["update_btn"]))
{
    $new_data["case_assign_date"]=$_POST["case_assign_date"];
    $new_data["name"]=$_POST["name"];
    $new_data["phone"]=$_POST["phone"];
    $new_data["email"]=$_POST["email"];
    $new_data["ask_email"]=$_POST["ask_email"];
    $new_data["destination_1"]=$_POST["destination_1"];
    $new_data["counselor"]=$_POST["counselor"];
    $new_data["comments"]=$_POST["comments"];
    $new_data["fee_status"]=$_POST["fee_status"];
    $new_data["admin"]=$_POST["admin"];
    $new_data["university_1"]=$_POST["university_1"];
    $new_data["outcome_destination_1"]=$_POST["outcome_destination_1"];
    $new_data["case_status_1"]=$_POST["case_status_1"];
    $new_data["destination_2"]=$_POST["destination_2"];
    $new_data["case_handler_2"]=$_POST["case_handler_2"];
    $new_data["university_2"]=$_POST["university_2"];
    $new_data["outcome_destination_2"]=$_POST["outcome_destination_2"];
    $new_data["case_status_2"]=$_POST["case_status_2"];
    $new_data["course"]=$_POST["course"];
    $new_data["intake"]=$_POST["intake"];
    $new_data["missing_docs"]=$_POST["missing_docs"];
    $new_data["final_comments"]=$_POST["final_comments"];
    $functions->updateData("in_process",$new_data,"id=".$_POST["update"]);
}
?>

<?php



$functions->create_forms_inprocess($page_name);
$outcome=(array)$functions->get_follow_up_data();
$functions->show_inprocess_table();

$functions->show_inprocess_data($outcome);

?>







<?php


?>