<?php
$page_name="Show Inprocess Cases";
use Inc\Api\Functions;
?>

<?php


$functions=new Functions();
$functions->create_forms_inprocess($page_name);
$outcome=(array)$functions->get_follow_up_data();
$functions->show_inprocess_table();

$functions->show_inprocess_data($outcome);

?>







<?php


?>