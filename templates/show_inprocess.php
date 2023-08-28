<?php
$page_name="Show Inprocess Cases";
use Inc\Api\Functions;
$functions=new Functions();
if(isset($_POST["delete"]))
{
    $data["enabled"]=0;
    $functions->disableData("in_process",$data,"id=".$_POST["delete"]);
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