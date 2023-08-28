<?php
$page_name="Add Completed Case";
use Inc\Api\Functions;
$functions=new Functions();
if(isset($_POST["update_done"]))
{
    $new_data["id"]=$_POST["id"];
    if(isset($_POST["manual_id"]) || $_POST["manual_id"]!="" || $_POST["manual_id"]!=0)
    {
        $new_data["id"]=$_POST["manual_id"];
    }
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
    global $current_user;
    $new_data["insert_admin"]=$current_user->user_login;
    $functions->insertData("completed",$new_data,"id=".$_POST["id"]);
    // header("Location:show_completed.php");
}
?>
<form method="POST" style="margin-top:220px !important;">

<?php

// if(checkPrivilage($_SESSION["user_type"],"admin") || checkPrivilage($_SESSION["user_type"],"accounts"))
// {
?>
<div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
        <?php
        $max=$functions->maxId("user_info")+1;
                echo "<label class='form-control-lg'>Serial Number: ".($functions->maxId("completed")+1)."</label>";
            ?>
            <br>
    <input type="hidden" name="id" value="<?php echo $max; ?>">
    <label>Serial Number:</label><br><input class="form-control form-control-lg" type="number" name="manual_id" value=""><br>
    <label>Date:</label><br><input class="form-control form-control-lg" type="text" name="date"><br>
    <label>Name:</label><br><input class="form-control form-control-lg" type="text" name="full_name" ><br>
    <label>Phone Number:</label><br><input required class="form-control form-control-lg" type="text" name="phone" ><br>
    <label>Country:</label><br><input class="form-control form-control-lg" type="text" name="country" ><br>
    <label>Course:</label><br><input class="form-control form-control-lg" type="text" name="course" ><br>
    <label>University:</label><br><input class="form-control form-control-lg" type="text" name="university" ><br>
    <label>Consultant:</label><br><input class="form-control form-control-lg" type="text" name="consultant" ><br>
    <label>Brand:</label><br><input class="form-control form-control-lg" type="text" name="brand" ><br>
    <label>Intake:</label><br><input class="form-control form-control-lg" type="text" name="intake" ><br>
    <label>Notes:</label><br><input class="form-control form-control-lg" type="text" name="notes" ><br>
    <label>Visa Status:</label><br><input class="form-control form-control-lg" type="text" name="visa_status" ><br>
    <label>Comments:</label><br><input class="form-control form-control-lg" type="text" name="comments" ><br>
    <br>
    <input type="submit" value="Update" name="update_done" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">
<?php
// }

?>
</div></div></div>
</form>
<?php
// require("footer.php");
?>