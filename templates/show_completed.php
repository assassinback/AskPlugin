<?php
$page_name="Completed Case";
use Inc\Api\Functions;
$functions=new Functions();
if(isset($_POST["delete"]))
{
    $data["enabled"]=0;
    $functions->disableData("completed",$data,"id=".$_POST["delete"]);
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