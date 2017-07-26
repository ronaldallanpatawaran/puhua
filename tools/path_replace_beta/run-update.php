<?php 
function debug($var){echo "<pre>";print_r($var);echo "</pre>";}
include_once('../../config.php');
$con = new mysqli(DB_HOSTNAME,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
$counter = 0;
$serial_f = "/@/i";
if(isset($_POST['marked']) && isset($_POST['new_path']) && isset($_POST['old_path'])){
	$old_url	= $con->real_escape_string($_POST['old_path']);
	$new_url	= $con->real_escape_string($_POST['new_path']);
	if(is_array($_POST['marked'])){
		foreach($_POST['marked'] as $partial_q){
			if(preg_match($serial_f,$partial_q)){ // Match serialization format (set)
				$part = explode("@",$partial_q);
				if(count($part) > 1){ // make sure correct output before query.
					$sql = "SELECT `".$part[1]."` FROM `".$part[0]."` WHERE `".$part[1]."` LIKE '%".$old_url."%'"; // short cut
					$result = $con->query($sql);
					while($row = $result->fetch_array(MYSQLI_NUM)){ // While have row
						$line_holder = array_pop($row);
						$each = @unserialize($line_holder); // This is the value
						if($each){
							$each = kcr_process_meta_values($each, $old_url, $new_url);
							if($each){
								$each = serialize($each);
							}
						}
						$sql = "UPDATE `".$part[0]."` SET `".$part[1]."` = '".$con->real_escape_string($each)."' WHERE `".$part[1]."` = '".$con->real_escape_string($line_holder)."'"; // Build Query
						$con->query($sql);
						if ($con->affected_rows > 0) {
							//echo $sql . '------ '.$con->affected_rows.'<br/>';
							$counter += $con->affected_rows;
						}
					} // End While
				}
			}else{
				$sql = $partial_q."'".$_POST['old_path']."','".$new_url."')"; // Craft query
				$con->query($sql);
				if ($con->affected_rows > 0) {
					//echo $sql . '------ '.$con->affected_rows.'<br/>';
					$counter += $con->affected_rows;
				}

			} // End if check serialized
		} // End if for number of values.
	} // End if for check value is in array form
} // End if all value exist
echo $counter;

function kcr_process_meta_values($meta_values, $old_url, $new_url){
	$dataType = gettype($meta_values);
	if(!is_array($meta_values)){
		$result = str_replace($old_url, $new_url, $meta_values);
		settype($result,$dataType);
		return $result;
	}

	foreach($meta_values as $meta_key => &$meta_value){	
		$meta_value = kcr_process_meta_values($meta_value, $old_url, $new_url);		
	}

	settype($meta_values,$dataType);
	return $meta_values;
}

?>