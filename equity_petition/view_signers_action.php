<?php 
error_reporting(0);
include('settings.php');
include('db_connect.php');

// get total count
$pstmt = $db->prepare('SELECT * FROM posts');
$pstmt->execute();
$total_count = $pstmt->rowCount();

// ensure that they cotain only alpha numericals
if(strip_tags(isset($_POST["get_content"]))){
$get_content = strip_tags($_POST["get_content"]);
if($get_content == 'get_data'){

$sql_query = '';
$error = '';
$message='';
$response_bl = array();

$sql_query .= "SELECT * FROM posts ";
if(strip_tags(isset($_POST["search"]["value"]))){

$search_value= strip_tags($_POST["search"]["value"]);
$sql_query .= 'WHERE fullname LIKE "%'.$search_value.'%" ';
$sql_query .= 'OR email LIKE "%'.$search_value.'%" ';
$sql_query .= 'OR phone_no LIKE "%'.$search_value.'%" ';
$sql_query .= 'OR address LIKE "%'. $search_value.'%" ';
$sql_query .= 'OR timing LIKE "%'. $search_value.'%" ';
$sql_query .= 'OR country LIKE "%'. $search_value.'%" ';
$sql_query .= 'OR data LIKE "%'. $search_value.'%" ';
  }



//ensure that order post is set
$start = $_POST['start'];
$length = $_POST['length'];
$draw= $_POST["draw"];
if(strip_tags(isset($_POST["order"]))){
$order_column = strip_tags($_POST['order']['0']['column']);
$order_dir = strip_tags($_POST['order']['0']['dir']);

$sql_query .= 'ORDER BY '.$order_column.' '.$order_dir.' ';
}
else{
$sql_query .= 'ORDER BY id DESC ';
}
if($length != -1){
$sql_query .= 'LIMIT ' . $start . ', ' . $length;
}

$pstmt = $db->prepare($sql_query);
$pstmt->execute();
$rows_count = $pstmt->rowCount();


while($row = $pstmt->fetch()){
$rows1 = array();
$id = $row['id'];
$fullname = $row['fullname'];
$phone_number = $row['phone_no'];
$email_address = $row['email'];
$post_id = $row['id'];
$desc = $row['description'];
$address = $row['address'];
$iso = $row['data'];
$timing = $row["timing"];
$email_count = $row["email_count"];
$sms_count = $row["sms_count"];
$country = $row['country'];


              

$rows1[] = $fullname;
$rows1[] = $email_address;
$rows1[] = $phone_number;
$rows1[] = $address;
$rows1[] = $country;
$rows1[] = $desc;
$rows1[] = '<span data-livestamp="'.$timing.'"></span>';

$rows1[] = '
<button type="button"  class="btn btn-info btn-xs btn_call" data-toggle="modal" data-target="#myModal_sms"
data-id="'. intval($row["id"]).'"
data-fullname="'. strip_tags($fullname).'"
data-post_id="'. strip_tags($post_id).'"
data-phone_no="'. strip_tags($row["phone_no"]).'"
data-email="'. strip_tags($row["email"]).'"
>Send SMS <span class="badge bg-danger sms_count"> '.$sms_count.'</span></button>


<button type="button"  class="btn btn-primary btn-xs btn_call" data-toggle="modal" data-target="#myModal_email_no"
data-id="'. intval($row["id"]).'"
data-fullname="'. strip_tags($fullname).'"
data-post_id="'. strip_tags($post_id).'"
data-phone_no="'. strip_tags($row["phone_no"]).'"
data-email="'. strip_tags($row["email"]).'"
><a style="color:white;" href="mailto:'.$email_address.'">Send Email </a></button>
';



$response_bl[] = $rows1;
}

$data = array(
"draw"    => $draw,
"recordsTotal"  => $rows_count,
"recordsFiltered" => $total_count,
"data"    => $response_bl);
}// you can close this

if($_POST["get_content"] == 'get_one_content')
 {
  $id =  $_POST["id"];
  $sql_query = "SELECT * FROM posts WHERE id = '$id'";
  $pstmt = $db->prepare($sql_query);
  $pstmt->execute();
  while($row = $pstmt->fetch()){
   $data['given_name'] = $row['given_name'];
   $data['family_name'] = $row['family_name'];

  }
 }

 //}
 
 



// delete content
if(strip_tags($_POST["get_content"]) == 'Delete'){
$error='';
$error1='';
$message='';
$pstmt_del='';	
$id = intval($_POST["id"]);
  
$pstmt_del = $db->prepare('DELETE from posts where id=:id');
$pstmt_del->execute(array(':id' =>$id));
$message = 'Deleted';
if($pstmt_del){
    $data = array(
    'error'   => $error,
    'message'  =>$message);
	}else{
	$data = array(
	'error'   => $error,
    'message'   => 'deleted-error'
    );
	}	
 }
 // end delete contents

 echo json_encode($data);
}



?>