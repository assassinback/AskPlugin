<?php
$page_name="Completed Case";
use Inc\Api\Functions;
$functions=new Functions();
if(isset($_POST["delete"]))
{
    $data["enabled"]=0;
    $functions->disableData("completed",$data,"id=".$_POST["delete"]);
}
if(isset($_POST["update_btn"]))
{
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
    $functions->updateData("completed",$new_data,"id=".$_POST["update"]);
}
if(isset($_POST["send_back"]))
{
    $data12["enabled"]=0;
    $user_data=$functions->selectData("completed","id=".$_POST["send_back"]);
    if($functions->selectCount("in_process","id=".$_POST["send_back"])>0)
    {
        $data["enabled"]=1;
        $functions->disableData("in_process",$data,"id=".$_POST["send_back"]);
    }
    else
    {
        foreach($user_data as $rows)
        {
            $data1["id"]=$rows->id;
            $data1["case_assign_date"]=date("j/n/Y");
            $data1["name"]=$rows->full_name;
            $data1["phone"]=$rows->phone_number;
            $data1["email"]=$rows->email;
            $data1["destination_1"]=1;
            $data1["counselor"]=1;
            $data1["fee_status"]=1;
            $data1["destination_2"]=1;
            $data1["case_status_1"]=1;
            $data1["case_status_2"]=1;
            global $current_user;
            $data1["insert_admin"]=$current_user->user_login;
            $functions->insertData("in_process",$data1);
        }
    }
    
    $functions->disableData("completed",$data12,"id=".$_POST["send_back"]);
}
?>
<?php

// if(checkPrivilage($_SESSION["user_type"],"admin") || checkPrivilage($_SESSION["user_type"],"accounts") || checkPrivilage($_SESSION["user_type"],"case_admin"))
// {
$functions->create_forms_completed($page_name);
if(isset($_POST["user_id"]))
{
    $user_data=$functions->get_single_completed_new($_POST["user_id"]);
}
else
{
    $user_data=$functions->selectData("completed","enabled=1");   
}

$functions->show_completed_table();
$functions->show_completed_data($user_data);
// }
?>