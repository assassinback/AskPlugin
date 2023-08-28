<?php
$page_name="Add Admins";
use Inc\Api\Functions;
$functions=new Functions();
if(isset($_POST["add_done"]))
{
    $new_data["user_type"]=$_POST["user_type"];
    $new_data["username"]=$_POST["username"];
    $new_data["password"]=$_POST["password"];
    $new_data["full_name"]=$_POST["full_name"];
    $functions->insertData("admin_info",$new_data);
    // header("Location:show_users.php");
}
?>

<?php
// if(checkPrivilage($_SESSION["user_type"],"admin"))
// {

?>
<form method="POST" style="margin-top:220px !important;">
<div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
        <?php
                echo "<label class='form-control-lg'>Serial Number: ".($functions->get_max_id("admin_info")+1)."</label>";
            ?>
            <br>
<label>User Type:</label><br>
    <select name="user_type" class="form-control form-control-lg">
        <option value="admin">Admin</option>
        <option value="accounts">Accounts</option>
        <option value="case_admin">Case Admin</option>
        <option value="counsellor">Counsellor</option>
    </select><br><br>
    <label>Username:</label><br><input class="form-control form-control-lg" type="text" name="username"><br><br>
    <label>Password:</label><br><input class="form-control form-control-lg" type="text" name="password"><br><br>
    <label>Full Name:</label><br><input class="form-control form-control-lg" type="text" name="full_name"><br><br>
    <input type="submit" value="Insert" name="add_done" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">
    </div></div></div>
</form>
<?php
// }
// else
// {
//     header("Location:show_inprocess.php");
// }



?>















