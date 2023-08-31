<?php
$page_name="Student - Follow Up";
use Inc\Api\Functions;
$functions=new Functions();

if(isset($_POST["follow"]))
{
    set_transient( 'follow', $_POST["follow"], 3600 );
}
if(isset($_POST["delete"]))
{
    $data["enabled"]=0;
    $functions->disableData("follow_up_info",$data,"id=".$_POST["delete"]);
}
if(isset($_POST["update_btn"]))
{
    $new_data["follow_up_number"]=$_POST["follow_up_number"];
    $new_data["follow_up_date"]=$_POST["follow_up_date"];
    $new_data["follow_up_outcome_id"]=$_POST["follow_up_outcome_id"];
    $new_data["additional_comment"]=$_POST["additional_comment"];
    $new_data["follow_up_action_id"]=$_POST["follow_up_action_id"];
    $new_data["staff_member"]=$_POST["staff_member"];
    $functions->updateData("follow_up_info",$new_data,"id=".$_POST["update"]);
}
if(isset($_POST["insert_done"]))
{
    $new_data["user_id"]=$_POST["user_id"];
    $new_data["follow_up_number"]=$_POST["follow_up_number"];
    $new_data["follow_up_date"]=$_POST["follow_up_date"];
    $new_data["follow_up_outcome_id"]=$_POST["follow_up_outcome_id"];
    $new_data["additional_comment"]=$_POST["additional_comment"];
    $new_data["follow_up_action_id"]=$_POST["follow_up_action_id"];
    $new_data["staff_member"]=$_POST["staff_member"];
    $functions->insertData("follow_up_info",$new_data);
}
?>
<script>
    if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>
<?php
if(!(false === get_transient( 'follow' )))
{
    
      
    
    // if(checkPrivilage($_SESSION["user_type"],"admin") || checkPrivilage($_SESSION["user_type"],"counsellor") || checkPrivilage($_SESSION["user_type"],"case_admin"))
    // {
    ?>
   
        <?php
        $functions->create_follow_up_table_leads();
        $functions->create_follow_up_data_leads();
        $functions->add_follow_up_leads();

            ?>

    <?php
}
// }