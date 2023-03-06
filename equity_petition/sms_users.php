<?php
error_reporting(0);
include('settings.php');
include('db_connect.php');


$sms_message = strip_tags($_POST['sms_message']);
$email = strip_tags($_POST['email']);
$fullname = strip_tags($_POST['fullname']);

$postid = strip_tags($_POST['postid']);
$phone_no = strip_tags($_POST['phone_no']);
$timer1 = time();
$sms_title = "SMS from $sender_name";


$sms_sender_name=$sender_name;
$recipient_phoneno=$phone_no;
$sms_msg ="Message from $sms_sender_name, $sms_message. Sender: $sender_email";


 $sms_mobile=strip_tags($_POST['phone_no']);
$sms_message=strip_tags($_POST['message']);
$recipient_name=strip_tags($_POST['recipient_name']);
$sender_name=strip_tags($_POST['sender_name']);


$messaging = "Hi $recipient_name, $sender_name sent you Message. $sms_message";



$uss=$sms_username;
$pss=$sms_password;
$sss=$sms_sender;
//$messaging = $sms_message;
$recipient_no = $sms_mobile;
$verbose = true;
$data = array(
        'username' => $uss,
        'password' => $pss,
        'message'  => $messaging,
        'sender'  => $sss,
        'verbose' => $verbose,
        'mobiles'  => $recipient_no  		
);


  // Send the POST request with cURL
$ch = curl_init('https://portal.nigeriabulksms.com/api/');
curl_setopt($ch, CURLOPT_POST, true);


$header[ ] = "Accept: text/xml,application/xml,application/xhtml+xml,";
$header[ ] = "text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
$header[ ] = "Cache-Control: max-age=0";
    $header[ ] = "Connection: keep-alive";
    $header[ ] = "Keep-Alive: 300";
    $header[ ] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
    $header[ ] = "Accept-Language: en-us,en;q=0.5";
    $header[ ] = "Pragma: "; // browsers keep this blank.



// also tried $header[] = "Accept: text/html";
curl_setopt ($ch,    CURLOPT_HTTPHEADER, $header);
//curl_setopt(curl, CURLOPT_USERAGENT, "Mozilla/4.0");


curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
$result = curl_exec($ch); //This is the result from Textlocal
curl_close($ch);

$response = json_decode($result,true);
$stat=  $response['status'];

//print_r($response);

/*
Success Response: {“status”:”OK”,”count”:1,”price”:2}
*/



if($stat == 'OK') {


$res= $db->prepare("SELECT * FROM posts where id=:id");
$res->execute(array(':id' =>$postid));
$t_row = $res->fetch();
$fcount = $t_row['sms_count'];

$totalcount = $fcount + 1;


$up= $db->prepare("UPDATE posts set sms_count=:sms_count where id=:id");
$up->execute(array(':sms_count' =>$totalcount, ':id' =>$postid));


$statement = $db->prepare('INSERT INTO messages
(fullname,msg,timing,status,postid,title)
                          values
(:fullname,:msg,:timing,:status,:postid,:title)');
$statement->execute(array( 
':fullname' => $admin_name,
':msg' => $sms_msg,
':timing' => $timer1,
':status' => 'sms',
':postid' => $postid,
':title' => $sms_title
));



//echo 1;

echo "<div style='color:white;background:green;padding:10px;'>SMS Sent Successfully. SMS status: $stat</div>";
}
 else{
//echo 0;
echo "<div style='color:white;background:red;padding:10px;'>SMS Sending Failed. Ensure there is Internet Connection</div>";
}



?>


