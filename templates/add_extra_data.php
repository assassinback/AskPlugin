<?php
$page_name="Add Extra Data";
use Inc\Api\Functions;
$functions=new Functions();
?>
<?php
    if(isset($_POST["extras"]))
    {
        $functions->insertDataExtra($_POST["extras"],$_POST["extra_value"]);
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
<label>Enter Value: </label><br>
<input type="text" name="extra_value" class="form-control form-control-lg"><br>
<label>Select Type: </label><br>
<select name="extras" class="form-control form-control-lg">
        <!-- Leads  -->
    <option value="consultant">Consultant Name</option>
    <option value="country">Country</option>
    <option value="inquiry_form_location">Inquiry Form Location</option>
    <option value="lead_priority">Lead Priority Name</option>
    <option value="source">Source Name</option>
        <!-- In Process  -->
    <option value="case_status">Case Status</option>
    <option value="destination">Destination</option>
    <option value="fee_status">Fee Status</option>
        <!-- Follow Up -->
    <option value="call_outcome">Call Outcome</option>    
    <option value="follow_up_action">Follow Up Action</option>
</select><br><br>
<input type="submit" name="submit" value="Save" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">
</div></div></div>
</form>
<?php
// }
// else
// {
//     header("Location:show_inprocess.php");
// }
?>


