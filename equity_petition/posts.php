<?php
error_reporting(0);


$name= trim($_POST['name']);
$email= trim($_POST['email']);
$phone_no = strip_tags($_POST['phone_no']);
$desc = strip_tags($_POST['desc']);
$address = strip_tags($_POST['address']);
$country_all = strip_tags($_POST['country']);

 
$str = $country_all;
$parts = explode('_', $str);
//$result = $parts[1];

$country_iso =  $parts[0];
$country = $parts[1]; 
		 
	 
		 
 $timer= time();		 


include('db_connect.php');


$pst = $db->prepare('select * from petition_sign_count where country_iso=:country_iso');
$pst->execute(array(':country_iso' =>$country_iso));
$r = $pst->fetch();
//$rc = $pst->rowCount();


$counter_points=$r['total_count'];
$new_count = 1;
$final_count = $counter_points + $new_count;


$update= $db->prepare('UPDATE petition_sign_count set total_count =:total_count where country_iso=:country_iso');
$update->execute(array(':total_count' => $final_count, ':country_iso' =>$country_iso));



$statement = $db->prepare('INSERT INTO posts(
fullname,
email,
phone_no, 
description,
data,
timing,
address, 
country,
email_count,
sms_count
)
  values
(
:fullname,
:email,
:phone_no, 
:description,
:data,
:timing,
:address, 
:country,
:email_count,
:sms_count
)');

$statement->execute(array( 
':fullname' => $name,
':email' => $email,
':phone_no' => $phone_no, 
':description' => $desc,
':data' => $country_iso,
':timing' => $timer, 
':address' => $address,
':country' => $country,
':email_count' => '0',
':sms_count' => '0'
));

if($statement){
//echo "<div style='background:green;color:white;padding:10px;border:none'> Posts successfully Submitted....</div>";
echo "<script>alert(' Posts successfully Submitted....');</script>";
//echo "<script>location.reload();</script>";


}
else{
	
	echo "<div style='background:red;color:white;padding:10px;border:none'>
Data Could not be submitted</div>";
	
}



?>