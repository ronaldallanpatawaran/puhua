<?php
function debug($var){echo "<pre>";print_r($var);echo "</pre>";}
if(!function_exists("array_column")){
    function array_column($array,$column_name){
        return array_map(function($element) use($column_name){return $element[$column_name];}, $array);
    }
}
if(!function_exists("mysqli_fetch_all")){
    function mysqli_fetch_all($query){
        while ($row = $query->fetch_array(MYSQLI_NUM)) {
            $data[] = $row;
        }
        return $data;
    }
}



include_once('../../config.php');
$con = new mysqli(DB_HOSTNAME,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
$show_table = false;
$table_columns = array();


if ($con->connect_error) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}else{
    $show_table = array_column(mysqli_fetch_all($con->query('SHOW TABLES')),0);
    if($show_table){
        foreach($show_table as $table){
            if($con->query('SHOW COLUMNS FROM '.$table)){
                $table_columns[] = array(
                    'table_name'    =>  $table,
                    'column_name'   =>  array_column(mysqli_fetch_all($con->query('SHOW COLUMNS FROM '.$table)),0)
                    );
            }
        }
    }
}
// Find Table with column that have those values
$json = array();
if(isset($_POST['old_path'])) {
    if($table_columns){
        foreach($table_columns as $mod){
            $table_name = $mod['table_name'];
            // Check if setting
            $setting_table = strpos($table_name,'setting');

        if(is_array($mod['column_name'])){
             foreach($mod['column_name'] as $column){
                if($setting_table === false){
                    $sql = "SELECT ".$column." FROM ".$table_name." WHERE ".$column." LIKE '%".$_POST['old_path']."%'";    
                }else{
                    $sql = "SELECT ".$column." FROM ".$table_name." WHERE ".$column." LIKE '%".$_POST['old_path']."%' AND NOT `key` = 'config_ftp_hostname'";
                }
                

                $result = $con->query($sql);

                if($result !== FALSE){
                    while($row = $result->fetch_row()){ // Loop Problem
                        if($row && isset($row[0]) && $row[0]){                            
                            $serial_flag = 0;
                            if(@unserialize(array_pop($row))){$serial_flag = 1;}
                            $json[] = array('table'  => $table_name, 'column'  => $column, 'serialize' => $serial_flag);
                            break;
                        } 
                    }
                }

            }
        }else{
            $column = $mod['column_name'];
            if($setting_table === false){
                $sql = "SELECT ".$column." FROM ".$table_name." WHERE ".$column." LIKE '%".$_POST['old_path']."%'";
            }else{
                $sql = "SELECT ".$column." FROM ".$table_name." WHERE ".$column." LIKE '%".$_POST['old_path']."%' AND NOT `key` = 'config_ftp_hostname' ";
            }
            
            $result = $con->query($sql);
            while($row = $result->fetch_row()){
                if($row && isset($row[0]) && $row[0]){
                    $serial_flag = 0;
                    if(@unserialize(array_pop($row))){$serial_flag = 1;}
                    $json[] = array('table'  => $table_name, 'column'  => $column, 'serialize' => $serial_flag);
                } 
            }


        }
    }
}
}
//if($json){debug($json);} // Test if empty and serialization flag
//json will hold the table with it's column that have the value old-path

if($json){echo json_encode($json);}

?>
