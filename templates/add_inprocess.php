<?php
$page_name="Add Inprocess Case";
use Inc\Api\Functions;
$functions=new Functions();
$desti=$functions->selectData("destination","enabled=1");
$consu=$functions->selectData("consultant","enabled=1");
$destinat=$functions->selectData("destination","enabled=1");
$fees=$functions->selectData("fee_status","enabled=1");
$status=$functions->selectData("case_status","enabled=1");
if(isset($_POST["update_done"]))
{
    $new_data["id"]=$_POST["id"];
    if(isset($_POST["manual_id"]) || $_POST["manual_id"]!="" || $_POST["manual_id"]!=0)
    {
        $new_data["id"]=$_POST["manual_id"];
    }
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
    global $current_user;
    $new_data["insert_admin"]=$current_user->user_login;
    $functions->insertData("in_process",$new_data,"id=".$_POST["id"]);
    // wp_redirect( "http://localhost/ask_plugin/wp-admin/admin.php?page=Show_Inprocess" );
    // header("Location:http://localhost/ask_plugin/wp-admin/admin.php?page=Show_Inprocess");
}
?>
<form method="POST" style="margin-top:220px !important;">
<?php

// if(checkPrivilage($_SESSION["user_type"],"admin") || checkPrivilage($_SESSION["user_type"],"accounts") || checkPrivilage($_SESSION["user_type"],"case_admin"))
//     {
?>
<div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
        <?php
        $max=$functions->maxId("user_info")+1;
                echo "<label class='form-control-lg'>Serial Number: ".($functions->maxId("in_process")+1)."</label>";
            ?>
            <br>
    <input type="hidden" name="id" value="<?php echo $max; ?>">
    <label>Serial Number:</label><br><input class="form-control form-control-lg" type="number" name="manual_id" value=""><br>
    <label>Case Assign Date:</label><br><input class="form-control form-control-lg" type="text" name="case_assign_date" ><br>
    <label>Name:</label><br><input class="form-control form-control-lg" type="text" name="name" ><br>
    <label>Phone Number:</label><br><input required class="form-control form-control-lg" type="text" name="phone"><br>
    <label>Email:</label><br><input class="form-control form-control-lg" type="text" name="email" ><br>
    <label>ASK Email:</label><br><input class="form-control form-control-lg" type="text" name="ask_email" value=""><br>
    <label for="destination_1">Destination 1:</label><br>
    <select name="destination_1" class="form-control form-control-lg">
        <?php
            foreach($desti as $rows1)
            {
                
                ?>
                
                <option value="<?php echo $rows1->id  ?>"><?php echo $rows1->destination_name  ?></option>
                
                <?php
                
            }
        ?>
    </select><br>


    <label for="counselor">Counselor:</label><br>
    <select name="counselor" class="form-control form-control-lg">
        <?php
            foreach($consu as $rows1)
            {
               
                ?>
                
                <option value="<?php echo $rows1->id  ?>"><?php echo $rows1->consultant_name  ?></option>
                
                <?php
                
            }
        ?>
    </select><br>
    <label>Comments:</label><br><input class="form-control form-control-lg" type="text" name="comments" value=""><br>
    <label for="fee_status">fee_status:</label><br>
    <select name="fee_status" class="form-control form-control-lg">
        <?php
            foreach($fees as $rows1)
            {
               
                ?>
                
                <option value="<?php echo $rows1->id  ?>"><?php echo $rows1->status_name  ?></option>
                
                <?php
                
            }
        ?>
    </select><br>
    <label>Case Handler 1:</label><br><input class="form-control form-control-lg" type="text" name="admin" value=""><br>
    <label>University 1:</label><br><input class="form-control form-control-lg" type="text" name="university_1" value=""><br>
    <label>Outcome Destination 1:</label><br><input class="form-control form-control-lg" type="text" name="outcome_destination_1" value=""><br>
    <label>Case Status 1:</label><br>
    <select name="case_status_1" class="form-control form-control-lg">
        <?php
            foreach($status as $rows1)
            {
               
                ?>
                
                <option value="<?php echo $rows1->id  ?>"><?php echo $rows1->status_name  ?></option>
                
                <?php
                
            }
        ?>
    </select><br>
    <label for="destination_2">Destination 2:</label><br>
    <select name="destination_2" class="form-control form-control-lg">
        <?php
            foreach($destinat as $rows1)
            {
               
                ?>
                
                <option value="<?php echo $rows1->id  ?>"><?php echo $rows1->destination_name  ?></option>
                
                <?php
                
            }
        ?>
    </select><br>
    <label>Case Handler 2:</label><br><input class="form-control form-control-lg" type="text" name="case_handler_2" value=""><br>
    <label>University 2:</label><br><input class="form-control form-control-lg" type="text" name="university_2" value=""><br>
    <label>Outcome Destination 2:</label><br><input class="form-control form-control-lg" type="text" name="outcome_destination_2" value=""><br>
    <label>Case Status 1:</label><br>
    <select name="case_status_2" class="form-control form-control-lg">
        <?php
            foreach($status as $rows1)
            {
               
                ?>
                
                <option value="<?php echo $rows1->id  ?>"><?php echo $rows1->status_name  ?></option>
                
                <?php
                
            }
        ?>
    </select><br>
    <label>Course:</label><br><input class="form-control form-control-lg" type="text" name="course" value=""><br>
    <label>Intake:</label><br><input class="form-control form-control-lg" type="text" name="intake" value=""><br>
    <label>Missing Docs:</label><br><input class="form-control form-control-lg" type="text" name="missing_docs" value=""><br>
    <label>Final Comments:</label><br><input class="form-control form-control-lg" type="text" name="final_comments" value=""><br>
    
    
    <br>
    <input type="submit" value="Update" name="update_done" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">
<?php

    // }
?>
</div></div></div>
</form>

<?php
?>