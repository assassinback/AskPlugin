<?php
$page_name="Completed Case";
use Inc\Api\Functions;
?>
<?php
$functions=new Functions();
// if(checkPrivilage($_SESSION["user_type"],"admin") || checkPrivilage($_SESSION["user_type"],"accounts") || checkPrivilage($_SESSION["user_type"],"case_admin"))
// {
$outcome=$functions->selectData("completed","enabled=1");
$functions->create_forms_completed($page_name);
$functions->show_completed_table();

$functions->show_completed_data($outcome);
// }
?>