<?php
$page_name="Show Consultants";
use Inc\Api\Functions;
$functions=new Functions();
if(isset($_POST["delete"]))
{
    $data["enabled"]=0;
    $functions->disableData("consultant",$data,"id=".$_POST["delete"]);
}
?>
<div class="container-fluid py-4">
      <div class="row">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h1>Students Consultants</h1>
            </div>
<?php

// if(checkPrivilage($_SESSION["user_type"],"admin"))
// {
$outcome=$functions->selectData("consultant","enabled=1");

echo "<div class='card-body px-0 pt-0 pb-2'>
<div class='table-responsive p-0'><table class='table align-items-center mb-0'>";
    echo "<thead><tr>";
echo "<th class='text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7'>S.No</th>";
echo "<th class='text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7'>Consultant Name</th>";
echo "<th class='text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7'>Update</th>";
echo "<th class='text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7'>Delete</th>";
echo "</tr></thead>";

foreach($outcome as $rows)
{
    echo "<tr>";
    echo "<td class='text-center text-secondary text-xs font-weight-bold'>".$rows->id."</td>";
    echo "<td class='text-center text-secondary text-xs font-weight-bold'>".$rows->consultant_name."</td>";
    echo "<td class='text-center text-secondary text-xs font-weight-bold'><form method='POST' action='update_consultant.php'><input type='hidden' name='update' value='".$rows->id."'><input type='submit' name='update_btn' value='Update' style='background-color:transparent;border:none;' class='text-secondary font-weight-bold text-xs'></form></td>";
    echo "<td class='text-center text-secondary text-xs font-weight-bold'><form method='POST'><input type='hidden' name='delete' value='".$rows->id."'><input type='submit' name='delete_btn' value='Delete' style='background-color:transparent;border:none;' class='text-secondary font-weight-bold text-xs'></form></td>";
    echo "</tr>";
}



echo "</tbody></table></div></div></div></div></div></div>";
// }
// else
// {
//     header("Location:show_inprocess.php");
// }
?>







<?php
// require("footer.php");

?>