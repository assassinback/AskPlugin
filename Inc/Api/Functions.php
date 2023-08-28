<?php
/**
 * @package Ask_Portal
 */

namespace Inc\Api;

use wpdb;

class Functions
{
    function insertData($table="", $data=array()) {
        global $wpdb;

        $prefix=$wpdb->prefix;
        
        if ($table == "" || count($data) == 0) {
            return false;
        }
        
        $columns = array();
        $table_name=$prefix . $table;
        // $values = array_values($data);
        foreach ($data as $key=>$value) {
            // $columns[] = $key . ' = ?';
            $columns[$key]=$value;
        }
        // $columns = implode(', ', $columns);
        // $format = array('%s','%d');
        // $sql = 'INSERT INTO ' . $prefix . $table . ' SET ' . $columns;
        $wpdb->insert($table_name, $columns);
        //echo $db->last_query();
        
        $insert_id = $wpdb->insert_id;
        return $insert_id;
    }
    function insertDataExtra($table="",$name="")
    {
        global $wpdb;

        $prefix=$wpdb->prefix;
        // $table_name=$prefix . $table;
        $query = 'INSERT INTO ' . $prefix . $table . " VALUES (NULL, '%s', 1)";
        $sql = $wpdb->prepare($query,$name);

        $wpdb->query($sql);
        
        // $wpdb->query($sql);
        //echo $db->last_query();
        
        $insert_id = $wpdb->insert_id;
        return $insert_id;
    }
    function insertData_old($table="", $data=array()) {
        global $wpdb;

        $prefix=$wpdb->prefix;
        
        if ($table == "" || count($data) == 0) {
            return false;
        }
        
        $columns = array();
        $values = array_values($data);
        foreach ($data as $key=>$value) {
            $columns[] = $key . ' = ?';
        }
        $columns = implode(', ', $columns);
        $format = array('%s','%d');
        $sql = 'INSERT INTO ' . $prefix . $table . ' SET ' . $columns;
        $wpdb->insert($sql, $values,$format);
        //echo $db->last_query();
        
        $insert_id = $wpdb->insert_id;
        return $insert_id;
    }
    function maxId($table="",$where="",$data=array())
    {
        global $wpdb;

        $prefix=$wpdb->prefix;
        
        if ($table == "") {
            return false;
        }
        if($data!=null)
        {
            $columns = array();
            $values = array_values($data);
            foreach ($data as $key=>$value) {
                $columns[] = $key . ' = ?';
            }
            $columns = implode(', ', $columns);
        }
        $sql = "SELECT max(id) as max FROM {$prefix}user_info UNION SELECT max(id)  from {$prefix}in_process UNION SELECT max(id) FROM {$prefix}completed;";
        
        if ($where != "") {
            $sql .= ' WHERE ' . $where; 
        }
        if($data==null)
        {
            $update = $wpdb->get_results($sql);
        }
        else
        {
            $update = $wpdb->get_results($sql);
        }
        
        //echo $db->last_query();
        $row=$update;
        $max=0;
        // var_dump($row);
        foreach($row as $rows)
        {
            if($max<$rows->max)
            {
                $max=$rows->max;
            }
        }
        return $max;
    }
    
    
    function deleteData($table="", $data=array(), $where="") {
        global $db, $dbPrefix, $list;
        
        if ($table == "" || count($data) == 0) {
            return false;
        }
        
        $columns = array();
        $values = array_values($data);
        foreach ($data as $key=>$value) {
            $columns[] = $key . ' = ?';
        }
        $columns = implode(', ', $columns);
        
        $sql = 'DELETE FROM ' . $dbPrefix . $table;
        
        if ($where != "") {
            $sql .= ' WHERE ' . $where; 
        }
        $update = $db->query($sql, $values);
        //echo $db->last_query();
        
        return $update;
    }
    
    function updateData($table="", $data=array(), $where="") {
        global $db, $dbPrefix, $list;
        
        if ($table == "" || count($data) == 0) {
            return false;
        }
        
        $columns = array();
        $values = array_values($data);
        foreach ($data as $key=>$value) {
            $columns[] = $key . ' = ?';
        }
        $columns = implode(', ', $columns);
        
        $sql = 'UPDATE ' . $dbPrefix . $table . ' SET ' . $columns;
        
        if ($where != "") {
            $sql .= ' WHERE ' . $where; 
        }
        $update = $db->query($sql, $values);
        //echo $db->last_query();
        
        return $update;
    }
    
    function disableData($table="", $data=array(), $where="") {
        global $db, $dbPrefix, $list;
        
        if ($table == "" || count($data) == 0) {
            return false;
        }
        
        $columns = array();
        $values = array_values($data);
        foreach ($data as $key=>$value) {
            $columns[] = $key . ' = ?';
        }
        $columns = implode(', ', $columns);
        
        $sql = 'UPDATE ' . $dbPrefix . $table . ' SET ' . $columns;
        
        if ($where != "") {
            $sql .= ' WHERE ' . $where; 
        }
        $update = $db->query($sql, $values);
        //echo $db->last_query();
        
        return $update;
    }
    
    
    
    
    
    function checkAdminLogin() {
        if (isset($_SESSION['adminsessionid'])) {
            return true;
        } else {
            return false;
        }
    }
    
    
    
    
    
    function checkLogin() {
        global $db, $dbPrefix;
        if (isset($_SESSION['id'])) {
            $result = $db->query('SELECT * FROM ' . $dbPrefix . 'user WHERE id = ? AND status = 1', array($_SESSION['id']));
            if ($result->num_rows() > 0) {
                return true;
            } else {
                unset($_SESSION['id']);
                unset($_SESSION['user_type']);
                return false;
            }
        } else {
            return false;
        }
    }
    function checkLoginAsk() {
        global $db, $dbPrefix;
        if (isset($_SESSION['id'])) {
            $result = $db->query('SELECT * FROM ' . $dbPrefix . 'admin_info WHERE username = ? AND password = ?', array($_POST['username'],$_POST['password']));
            if ($result->num_rows() > 0) {
                return true;
            } else {
                unset($_SESSION['id']);
                unset($_SESSION['user_type']);
                return false;
            }
        } else {
            return false;
        }
    }
    
    
    function getTableList($table, $list, $id="", $single=true) {
        global $db, $dbPrefix;
        
        $tableList = $list;
        
        if ((count($tableList) == 0) || (($id) && !isset($tableList[$id]))) {
            $rows = $db->query('SELECT * FROM ' . $dbPrefix . $table . ' WHERE status = 1', array());
            foreach($rows->result_array() as $row) {
                $tableList[$row['id']] = $row['name'];
            }
            $list = $tableList;
        }
        
        if ($id) {
            if (isset($tableList[$id])) {
                return $tableList[$id];
            } else {
                return null;
            }
        } else {
            if ($single) {
                return null;
            } else {
                return $tableList;
            }
        }
    }
    
    
    
    
    
    
    function get_all_data_follow($type,$date)
    {
        global $db, $dbPrefix, $list;
        $query="SELECT users.id as main_id,users.apply_date, users.full_name,users.phone_number,users.email,users.visited,users.qualification,users.comments,users.budget,lead.priority_name,sources.source_name,countries.country_name,inquiry.inquiry_location,consultants.consultant_name, follow.id,follow.user_id,follow.follow_up_number,follow.follow_up_date,follow.additional_comment,follow.staff_member,actions.action_name,outcome.outcome_name FROM user_info as users INNER JOIN lead_priority as lead on users.priority_id=lead.id INNER JOIN source as sources on users.apply_source_id=sources.id INNER JOIN country as countries ON users.country_id=countries.id INNER JOIN inquiry_form_location as inquiry ON users.inquiry_form_location_id=inquiry.id INNER JOIN consultant as consultants ON users.consultant_id=consultants.id LEFT JOIN follow_up_info as follow ON users.id=follow.user_id INNER JOIN call_outcome as outcome on follow.follow_up_outcome_id=outcome.id INNER JOIN follow_up_action as actions ON follow.follow_up_action_id=actions.id WHERE follow.follow_up_date LIKE '%$type%' AND follow.follow_up_date LIKE '%$date%';";
        // echo $query;
        $result=$db->query($query);
        $row=$result->result_array();
        // fix_arrays($row);
        return $row;
    }
    function get_all_data_follow_new($date)
    {
        global $db, $dbPrefix, $list;
        $query="SELECT users.insert_admin,users.id as main_id,users.apply_date, users.full_name,users.phone_number,users.email,users.visited,users.qualification,users.comments,users.budget,lead.priority_name,sources.source_name,countries.country_name,inquiry.inquiry_location,consultants.consultant_name, follow.id,follow.user_id,follow.follow_up_number,follow.follow_up_date,follow.additional_comment,follow.staff_member,actions.action_name,outcome.outcome_name FROM user_info as users INNER JOIN lead_priority as lead on users.priority_id=lead.id INNER JOIN source as sources on users.apply_source_id=sources.id INNER JOIN country as countries ON users.country_id=countries.id INNER JOIN inquiry_form_location as inquiry ON users.inquiry_form_location_id=inquiry.id INNER JOIN consultant as consultants ON users.consultant_id=consultants.id LEFT JOIN follow_up_info as follow ON users.id=follow.user_id INNER JOIN call_outcome as outcome on follow.follow_up_outcome_id=outcome.id INNER JOIN follow_up_action as actions ON follow.follow_up_action_id=actions.id WHERE follow.follow_up_date ='$date'";
        // echo $query;
        $result=$db->query($query);
        $row=$result->result_array();
        // fix_arrays($row);
        return $row;
    }
    function get_follow_inprocess($type,$date)
    {
        global $db, $dbPrefix, $list;
        $query="SELECT in_process.ask_email,in_process.id,in_process.case_assign_date,in_process.name,in_process.phone,in_process.email
        ,des1.destination_name as dest_1,cou1.consultant_name,in_process.comments,fee1.status_name,in_process.admin,in_process.university_1,in_process.outcome_destination_1,case_status1.status_name as case_status_1,des2.destination_name as dest_2,
        in_process.case_handler_2,in_process.intake,in_process.university_2,in_process.outcome_destination_2,case_status2.status_name as case_status_2,in_process.course,in_process.case_handler_2,in_process.missing_docs,in_process.final_comments 
        FROM in_process as in_process 
        INNER JOIN destination as des1 ON in_process.destination_1=des1.id
        INNER JOIN destination as des2 ON in_process.destination_2=des2.id
        INNER JOIN consultant as cou1 ON in_process.counselor=cou1.id 
        INNER JOIN case_status as case_status1 ON in_process.case_status_1=case_status1.id 
        INNER JOIN case_status as case_status2 ON in_process.case_status_2=case_status2.id 
        INNER JOIN fee_status as fee1 ON in_process.fee_status=fee1.id
        LEFT JOIN follow_up_inprocess as follow ON in_process.id=follow.user_id
        WHERE in_process.enabled=1 AND follow.follow_up_date LIKE '%$type%' AND follow.follow_up_date LIKE '%$date%';";
        // echo $query;
        $result=$db->query($query);
        $row=$result->result_array();
        return $row;
    }
    function get_follow_inprocess_new($combined)
    {
        global $db, $dbPrefix, $list;
        $query="SELECT in_process.insert_admin,in_process.ask_email,in_process.id,in_process.case_assign_date,in_process.name,in_process.phone,in_process.email
        ,des1.destination_name as dest_1,cou1.consultant_name,in_process.comments,fee1.status_name,in_process.admin,in_process.university_1,in_process.outcome_destination_1,case_status1.status_name as case_status_1,des2.destination_name as dest_2,
        in_process.case_handler_2,in_process.intake,in_process.university_2,in_process.outcome_destination_2,case_status2.status_name as case_status_2,in_process.course,in_process.case_handler_2,in_process.missing_docs,in_process.final_comments 
        FROM in_process as in_process 
        INNER JOIN destination as des1 ON in_process.destination_1=des1.id
        INNER JOIN destination as des2 ON in_process.destination_2=des2.id
        INNER JOIN consultant as cou1 ON in_process.counselor=cou1.id 
        INNER JOIN case_status as case_status1 ON in_process.case_status_1=case_status1.id 
        INNER JOIN case_status as case_status2 ON in_process.case_status_2=case_status2.id 
        INNER JOIN fee_status as fee1 ON in_process.fee_status=fee1.id
        LEFT JOIN follow_up_inprocess as follow ON in_process.id=follow.user_id
        WHERE in_process.enabled=1 AND follow.follow_up_date = '$combined';";
        // echo $query;
        $result=$db->query($query);
        $row=$result->result_array();
        return $row;
    }
    // function get_single_user_data($id)
    // {
    //     global $db, $dbPrefix, $list;
    //     $query="SELECT users.id as main_id,users.apply_date, users.full_name,users.phone_number,users.visited,users.qualification,users.comments,users.budget,lead.priority_name,sources.source_name,countries.country_name,inquiry.inquiry_location,consultants.consultant_name, follow.id,follow.user_id,follow.follow_up_number,follow.follow_up_date,follow.additional_comment,follow.staff_member,actions.action_name,outcome.outcome_name FROM user_info as users INNER JOIN lead_priority as lead on users.priority_id=lead.id INNER JOIN source as sources on users.apply_source_id=sources.id INNER JOIN country as countries ON users.country_id=countries.id INNER JOIN inquiry_form_location as inquiry ON users.inquiry_form_location_id=inquiry.id INNER JOIN consultant as consultants ON users.consultant_id=consultants.id LEFT JOIN follow_up_info as follow ON users.id=follow.user_id INNER JOIN call_outcome as outcome on follow.follow_up_outcome_id=outcome.id INNER JOIN follow_up_action as actions ON follow.follow_up_action_id=actions.id where users.id=$id;";
    //     $result=$db->query($query);
    //     $row=$result->result_array();
    //     fix_arrays($row);
    //     return $row;
    // }
    function get_all_data($min=0,$max=1000)
    {
        global $wpdb;
        $prefix=$wpdb->prefix;
        $query='SELECT users.insert_admin,users.email,users.enabled,users.id as main_id,users.apply_date, users.full_name,users.phone_number,users.visited,users.qualification,users.comments,users.budget,lead.priority_name,sources.source_name,countries.country_name,inquiry.inquiry_location,consultants.consultant_name FROM '.$prefix.'user_info as users INNER JOIN '.$prefix.'lead_priority as lead on users.priority_id=lead.id INNER JOIN '.$prefix.'source as sources on users.apply_source_id=sources.id INNER JOIN '.$prefix.'country as countries ON users.country_id=countries.id INNER JOIN '.$prefix.'inquiry_form_location as inquiry ON users.inquiry_form_location_id=inquiry.id INNER JOIN '.$prefix.'consultant as consultants ON users.consultant_id=consultants.id WHERE users.enabled=1  AND users.id BETWEEN '.$min.' AND '.$max.';';
        $result=$wpdb->get_results($query);
        // $row=$result->result_array();
        return $result;
    }
    function get_all_users()
    {
        global $db, $dbPrefix, $list;
        $query="SELECT users.enabled,users.id as main_id,users.apply_date, users.full_name,users.phone_number,users.visited,users.qualification,users.comments,users.budget,lead.priority_name,sources.source_name,countries.country_name,inquiry.inquiry_location,consultants.consultant_name FROM user_info as users INNER JOIN lead_priority as lead on users.priority_id=lead.id INNER JOIN source as sources on users.apply_source_id=sources.id INNER JOIN country as countries ON users.country_id=countries.id INNER JOIN inquiry_form_location as inquiry ON users.inquiry_form_location_id=inquiry.id INNER JOIN consultant as consultants ON users.consultant_id=consultants.id WHERE users.enabled=1;";
        $result=$db->query($query);
        $row=$result->result_array();
        return $row;
    }
    function get_single_user_data($id)
    {
        global $db, $dbPrefix, $list;
        $query="SELECT users.email,users.enabled,users.id as main_id,users.apply_date, users.full_name,users.phone_number,users.visited,users.qualification,users.comments,users.budget,lead.priority_name,sources.source_name,countries.country_name,inquiry.inquiry_location,consultants.consultant_name FROM user_info as users INNER JOIN lead_priority as lead on users.priority_id=lead.id INNER JOIN source as sources on users.apply_source_id=sources.id INNER JOIN country as countries ON users.country_id=countries.id INNER JOIN inquiry_form_location as inquiry ON users.inquiry_form_location_id=inquiry.id INNER JOIN consultant as consultants ON users.consultant_id=consultants.id where users.id=$id AND users.enabled=1;";
        $result=$db->query($query);
        $row=$result->result_array();
        return $row;
    }
    function get_single_user_data_new($id)
    {
        global $db, $dbPrefix, $list;
        $query="SELECT users.insert_admin,users.email,users.enabled,users.id as main_id,users.apply_date, users.full_name,users.phone_number,users.visited,users.qualification,users.comments,users.budget,lead.priority_name,sources.source_name,countries.country_name,inquiry.inquiry_location,consultants.consultant_name FROM user_info as users INNER JOIN lead_priority as lead on users.priority_id=lead.id INNER JOIN source as sources on users.apply_source_id=sources.id INNER JOIN country as countries ON users.country_id=countries.id INNER JOIN inquiry_form_location as inquiry ON users.inquiry_form_location_id=inquiry.id INNER JOIN consultant as consultants ON users.consultant_id=consultants.id where (users.id LIKE '%$id%' OR users.full_name LIKE '%$id%' OR users.email LIKE '%$id%' OR users.apply_date LIKE '%$id%' OR users.phone_number LIKE '%$id%') AND users.enabled=1;";
        $result=$db->query($query);
        $row=$result->result_array();
        return $row;
    }
    function get_single_inprocess($id)
    {
        global $db, $dbPrefix, $list;
        $query="SELECT in_process.ask_email,in_process.id,in_process.case_assign_date,in_process.name,in_process.phone,in_process.email
        ,des1.destination_name as dest_1,cou1.consultant_name,in_process.comments,fee1.status_name,in_process.admin,in_process.university_1,in_process.outcome_destination_1,case_status1.status_name as case_status_1,des2.destination_name as dest_2,
        in_process.case_handler_2,in_process.intake,in_process.university_2,in_process.outcome_destination_2,case_status2.status_name as case_status_2,in_process.course,in_process.case_handler_2,in_process.missing_docs,in_process.final_comments 
        FROM in_process as in_process 
        INNER JOIN destination as des1 ON in_process.destination_1=des1.id
        INNER JOIN destination as des2 ON in_process.destination_2=des2.id
        INNER JOIN case_status as case_status1 ON in_process.case_status_1=case_status1.id 
        INNER JOIN case_status as case_status2 ON in_process.case_status_2=case_status2.id 
        INNER JOIN consultant as cou1 ON in_process.counselor=cou1.id 
        INNER JOIN fee_status as fee1 ON in_process.fee_status=fee1.id WHERE in_process.enabled=1 AND in_process.id=$id;";
        $result=$db->query($query);
        $row=$result->result_array();
        return $row;
    }
    function get_single_inprocess_new($id)
    {
        global $db, $dbPrefix, $list;
        $query="SELECT in_process.insert_admin,in_process.ask_email,in_process.id,in_process.case_assign_date,in_process.name,in_process.phone,in_process.email
        ,des1.destination_name as dest_1,cou1.consultant_name,in_process.comments,fee1.status_name,in_process.admin,in_process.university_1,in_process.outcome_destination_1,case_status1.status_name as case_status_1,des2.destination_name as dest_2,
        in_process.case_handler_2,in_process.intake,in_process.university_2,in_process.outcome_destination_2,case_status2.status_name as case_status_2,in_process.course,in_process.case_handler_2,in_process.missing_docs,in_process.final_comments 
        FROM in_process as in_process 
        INNER JOIN destination as des1 ON in_process.destination_1=des1.id
        INNER JOIN destination as des2 ON in_process.destination_2=des2.id
        INNER JOIN case_status as case_status1 ON in_process.case_status_1=case_status1.id 
        INNER JOIN case_status as case_status2 ON in_process.case_status_2=case_status2.id 
        INNER JOIN consultant as cou1 ON in_process.counselor=cou1.id 
        INNER JOIN fee_status as fee1 ON in_process.fee_status=fee1.id WHERE in_process.enabled=1 AND (in_process.id LIKE '%$id%' OR in_process.ask_email LIKE '%$id%' OR in_process.case_assign_date LIKE '%$id%' OR in_process.name LIKE '%$id%' OR in_process.phone LIKE '%$id%' OR in_process.email LIKE '%$id%' OR fee1.status_name LIKE '%$id%' OR case_status1.status_name LIKE '%$id%' OR case_status2.status_name LIKE '%$id%');";
        $result=$db->query($query);
        $row=$result->result_array();
        return $row;
    }
    function get_single_completed_new($id)
    {
        global $db, $dbPrefix, $list;
        $query="SELECT * FROM completed 
        WHERE `enabled`=1 AND 
        (id LIKE '%$id%' OR phone LIKE '%$id%' OR `date` LIKE '%$id%' OR full_name LIKE '%$id%' OR country LIKE '%$id%' OR university LIKE '%$id%' OR consultant LIKE '%$id%' OR visa_status LIKE '%$id%' OR intake LIKE '%$id%');";
        $result=$db->query($query);
        $row=$result->result_array();
        return $row;
    }
    function get_all_follow_up()
    {
        global $db, $dbPrefix, $list;
        $query="SELECT follow.id,follow.user_id,follow.follow_up_number,follow.follow_up_date,follow.additional_comment,follow.staff_member,outcome.outcome_name,actions.action_name from follow_up_info as follow INNER JOIN call_outcome as outcome on follow.follow_up_outcome_id=outcome.id INNER JOIN follow_up_action as actions ON follow.follow_up_action_id=actions.id WHERE follow.enabled=1;";
        $result=$db->query($query);
        $row=$result->result_array();
        return $row;
    }
    function get_single_follow_up($id)
    {
        global $db, $dbPrefix, $list;
        $query="SELECT follow.id,follow.user_id,follow.follow_up_number,follow.follow_up_date,follow.additional_comment,follow.staff_member,outcome.outcome_name,actions.action_name from follow_up_info as follow INNER JOIN call_outcome as outcome on follow.follow_up_outcome_id=outcome.id INNER JOIN follow_up_action as actions ON follow.follow_up_action_id=actions.id WHERE follow.user_id=$id AND follow.enabled=1;";
        $result=$db->query($query);
        $row=$result->result_array();
        return $row;
    }
    function get_single_follow_up_inprocess($id)
    {
        global $db, $dbPrefix, $list;
        $query="SELECT * from follow_up_inprocess WHERE user_id=$id AND enabled=1;";
        $result=$db->query($query);
        $row=$result->result_array();
        return $row;
    }
    function get_single_follow_up_for_one($id)
    {
        global $db, $dbPrefix, $list;
        $query="SELECT follow.id,follow.user_id,follow.follow_up_number,follow.follow_up_date,follow.additional_comment,follow.staff_member,outcome.outcome_name,actions.action_name from follow_up_info as follow INNER JOIN call_outcome as outcome on follow.follow_up_outcome_id=outcome.id INNER JOIN follow_up_action as actions ON follow.follow_up_action_id=actions.id WHERE follow.id=$id AND follow.enabled=1;";
        $result=$db->query($query);
        $row=$result->result_array();
        return $row;
    }
    function get_follow_up_data()
    {
        global $wpdb;
        $prefix=$wpdb->prefix;
        
        global $db, $dbPrefix, $list;
        $query="SELECT in_process.insert_admin,in_process.ask_email,in_process.id,in_process.case_assign_date,in_process.name,in_process.phone,in_process.email
        ,des1.destination_name as dest_1,cou1.consultant_name,in_process.comments,fee1.status_name,in_process.admin,in_process.university_1,in_process.outcome_destination_1,case_status1.status_name as case_status_1,des2.destination_name as dest_2,
        in_process.case_handler_2,in_process.intake,in_process.university_2,in_process.outcome_destination_2,case_status2.status_name as case_status_2,in_process.course,in_process.case_handler_2,in_process.missing_docs,in_process.final_comments 
        FROM {$prefix}in_process as in_process 
        INNER JOIN {$prefix}destination as des1 ON in_process.destination_1=des1.id
        INNER JOIN {$prefix}destination as des2 ON in_process.destination_2=des2.id
        INNER JOIN {$prefix}consultant as cou1 ON in_process.counselor=cou1.id 
        INNER JOIN {$prefix}case_status as case_status1 ON in_process.case_status_1=case_status1.id 
        INNER JOIN {$prefix}case_status as case_status2 ON in_process.case_status_2=case_status2.id 
        INNER JOIN {$prefix}fee_status as fee1 ON in_process.fee_status=fee1.id WHERE in_process.enabled=1;";
        $result=$wpdb->get_results($query);
        return $result;
    }
    function get_single_follow_up_data($id=0)
    {
        global $db, $dbPrefix, $list;
        $query="SELECT in_process.ask_email,in_process.id,in_process.case_assign_date,in_process.name,in_process.phone,in_process.email
        ,des1.destination_name as dest_1,cou1.consultant_name,in_process.comments,fee1.status_name,in_process.admin,in_process.university_1,in_process.outcome_destination_1,case_status1.status_name as case_status_1,des2.destination_name as dest_2,
        in_process.case_handler_2,in_process.intake,in_process.university_2,in_process.outcome_destination_2,case_status2.status_name as case_status_2,in_process.course,in_process.case_handler_2,in_process.missing_docs,in_process.final_comments 
        FROM in_process as in_process 
        INNER JOIN destination as des1 ON in_process.destination_1=des1.id
        INNER JOIN destination as des2 ON in_process.destination_2=des2.id
        INNER JOIN case_status as case_status1 ON in_process.case_status_1=case_status1.id 
        INNER JOIN case_status as case_status2 ON in_process.case_status_2=case_status2.id 
        INNER JOIN consultant as cou1 ON in_process.counselor=cou1.id 
        INNER JOIN fee_status as fee1 ON in_process.fee_status=fee1.id WHERE in_process.enabled=1 AND in_process.id=$id;";
        // echo $query;
        $result=$db->query($query);
        $row=$result->result_array();
        return $row;
    }
    function get_single_follow_up_for_one_inprocess($id)
    {
        global $db, $dbPrefix, $list;
        $query="SELECT * from follow_up_inprocess WHERE id=$id AND `enabled`=1;";
        $result=$db->query($query);
        $row=$result->result_array();
        return $row;
    }
    function get_user_row_count($table="")
    {
        global $db,$dbPrefix,$list;
        $query="SELECT COUNT(*) as rowcount FROM ".$table;
        $result=$db->query($query);
        $row=$result->result_array();
        $count=0;
        foreach($row as $rows)
        {
            $count=$rows["rowcount"];
        }
        return $count;
    }
    function get_max_id($table="")
    {
        global $wpdb,$dbPrefix,$list;
        $prefix=$wpdb->prefix;
        $query="SELECT MAX(Id) as maxid FROM ".$prefix.$table;
        $result=$wpdb->get_results($query);
        // $row=$result->result_array();
        $count=0;
        foreach($result as $rows)
        {
            $count=$rows->maxid;
        }
        return $count;
    }
    function selectCount($table="",$where="", $data=array()) {
        global $db, $dbPrefix, $list;
        
        if ($table == "") {
            return false;
        }
        if($data!=null)
        {
            $columns = array();
            $values = array_values($data);
            foreach ($data as $key=>$value) {
                $columns[] = $key . ' = ?';
            }
            $columns = implode(', ', $columns);
        }
        $sql = 'SELECT COUNT(*) as amount FROM ' . $dbPrefix . $table;
        
        if ($where != "") {
            $sql .= ' WHERE ' . $where; 
        }
        if($data==null)
        {
            $update = $db->query($sql);
        }
        else
        {
            $update = $db->query($sql, $values);
        }
        echo $sql;
        //echo $db->last_query();
        $row=$update->result_array();
        foreach($row as $rows)
        {
            return $rows["amount"];
        }
        // return $row;
    }
    function selectData($table="",$where="", $data=array()) {
        global $wpdb;

        $prefix=$wpdb->prefix;
        
        // $row=$result->result_array();
        
        if ($table == "") {
            return false;
        }
        if($data!=null)
        {
            $columns = array();
            $values = array_values($data);
            foreach ($data as $key=>$value) {
                $columns[] = $key . ' = ?';
            }
            $columns = implode(', ', $columns);
        }
        $sql = 'SELECT * FROM ' . $prefix . $table;
        
        if ($where != "") {
            $sql .= ' WHERE ' . $where; 
        }
        if($data==null)
        {
            $result=$wpdb->get_results($sql);
        }
        else
        {
            $result=$wpdb->get_results($sql);
        }
        
        //echo $db->last_query();
        return $result;
        
    }
    function selectNumRows($table="",$where="", $data=array()) {
        // global $db, $dbPrefix, $list;
        global $wpdb;

        $prefix=$wpdb->prefix;
        if ($table == "") {
            return false;
        }
        if($data!=null)
        {
            $columns = array();
            $values = array_values($data);
            foreach ($data as $key=>$value) {
                $columns[] = $key . ' = ?';
            }
            $columns = implode(', ', $columns);
        }
        $sql = 'SELECT * FROM ' . $prefix . $table;
        
        if ($where != "") {
            $sql .= ' WHERE ' . $where; 
        }
        if($data==null)
        {
            $result=$wpdb->get_results($sql);
        }
        else
        {
            $result=$wpdb->get_results($sql);
        }
        // echo count($result);
        return count($result);
    }
    function checkPrivilage($check="",$required="")
    {
        if(isset($_SESSION["username"]))
        {
            if($check==$required)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            header("Location:login.php");
        }
        return false;
    }
    function checkLoggedin()
    {
        if(isset($_SESSION["username"]))
        {
            return true;
        }
        else
        {
            header("Location:login.php");
            return false;
        }
        return false;
    }
    function show_leads_table()
    {
        echo "<div class='card-body px-0 pt-0 pb-2'>
        <div class='table-responsive p-0'><table class='table align-items-center mb-0'>";
        echo "<thead><tr>";
        echo "<th class='text-center text-uppercase text-xs font-weight-bolder opacity-10'>S.No</th>";
        // if($this->checkPrivilage($_SESSION["user_type"],"admin") || $this->checkPrivilage($_SESSION["user_type"],"counsellor"))
        // {
            echo "<th class='text-center text-uppercase text-xs font-weight-bolder opacity-10'>Update</th>";
            
        // }
        echo "<th class='text-center text-uppercase text-xs font-weight-bolder opacity-10'>Follow Up Data</th>";
        
        echo "<th class='text-center text-uppercase text-xs font-weight-bolder opacity-10'>Lead priority</th>";
        echo "<th class='text-center text-uppercase text-xs font-weight-bolder opacity-10'>Date</th>";
        echo "<th class='text-center text-uppercase text-xs font-weight-bolder opacity-10'>Name</th>";
        echo "<th class='text-center text-uppercase text-xs font-weight-bolder opacity-10'>Phone Number</th>";
        echo "<th class='text-center text-uppercase text-xs font-weight-bolder opacity-10'>Email</th>";
        echo "<th class='text-center text-uppercase text-xs font-weight-bolder opacity-10'>Sources</th>";
        echo "<th class='text-center text-uppercase text-xs font-weight-bolder opacity-10'>Country</th>";
        echo "<th class='text-center text-uppercase text-xs font-weight-bolder opacity-10'>Visited</th>";
        echo "<th class='text-center text-uppercase text-xs font-weight-bolder opacity-10'>Inquiry Form Location</th>";
        echo "<th class='text-center text-uppercase text-xs font-weight-bolder opacity-10'>Consultant</th>";
        echo "<th class='text-center text-uppercase text-xs font-weight-bolder opacity-10'>Qualification</th>";
        echo "<th class='text-center text-uppercase text-xs font-weight-bolder opacity-10'>Comments/Inquiry</th>";
        echo "<th class='text-center text-uppercase text-xs font-weight-bolder opacity-10'>Expected Budget</th>";
        echo "<th class='text-center text-uppercase text-xs font-weight-bolder opacity-10'>Insertion Admin</th>";
        echo "<th class='text-center text-uppercase text-xs font-weight-bolder opacity-10'>Send to Inprocess</th>";
        // if($this->checkPrivilage($_SESSION["user_type"],"admin") || $this->checkPrivilage($_SESSION["user_type"],"counsellor"))
        // {
            echo "<th class='text-center text-uppercase text-xs font-weight-bolder opacity-10'>Delete</th>";
        // }
        echo "</tr></thead><tbody>";
    }
    function show_leads_data($user_data)
    {
        foreach($user_data as $rows)
        {
            // echo $i."-".$rows["full_name"]."<br>";
            // $i++;
        
            
        
            echo "<tr>";
            echo "<td class='text-center text-secondary text-xs font-weight-bold'>".$rows->main_id."</td>";
            // if($this->checkPrivilage($_SESSION["user_type"],"admin") || $this->checkPrivilage($_SESSION["user_type"],"counsellor"))
            // {
                echo "<td class='text-center text-secondary text-xs font-weight-bold'><form method='POST' action='update_user.php'><input type='hidden' name='update' value='".$rows->main_id."'><input style='background-color:transparent;border:none;' class='text-secondary font-weight-bold text-xs' type='submit' name='update_btn' value='Update'></form></td>";
                
            // }
            echo "<td class='text-center text-secondary text-xs font-weight-bold'><form method='POST' action='follow_up.php'><input type='hidden' name='follow' value='".$rows->main_id."'><input type='submit' name='follow_btn' value='Follow Up' style='background-color:transparent;border:none;' class='text-secondary font-weight-bold text-xs'></form></td>";
            
            echo "<td class='text-center text-secondary text-xs font-weight-bold'>".$rows->priority_name."</td>";
            echo "<td class='text-center text-secondary text-xs font-weight-bold' style='width:10px !important;'>".$rows->apply_date."</td>";
            echo "<td class='text-center text-secondary text-xs font-weight-bold'>".$rows->full_name."</td>";
            echo "<td class='text-center text-secondary text-xs font-weight-bold'>".$rows->phone_number."</td>";
            echo "<td class='text-center text-secondary text-xs font-weight-bold'>".$rows->email."</td>";
            echo "<td class='text-center text-secondary text-xs font-weight-bold'>".$rows->source_name."</td>";
            echo "<td class='text-center text-secondary text-xs font-weight-bold'>".$rows->country_name."</td>";
            echo "<td class='text-center text-secondary text-xs font-weight-bold'>".$rows->visited."</td>";
            echo "<td class='text-center text-secondary text-xs font-weight-bold'>".$rows->inquiry_location."</td>";
            echo "<td class='text-center text-secondary text-xs font-weight-bold'>".$rows->consultant_name."</td>";
            echo "<td class='text-center text-secondary text-xs font-weight-bold'>".$rows->qualification."</td>";
            echo "<td class='text-center text-secondary text-xs font-weight-bold'>".$rows->comments."</td>";
            echo "<td class='text-center text-secondary text-xs font-weight-bold'>".$rows->budget."</td>";
            echo "<td class='text-center text-secondary text-xs font-weight-bold'>".$rows->insert_admin."</td>";
            echo "<td class='text-center text-secondary text-xs font-weight-bold'><form method='POST' action='send_to_inprocess.php'><input type='hidden' name='inprocess' value='".$rows->main_id."'><input type='submit' name='inprocess_btn' value='Send to Inprocess' style='background-color:transparent;border:none;' class='text-secondary font-weight-bold text-xs'></form></td>";
            // if($this->checkPrivilage($_SESSION["user_type"],"admin") || $this->checkPrivilage($_SESSION["user_type"],"counsellor"))
            // {
            echo "<td class='text-center text-secondary text-xs font-weight-bold'><form method='POST' action='delete_user.php'><input type='hidden' name='delete' value='".$rows->main_id."'><input type='submit' name='delete_btn' value='Delete' style='background-color:transparent;border:none;' class='text-secondary font-weight-bold text-xs'></form></td>";
            // }
            echo "</tr>";
        
        
        
            
        }
        echo "</tbody></table></div></div></div></div></div></div>";
    }
    function show_inprocess_table()
    {
        echo "<div class='card-body px-0 pt-0 pb-2'>
    <div class='table-responsive p-0'><table class='table align-items-center mb-0'>";
        echo "<thead><tr>";
    echo "<th class='text-center text-uppercase text-xs font-weight-bolder opacity-10'>S.No</th>";
    // if($this->checkPrivilage($_SESSION["user_type"],"admin") || $this->checkPrivilage($_SESSION["user_type"],"accounts") || $this->checkPrivilage($_SESSION["user_type"],"case_admin"))
    // {
    echo "<th class='text-center text-uppercase text-xs font-weight-bolder opacity-10'>Update</th>";
    
    // }
    echo "<th class='text-center text-uppercase text-xs font-weight-bolder opacity-10'>Follow Up Data</th>";
    
    echo "<th class='text-center text-uppercase text-xs font-weight-bolder opacity-10'>Case Assign Date</th>";
    echo "<th class='text-center text-uppercase text-xs font-weight-bolder opacity-10'>Name</th>";
    echo "<th class='text-center text-uppercase text-xs font-weight-bolder opacity-10'>Phone</th>";
    echo "<th class='text-center text-uppercase text-xs font-weight-bolder opacity-10'>Email</th>";
    echo "<th class='text-center text-uppercase text-xs font-weight-bolder opacity-10'>ASK Email</th>";
    echo "<th class='text-center text-uppercase text-xs font-weight-bolder opacity-10'>Destination 1</th>";
    echo "<th class='text-center text-uppercase text-xs font-weight-bolder opacity-10'>Counseller</th>";
    echo "<th class='text-center text-uppercase text-xs font-weight-bolder opacity-10'>Comments</th>";
    echo "<th class='text-center text-uppercase text-xs font-weight-bolder opacity-10'>Fee Status</th>";
    echo "<th class='text-center text-uppercase text-xs font-weight-bolder opacity-10'>Case Handler 1</th>";
    echo "<th class='text-center text-uppercase text-xs font-weight-bolder opacity-10'>University 1</th>";
    echo "<th class='text-center text-uppercase text-xs font-weight-bolder opacity-10'>Outcome Destination 1</th>";
    echo "<th class='text-center text-uppercase text-xs font-weight-bolder opacity-10'>Case Status 1</th>";
    echo "<th class='text-center text-uppercase text-xs font-weight-bolder opacity-10'>Destination 2</th>";
    echo "<th class='text-center text-uppercase text-xs font-weight-bolder opacity-10'>Case Handler 2</th>";
    echo "<th class='text-center text-uppercase text-xs font-weight-bolder opacity-10'>University 2</th>";
    echo "<th class='text-center text-uppercase text-xs font-weight-bolder opacity-10'>Outcome Destination 2</th>";
    echo "<th class='text-center text-uppercase text-xs font-weight-bolder opacity-10'>Case Status 2</th>";
    echo "<th class='text-center text-uppercase text-xs font-weight-bolder opacity-10'>Course</th>";
    echo "<th class='text-center text-uppercase text-xs font-weight-bolder opacity-10'>Intake</th>";
    echo "<th class='text-center text-uppercase text-xs font-weight-bolder opacity-10'>Missing Documents</th>";
    echo "<th class='text-center text-uppercase text-xs font-weight-bolder opacity-10'>Final Comments</th>";
    echo "<th class='text-center text-uppercase text-xs font-weight-bolder opacity-10'>Insertion Admin</th>";
    // if($this->checkPrivilage($_SESSION["user_type"],"admin") || $this->checkPrivilage($_SESSION["user_type"],"accounts") || $this->checkPrivilage($_SESSION["user_type"],"case_admin"))
    // {
        echo "<th class='text-center text-uppercase text-xs font-weight-bolder opacity-10'>Delete</th>";
        
    // }
    // if($this->checkPrivilage($_SESSION["user_type"],"admin") || $this->checkPrivilage($_SESSION["user_type"],"counsellor"))
    // {
        echo "<th class='text-center text-uppercase text-xs font-weight-bolder opacity-10'>Send Back to Leads</th>";
    // }
    echo "<th class='text-center text-uppercase text-xs font-weight-bolder opacity-10'>Send to Completed</th>";
    echo "</tr></thead>";
    }
    function show_inprocess_data($user_data)
    {
        foreach($user_data as $rows)
        {
            echo "<tr>";
            echo "<td class='text-center text-secondary text-xs font-weight-bold'>".$rows->id."</td>";
            // if($this->checkPrivilage($_SESSION["user_type"],"admin") || $this->checkPrivilage($_SESSION["user_type"],"accounts") || $this->checkPrivilage($_SESSION["user_type"],"case_admin"))
            // {
            echo "<td class='text-center text-secondary text-xs font-weight-bold'><form method='POST' action='update_inproces.php'><input type='hidden' name='update' value='".$rows->id."'><input type='submit' name='update_btn' value='Update' style='background-color:transparent;border:none;' class='text-secondary font-weight-bold text-xs'></form></td>";
            
            // }
            echo "<td class='text-center text-secondary text-xs font-weight-bold'><form method='POST' action='follow_up_inprocess.php'><input type='hidden' name='follow' value='".$rows->id."'><input type='submit' name='follow_btn' value='Follow Up' style='background-color:transparent;border:none;' class='text-secondary font-weight-bold text-xs'></form></td>";
            
            echo "<td class='text-center text-secondary text-xs font-weight-bold'>".$rows->case_assign_date."</td>";
            echo "<td class='text-center text-secondary text-xs font-weight-bold'>".$rows->name."</td>";
            echo "<td class='text-center text-secondary text-xs font-weight-bold'>".$rows->phone."</td>";
            echo "<td class='text-center text-secondary text-xs font-weight-bold'>".$rows->email."</td>";
            echo "<td class='text-center text-secondary text-xs font-weight-bold'>".$rows->ask_email."</td>";
            echo "<td class='text-center text-secondary text-xs font-weight-bold'>".$rows->dest_1."</td>";
            echo "<td class='text-center text-secondary text-xs font-weight-bold'>".$rows->consultant_name."</td>";
            echo "<td class='text-center text-secondary text-xs font-weight-bold'>".$rows->comments."</td>";
            echo "<td class='text-center text-secondary text-xs font-weight-bold'>".$rows->status_name."</td>";
            echo "<td class='text-center text-secondary text-xs font-weight-bold'>".$rows->admin."</td>";
            echo "<td class='text-center text-secondary text-xs font-weight-bold'>".$rows->university_1."</td>";
            echo "<td class='text-center text-secondary text-xs font-weight-bold'>".$rows->outcome_destination_1."</td>";
            echo "<td class='text-center text-secondary text-xs font-weight-bold'>".$rows->case_status_1."</td>";
            echo "<td class='text-center text-secondary text-xs font-weight-bold'>".$rows->dest_2."</td>";
            echo "<td class='text-center text-secondary text-xs font-weight-bold'>".$rows->case_handler_2."</td>";
            echo "<td class='text-center text-secondary text-xs font-weight-bold'>".$rows->university_2."</td>";
            echo "<td class='text-center text-secondary text-xs font-weight-bold'>".$rows->outcome_destination_2."</td>";
            echo "<td class='text-center text-secondary text-xs font-weight-bold'>".$rows->case_status_2."</td>";
            echo "<td class='text-center text-secondary text-xs font-weight-bold'>".$rows->course."</td>";
            echo "<td class='text-center text-secondary text-xs font-weight-bold'>".$rows->intake."</td>";
            echo "<td class='text-center text-secondary text-xs font-weight-bold'>".$rows->missing_docs."</td>";
            echo "<td class='text-center text-secondary text-xs font-weight-bold'>".$rows->final_comments."</td>";
            echo "<td class='text-center text-secondary text-xs font-weight-bold'>".$rows->insert_admin."</td>";
            // if($this->checkPrivilage($_SESSION["user_type"],"admin") || $this->checkPrivilage($_SESSION["user_type"],"accounts") || $this->checkPrivilage($_SESSION["user_type"],"case_admin"))
            // {
                echo "<td class='text-center text-secondary text-xs font-weight-bold'><form method='POST' action='delete_inproces.php'><input type='hidden' name='delete' value='".$rows->id."'><input type='submit' name='delete_btn' value='Delete' style='background-color:transparent;border:none;' class='text-secondary font-weight-bold text-xs'></form></td>";
                echo "<td class='text-center text-secondary text-xs font-weight-bold'><form method='POST' action='send_back_to_leads.php'><input type='hidden' name='send_back' value='".$rows->id."'><input type='submit' name='send_back_btn' value='Send Back to Leads' style='background-color:transparent;border:none;' class='text-secondary font-weight-bold text-xs'></form></td>";
            // }
            // if($this->checkPrivilage($_SESSION["user_type"],"admin") || $this->checkPrivilage($_SESSION["user_type"],"counsellor"))
            // {
                // echo "<td class='text-center text-secondary text-xs font-weight-bold'><form method='POST' action='send_back_to_leads.php'><input type='hidden' name='send_back' value='".$rows->id."'><input type='submit' name='send_back_btn' value='Send Back to Leads' style='background-color:transparent;border:none;' class='text-secondary font-weight-bold text-xs'></form></td>";
            // }
            echo "<td class='text-center text-secondary text-xs font-weight-bold'><form method='POST' action='send_to_completed.php'><input type='hidden' name='completed' value='".$rows->id."'><input type='submit' name='completed_btn' value='Send to Completed' style='background-color:transparent;border:none;' class='text-secondary font-weight-bold text-xs'></form></td>";
            echo "</tr>";
        }
        
        
        
        echo "</tbody></table></div></div></div></div></div></div>";
    }
    function show_completed_table()
    {
        echo "<div class='card-body px-0 pt-0 pb-2'>
        <div class='table-responsive p-0'><table class='table align-items-center mb-0'>";
            echo "<thead><tr>";
        echo "<th class='text-center text-uppercase text-xs font-weight-bolder opacity-10'>S.No</th>";
        echo "<th class='text-center text-uppercase text-xs font-weight-bolder opacity-10'>Update</th>";
        
        echo "<th class='text-center text-uppercase text-xs font-weight-bolder opacity-10'>Date</th>";
        echo "<th class='text-center text-uppercase text-xs font-weight-bolder opacity-10'>Name</th>";
        echo "<th class='text-center text-uppercase text-xs font-weight-bolder opacity-10'>Phone</th>";
        echo "<th class='text-center text-uppercase text-xs font-weight-bolder opacity-10'>Country</th>";
        echo "<th class='text-center text-uppercase text-xs font-weight-bolder opacity-10'>Course</th>";
        echo "<th class='text-center text-uppercase text-xs font-weight-bolder opacity-10'>University</th>";
        echo "<th class='text-center text-uppercase text-xs font-weight-bolder opacity-10'>Consultant</th>";
        echo "<th class='text-center text-uppercase text-xs font-weight-bolder opacity-10'>Brand</th>";
        echo "<th class='text-center text-uppercase text-xs font-weight-bolder opacity-10'>Intake</th>";
        echo "<th class='text-center text-uppercase text-xs font-weight-bolder opacity-10'>Notes</th>";
        echo "<th class='text-center text-uppercase text-xs font-weight-bolder opacity-10'>Visa Status</th>";
        echo "<th class='text-center text-uppercase text-xs font-weight-bolder opacity-10'>Comments</th>";
        echo "<th class='text-center text-uppercase text-xs font-weight-bolder opacity-10'>Insertion Admin</th>";
        echo "<th class='text-center text-uppercase text-xs font-weight-bolder opacity-10'>Delete</th>";
        echo "<th class='text-center text-uppercase text-xs font-weight-bolder opacity-10'>Send Back To Inprocess</th>";
        
        echo "</tr></thead>";
    }
    function show_completed_data($user_data)
    {
        foreach($user_data as $rows)
    {
        echo "<tr>";
        echo "<td class='text-center text-secondary text-xs font-weight-bold'>".$rows->id."</td>";
        echo "<td class='text-center text-secondary text-xs font-weight-bold'><form method='POST' action='update_completed.php'><input type='hidden' name='update' value='".$rows->id."'><input type='submit' name='update_btn' value='Update' style='background-color:transparent;border:none;' class='text-secondary font-weight-bold text-xs'></form></td>";
        
        echo "<td class='text-center text-secondary text-xs font-weight-bold'>".$rows->date."</td>";
        echo "<td class='text-center text-secondary text-xs font-weight-bold'>".$rows->full_name."</td>";
        echo "<td class='text-center text-secondary text-xs font-weight-bold'>".$rows->phone."</td>";
        echo "<td class='text-center text-secondary text-xs font-weight-bold'>".$rows->country."</td>";
        echo "<td class='text-center text-secondary text-xs font-weight-bold'>".$rows->course."</td>";
        echo "<td class='text-center text-secondary text-xs font-weight-bold'>".$rows->university."</td>";
        echo "<td class='text-center text-secondary text-xs font-weight-bold'>".$rows->consultant."</td>";
        echo "<td class='text-center text-secondary text-xs font-weight-bold'>".$rows->brand."</td>";
        echo "<td class='text-center text-secondary text-xs font-weight-bold'>".$rows->intake."</td>";
        echo "<td class='text-center text-secondary text-xs font-weight-bold'>".$rows->notes."</td>";
        echo "<td class='text-center text-secondary text-xs font-weight-bold'>".$rows->visa_status."</td>";
        echo "<td class='text-center text-secondary text-xs font-weight-bold'>".$rows->comments."</td>";
        echo "<td class='text-center text-secondary text-xs font-weight-bold'>".$rows->insert_admin."</td>";
        
        echo "<td class='text-center text-secondary text-xs font-weight-bold'><form method='POST' action='delete_completed.php'><input type='hidden' name='delete' value='".$rows->id."'><input type='submit' name='delete_btn' value='Delete' style='background-color:transparent;border:none;' class='text-secondary font-weight-bold text-xs'></form></td>";   
        echo "<td class='text-center text-secondary text-xs font-weight-bold'><form method='POST' action='send_back_to_inprocess.php'><input type='hidden' name='send_back' value='".$rows->id."'><input type='submit' name='send_back_btn' value='Send Back To Inprocess' style='background-color:transparent;border:none;' class='text-secondary font-weight-bold text-xs'></form></td>";   
        echo "</tr>";
    }
    echo "</tbody></table></div></div></div></div></div></div>";
    }
    function create_forms($page)
    {
        ?>
    <div class="container-fluid py-4">
          <div class="row">
            <div class="col-12">
    <form method="POST" action="show_single_user.php" style="margin-top:50px !important;">
    <label>Search: </label><br><input class="form-control form-control-sm" type="text" name="user_id"><br><br>
    <div class="text-center d-flex justify-content-center">
    <input class="btn btn-sm btn-primary btn-lg w-40 mt-4 mb-0" type="submit" value="Search"><br>
    </div>
    </form>
    
    <form method="POST" action="search_result.php">
    <label>Search With Follow Up: </label><br>
    <select name="type" class="form-control form-control-sm">
      <option selected="selected" value="follow">Follow</option>
      <option value="followed">Followed</option>
      <option value="visit">Visit</option>
      <option value="visited">Visited </option>
      <option value="No Follow">No Follow</option>
    </select><br>
    <br>
    <input class="form-control form-control-sm" type="date" name="date"><br><br>
    <div class="text-center d-flex justify-content-center">
    <input class="btn btn-sm btn-primary btn-lg w-40 mt-4 mb-0" type="submit" value="Search With Follow Up"><br>
    </div>
    </form>
    
    <div class="text-center d-flex justify-content-center">
    <?php
    
    $max_id=$this->get_max_id("user_info");
    for($i=1;$i<=ceil($max_id/1000);$i++)
    {
        echo "<form method='POST' style='display:inline;'><input class='btn btn-sm btn-primary btn-lg w-1 mt-4 mb-0 text-center' type='submit' name='pagenumber' value=$i></form>&nbsp;&nbsp;&nbsp;";
    }
    ?>
    <br><br><br>
    </div></div></div></div>
    <div class="container-fluid py-4">
          <div class="row">
              <div class="card mb-12">
                <div class="card-header pb-0">
                  <h6><?php echo $page;   ?></h6>
                </div>
    
    <?php
    }
    function create_forms_inprocess($page)
    {
        ?>
    <div class="container-fluid py-4">
          <div class="row">
            <div class="col-12">
    <form method="POST" action="show_single_inprocess.php" style="margin-top:50px !important;">
    <label>Search: </label><br><input class="form-control form-control-sm" type="text" name="user_id"><br><br>
    <div class="text-center d-flex justify-content-center">
    <input class="btn btn-sm btn-primary btn-lg w-40 mt-4 mb-0" type="submit" value="Search"><br>
    </div>
    </form>
    
    <form method="POST" action="search_result_inprocess.php">
    <label>Search With Follow Up: </label><br>
    <select name="type" class="form-control form-control-sm">
      <option selected="selected" value="follow">Follow</option>
      <option value="followed">Followed</option>
      <option value="visit">Visit</option>
      <option value="visited">Visited </option>
      <option value="No Follow">No Follow</option>
    </select><br>
    <br>
    <input class="form-control form-control-sm" type="date" name="date"><br><br>
    <div class="text-center d-flex justify-content-center">
    <input class="btn btn-sm btn-primary btn-lg w-40 mt-4 mb-0" type="submit" value="Search With Follow Up"><br>
    </div>
    </form>
    
    <div class="text-center d-flex justify-content-center">
    
    <br><br><br>
    </div></div></div></div>
    <div class="container-fluid py-4">
          <div class="row">
              <div class="card mb-4">
                <div class="card-header pb-0">
                  <h6><?php echo $page;   ?></h6>
                </div>
    
    <?php
    }
    function create_extra_data_table()
    {
        echo "<table class='table align-items-center mb-0'>";
        echo "<thead><tr>";
    echo "<th class='text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7'>S.No</th>";
    echo "<th class='text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7'>Value</th>";
    echo "<th class='text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7'>Update</th>";
    echo "<th class='text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7'>Delete</th>";
    echo "</tr>";
    }
    function create_extra_data_table_data($row)
    {
        foreach($row as $rows)
        {
            $vals=array_values($rows);
            echo "<tr>";
            echo "<td class='text-center text-secondary text-xs font-weight-bold'>".$vals[0]."</td>";
            echo "<td class='text-center text-secondary text-xs font-weight-bold'>".$vals[1]."</td>";
            echo "<td class='text-center text-secondary text-xs font-weight-bold'><form method='POST' action='update_extra_data.php'><input type='hidden' name='update' value='".$rows['id']."'><input type='submit' name='update_btn' value='Update' style='background-color:transparent;border:none;' class='text-secondary font-weight-bold text-xs'></form></td>";
            echo "<td class='text-center text-secondary text-xs font-weight-bold'><form method='POST' action='delete_extra_data.php'><input type='hidden' name='delete' value='".$rows['id']."'><input type='submit' name='delete_btn' value='Delete' style='background-color:transparent;border:none;' class='text-secondary font-weight-bold text-xs'></form></td>";
            echo "</tr>";
        }
    }
    function create_forms_completed($page)
    {
        ?>
    <div class="container-fluid py-4">
          <div class="row">
            <div class="col-12">
    <form method="POST" action="show_single_completed.php" style="margin-top:50px !important;">
    <label>Search: </label><br><input class="form-control form-control-sm" type="text" name="user_id"><br><br>
    <div class="text-center d-flex justify-content-center">
    <input class="btn btn-sm btn-primary btn-lg w-40 mt-4 mb-0" type="submit" value="Search"><br>
    </div>
    </form>
    <div class="text-center d-flex justify-content-center">
    <br><br><br>
    </div></div></div></div>
    <div class="container-fluid py-4">
          <div class="row">
              <div class="card mb-4">
                <div class="card-header pb-0">
                  <h6><?php echo $page;   ?></h6>
                </div>
    
    <?php
    }
}

?>