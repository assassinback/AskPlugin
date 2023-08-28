<?php
$page_name="Add Student";
use Inc\Api\Functions;
$functions=new Functions();
$country=$functions->selectData("country","enabled=1");
$source=$functions->selectData("source","enabled=1");
$leads=$functions->selectData("lead_priority","enabled=1");
$inquiry=$functions->selectData("inquiry_form_location","enabled=1");
$consultant=$functions->selectData("consultant","enabled=1");
if(isset($_POST["update_done"]))
{
    $new_data["id"]=$_POST["id"];
    if(isset($_POST["manual_id"]) || $_POST["manual_id"]!="" || $_POST["manual_id"]!=0)
    {
        $new_data["id"]=$_POST["manual_id"];
    }
    $_POST["date"] = date("j/n/Y", strtotime($_POST["date"]));
    $new_data["apply_date"]=$_POST["date"];
    $new_data["priority_id"]=$_POST["priority_id"];
    $new_data["full_name"]=$_POST["name"];
    $new_data["email"]=$_POST["email"];
    if($functions->selectNumRows("user_info","phone_number='".$_POST["phone"]."'")>0)
    {
        goto same_phone;
    }
    else
    {
        $new_data["phone_number"]=$_POST["phone"];
    }
    global $current_user;
    $new_data["apply_source_id"]=$_POST["apply_source_id"];
    $new_data["country_id"]=$_POST["country_id"];
    $new_data["visited"]=$_POST["visited"];
    $new_data["inquiry_form_location_id"]=$_POST["inquiry_form_location_id"];
    $new_data["consultant_id"]=$_POST["consultant_id"];
    $new_data["qualification"]=$_POST["qualification"];
    $new_data["comments"]=$_POST["comment"];
    $new_data["budget"]=$_POST["budget"];
    $new_data["insert_admin"]=$current_user->user_login;
    $functions->insertData("user_info",$new_data);
goto done;

    same_phone:
    echo "<script>alert('Phone Number Already Exists')</script>";
    // echo "<script>window.location.href = 'add_user.php';</script>";

    done:

}
?>
<form method="POST" style="margin-top:220px !important;">
<?php
// if(checkPrivilage($_SESSION["user_type"],"admin") || checkPrivilage($_SESSION["user_type"],"counsellor"))
// {


?>
<div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
            <?php
            $max=$functions->maxId("user_info")+1;
                echo "<label class='form-control-lg'>Serial Number: ".($functions->maxId("user_info")+1)."</label>";
            ?>
            <br>
    <label>Lead Priority:</label><br>
    <select name="priority_id" class="form-control form-control-lg">
        <?php
            foreach($leads as $rows1)
            {
                
                ?>
                
                <option value="<?php echo $rows1->id  ?>"><?php echo $rows1->priority_name  ?></option>
                
                <?php
                
            }
        ?>
    </select><br>
    
    <input type="hidden" name="id" value="<?php echo $max; ?>">
    <label>Serial Number:</label><br><input class="form-control form-control-lg" type="number" name="manual_id" value=""><br>
    <label>Date:</label><br><input class="form-control form-control-lg" type="date" name="date" value=""><br>
    <label>Name:</label><br><input class="form-control form-control-lg" type="text" name="name"  value=""><br>
    <label>Phone Number:</label><br><input required class="form-control form-control-lg" type="text" name="phone" value=""><br>
    <label>Email:</label><br><input class="form-control form-control-lg" type="text" name="email"  value=""><br>
    <label>Source:</label><br>
    <select name="apply_source_id" class="form-control form-control-lg">
        <?php
        
            foreach($source as $rows2)
            {
                
                ?>

                <option value="<?php echo $rows2->id  ?>"><?php echo $rows2->source_name  ?></option>
                
                <?php
                
            }
        ?>
    </select><br>
    <label>Country:</label><br>
    <select name="country_id" class="form-control form-control-lg">
        <?php
            foreach($country as $rows3)
            {
                ?>
                <option value="<?php echo $rows3->id  ?>"><?php echo $rows3->country_name  ?></option>
                
                <?php
                
            }
        ?>
    </select><br>
    <label>Visited:</label><br><input class="form-control form-control-lg" type="text" name="visited" value=""><br>
    <label>Inquiry Form Location:</label><br>
    <select name="inquiry_form_location_id" class="form-control form-control-lg">
        <?php
            foreach($inquiry as $rows4)
            {
                ?>
                <option value="<?php echo $rows4->id  ?>"><?php echo $rows4->inquiry_location  ?></option>
                
                <?php
                
            }
        ?>
    </select><br>

    <label>Consultant:</label><br>
    <select name="consultant_id" class="form-control form-control-lg">
        <?php
            foreach($consultant as $rows5)
            {
                ?>
                <option value="<?php echo $rows5->id  ?>"><?php echo $rows5->consultant_name  ?></option>
                
                <?php
                
            }
        ?>
    </select><br>

    <label>Qualification:</label><br><input class="form-control form-control-lg" type="text" name="qualification" value=""><br>
    <label>Comments/Inquiry:</label><br><input class="form-control form-control-lg" type="text" name="comment" value=""><br>
    <label>Expected Budget:</label><br><input class="form-control form-control-lg" type="text" name="budget" value=""><br>
    <input class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0" type="submit" value="Insert" name="update_done">
<?php
// }

// else
// {
//     header("Location:show_data.php");
// }

?>
</div></div></div>
</form>

<?php
?>