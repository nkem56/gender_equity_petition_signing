<?php

error_reporting(0);

$country_code = strip_tags($_POST['country_code']);
$country = strip_tags($_POST['countryx']);


include('db_connect.php');
$res = $db->prepare('SELECT * FROM posts where data =:data');
$res->execute(array(':data' => $country_code));
$count = $res->rowCount();

echo "<div style='background:green;color:white;padding:10px;'>Total Signed Petitions for <b>$country</b> is <b style='font-size:20px'>($count)</b></div><br>";

if( $count == 0 ) {
//echo "<script>alert('No Persons from $country has signed Petition Yet. You can be the First Person to Sign..')</script>";
echo "<div style='background:red;color:white;padding:10px;'>No Persons from <b>$country</b> has signed Petition Yet. You can be the First Person to Sign..</div>";
exit();
}



while ($row = $res->fetch()) {

$name = htmlentities(htmlentities($row["fullname"], ENT_QUOTES, "UTF-8"));
$email = htmlentities(htmlentities($row["email"], ENT_QUOTES, "UTF-8"));
$link = htmlentities(htmlentities($row["link"], ENT_QUOTES, "UTF-8"));
$desc = htmlentities(htmlentities($row["description"], ENT_QUOTES, "UTF-8"));
$address = htmlentities(htmlentities($row["address"], ENT_QUOTES, "UTF-8"));
$city = htmlentities(htmlentities($row["city"], ENT_QUOTES, "UTF-8"));
$state = htmlentities(htmlentities($row["state"], ENT_QUOTES, "UTF-8"));
$country = htmlentities(htmlentities($row["country"], ENT_QUOTES, "UTF-8"));
$timing = htmlentities(htmlentities($row["timing"], ENT_QUOTES, "UTF-8"));
?>

<div class='well' style=''>

<b>Signer Name:</b>  <?php echo $name; ?><br>
<b>Address/Location:</b>  <?php echo $address; ?><br>
<b>Description/Message:</b>  <?php echo $desc; ?><br> 
<span style='color:purple;font-size:12px;'>Petitions Signed:  <span data-livestamp="<?php echo $timing; ?>"></span></span>
</div>


<?php
}


?>