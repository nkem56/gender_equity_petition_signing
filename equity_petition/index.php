


<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <title>Equity Petition Signing Map</title>

  <script src="jquery.min.js"></script>
<script src="moment.js"></script>
	<script src="livestamp.js"></script>


    <style>
        html, body {
            width: 100%;
            height: 100%;
            margin: 0;
        }
    </style>



<style>



.section_padding {
padding: 60px 40px;
}

.imagelogo_li_remove {
list-style-type: none;
margin: 0;
 padding: 0;
}

.imagelogo_data{
 width:120px;
 height:80px;
}



  .navbar {
    letter-spacing: 1px;
    font-size: 14px;
    border-radius: 0;
    margin-bottom: 0;
   background-color:black;

    z-index: 9999;
    border: 0;
    font-family: comic sans ms;
//color:white;
  }



  
.navbar-toggle {
background-color:orange;
  }

.navgate {
padding:16px;color:white;

}

.navgate:hover{
 color: black;
 background-color: orange;

}


.navbar-header{
height:60px;
}

.navbar-header-collapse-color {
background:white;
}

.dropdown_bgcolor{

background: #ec5574;
color:white;
}

.dropdown_dashedline{
 border-bottom: 2px dotted white;
}

.navgate101:hover{
background:purple;
color:white;

}



.res_center_css{
position:absolute;top:50%;left:50%;margin-top: -50px;margin-left -50px;width:100px;height:100px;
}


.cp{
background-color: #800000;
padding: 6px;
color:white;
font-size:14px;
border-radius: 15%;
border: none;
cursor: pointer;
text-align: center;
z-index: -999;
}
.cp:hover {
background: black;
color:white;
}



.cp1{
background-color: navy;
padding: 6px;
color:white;
font-size:14px;
border-radius: 15%;
border: none;
cursor: pointer;
text-align: center;
z-index: -999;
}
.cp1:hover {
background: black;
color:white;
}

/* make modal appear at center of the page */
.modal-appear-center {
margin-top: 10%;
//width:40%;
}


/* make modal appear at center of the page */
.modal-appear-center1 {
margin-top: 15%;
//width:40%;
}
	
</style>


</head>

<body>
<!-- start column nav-->


<div class="text-center">
<nav class="navbar navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navgator">
        <span class="navbar-header-collapse-color icon-bar"></span>
        <span class="navbar-header-collapse-color icon-bar"></span>
        <span class="navbar-header-collapse-color icon-bar"></span> 
        <span class="navbar-header-collapse-color icon-bar"></span>                       
      </button>
     
<li class="navbar-brand home_click imagelogo_li_remove" style='color:white;font-size:20px;'>Gender Equity Petitions Signing</li>
    </div>
    <div class="collapse navbar-collapse" id="navgator">



<button title="Sign Petitions" data-toggle="modal" data-target="#myModal_addteams" class="cp"><i  style="color:white;font-size:10px;"></i>Sign Petitions</button>

<button title="Admin Access Only"  class="cp"><i  style="color:white;font-size:10px;"></i><a href="view_signers.php">View Petition Signers(Admin Only)</a></button>



    </div>
  </div>



</nav>


<?php

include('settings.php');

if($google_map_api_key == ''){
echo "<br><div style='background:red;color:white;padding:10px;'>Google Map API KEY is Empty. You can update it in settings.php file</div>";
exit();
}



?>


    </div><br /><br />

<!-- end column nav-->
<br>
<h3><center > <b style='color:#800000'>Respect, Honour, Pride & Gender Equity is for Everyone.</b></center></h3>
<h4>Women all over the world suffers Gender Inequality Treaments, Discriminations,Gender Inequality access for Good Workplace, Jobs, Politics etc.
 Alots of Women has also been victim of Sexual Assults, Rapes etc.<br>

 Its is time to Embrace
 Equity by partaking in Petition Signing for Gender Equality to ensure that your voices are heard by the Governments and appropriate Authorities and to help put Gender Equality 
Fight Going forwards.<br>

Sign Petition to also receive (Email & SMS) updates on Gender Equity campaign and other Gender Inequalities related issues around the Globe.</h4>

<?php
include('db_connect.php');
$res = $db->prepare('SELECT SUM(total_count) AS value_sum FROM petition_sign_count');
$res->execute(array());
$count = $res->rowCount();
$row = $res->fetch();
$sum = $row['value_sum'];
echo "<div style='background:green;color:white;padding:10px;'><center>Total Gender Equity Petition Signed so far Globally is: <b style='font-size:20px'>($sum Petitions)</b></center></div><br>";



?>




    <div id="map-canvas" style="width: 100%;height: 100%;"></div>

    <script src="jquery.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $google_map_api_key; ?>"></script>


  <link rel="stylesheet" href="bootstrap.min.css">
    <script src="jquery.min.js"></script>
    <script src="bootstrap.min.js"></script>




    <script>



        $( document ).ready(function() {

            let countries = [];

            let mapOptions = {
                zoom: 3,
                minZoom: 1,
                center: new google.maps.LatLng(50.7244893,3.2668189),
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                backgroundColor: 'none'
            };

            let map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

            init();

            function init() {
                $.ajax({
                    url : 'data.json',
                    cache : true,
                    dataType : 'json',
                    async : true,

                    success : function(data) {

                        if (data) {

                            $.each(data, function(id,country) {

                                var countryCoords;
                                var ca;
                                var co;

                                if ('multi' in country) {

                                    var ccArray = [];

                                    for (var t in country['xml']['Polygon']) {

                                        countryCoords = [];

                                        co = country['xml']['Polygon'][t]['outerBoundaryIs']['LinearRing']['coordinates'].split(' ');

                                        for (var i in co) {

                                            ca = co[i].split(',');

                                            countryCoords.push(new google.maps.LatLng(ca[1], ca[0]));
                                        }

                                        ccArray.push(countryCoords);
                                    }

                                    createCountry(ccArray,country);

                                } else {

                                    countryCoords = [];

                                    co = country['xml']['outerBoundaryIs']['LinearRing']['coordinates'].split(' ');

                                    for (var j in co) {

                                        ca = co[j].split(',');

                                        countryCoords.push(new google.maps.LatLng(ca[1], ca[0]));
                                    }

                                    createCountry(countryCoords,country);
                                }
                            }.bind(this));

                            showCountries();
                        }
                    }.bind(this)
                });
            }

            function showCountries() {
                for (var i=0; i<countries.length; i++) {
                    countries[i].setMap(map);

                    google.maps.event.addListener(countries[i],"mouseover",function(){
                        this.setOptions({fillColor: "#f5c879", 'fillOpacity': 0.5});
                    });

                    google.maps.event.addListener(countries[i],"mouseout",function(){
                        this.setOptions({fillColor: "#f5c879", 'fillOpacity': 0});
                    });

                    google.maps.event.addListener(countries[i], 'click', function(event) {
                       // alert(this.title+' ('+this.code+')');
$('#myModal_participants').modal('show');

 var map_data = "<div style='background:#c1c1c1; border-bottom: 2px dashed purple;'>" +
"<div style='background:#824c4e;color:white;padding:10px;'>Gender Equity Petition Signed Details</div><br />" +

"<span><b>Country Name:</b> " + this.title + "</span><br />" +
"<span><b>Country code:</b> " + this.code + "</span><br />" +

                    "</div>";

$('#content').html(map_data);


// start ajaxcall


           // $(function () {
               
                   
               
var countryx = this.title;
var country_code = this.code;


// start if validate
if(country_code==""){
alert('Selected Country Code cannot be Empty. Please Refresh the Page');
}
else if(countryx==""){
alert('Selected Country Name cannot be Empty. Please Refresh the Page');
}

else{

          var form_data = new FormData();
		  form_data.append('countryx', countryx);
                   form_data.append('country_code', country_code);
          
                    $('#loaderxv').fadeIn(400).html('<br><span class="well" style="color:black"><img src="ajax-loader.gif">&nbsp;Pls Wait. Selected Users Country Details is being Loaded...</span>');
                    $.ajax({
                        url: 'posts_load.php',
                        data: form_data,
                        processData: false,
                        contentType: false,
                        ache: false,
                        type: 'POST',
                       
                        success: function (msg) {
				$('#loaderxv').hide();
				$('#resultxv').html(msg);
				
                        }
                    });
}
               // });
          





// ends ajaxcall

                    });
                }
            }

            function createCountry(coords, country) {
                var currentCountry = new google.maps.Polygon({
                    paths: coords,
                    //strokeColor: 'white',
                    title: country.country,
                    code: country.iso,
                    strokeOpacity: 0,
                    //strokeWeight: 1,
                    //fillColor: country['color'], // can be used as default color
                    fillOpacity: 0
                });

                countries.push(currentCountry);
            }

        });




    </script>








<div class="container_page">

  <div class="modal fade " id="myModal_addteams" role="dialog">
    <div class="modal-dialog modal-lg modal-appear-center1 pull-right1 modaling_sizing1">
      <div class="modal-content">
        <div class="modal-header" style="color:black;background:#c1c1c1">
 <button type="button" class="pull-right btn btn-default" data-dismiss="modal">Close</button>
      <h4 class="modal-title">Sign Petitions</h4>
        </div>
        <div class="modal-body">







<div class='col-sm-12' style='background:#ddd;color:black;padding:10px;border-style: dashed; border-width:2px; border-color: orange;'>


        <script>
		

            $(function () {
                $('#save').click(function () {
                   var name = $('#name').val();
var email = $('#email').val();
var phone_no = $('#phone_no').val();
var desc = $('#desc').val();				
var address = $('#address').val();
var country = $('#country').val();



// start if validate

 if(name==""){
alert('Your Name cannot be Empty');
}

else if(email==""){
alert('Your Email cannot be Empty');
}

else if(phone_no==""){
alert('Phone No cannot be Empty');
}

else if(desc==""){
alert('Description cannot be Empty');
}

else if(address==""){
alert('address cannot be Empty');
}

else if(country==""){
alert('Country Name cannot be Empty');
}

else{

          var form_data = new FormData();
		  form_data.append('desc', desc);

form_data.append('name',  name);
form_data.append('email', email);
form_data.append('address',  address);
form_data.append('country',  country);
form_data.append('phone_no',  phone_no);

          
                    $('#loader').fadeIn(400).html('<br><span class="well" style="color:black"><img src="ajax-loader.gif">&nbsp;Pls Wait. Data is being Submitted...</span>');
                    $.ajax({
                        url: 'posts.php',
                        data: form_data,
                        processData: false,
                        contentType: false,
                        ache: false,
                        type: 'POST',
                       
                        success: function (msg) {
				$('#loader').hide();
				$('#result').html(msg);
				
                        }
                    });
}
                });
            });

			
			
			</script>




<div class="col-sm-12 form-group">
<label>Fullname. </label><br>
<input type="text" class="form-control " id="name" name="name" placeholder="Enter Your Name" value="Ann Ball" required>
</div


<div class="col-sm-12 form-group">
<label>Email. </label><br>
<input  class="form-control " id="email" name="email" placeholder="Enter Email" type="text" value="annball@gmail.com" required>
</div>

<div class="col-sm-12 form-group">
<label>Phone No. Eg +1234567890</label><br>
<input  class="form-control " id="phone_no" name="phone_no" placeholder="Enter Phone No Eg" value="+1234567890" type="text" required>
</div>

<div class="col-sm-12 form-group">
<label>Write who you are & Descriptions of what you want </label><br>
<textarea  cols="5" rows="3" class="form-control " id="desc" name="desc" placeholder="Enter Details" type="text" required>My name is Ann Ball.Am Signing Petition to help promote Gender Equity Campaign Going Forward.</textarea>
</div>




<div class="col-sm-12 form-group">
<h3> Your Locations Address</h3><br>



<span class="col-sm-6"><b>Address</b>
<input type="text" class="address form-control" name="address" id="address" placeholder="Address Eg: (Alexander City)" value="Alexander City" />
</span>


<span class="col-sm-6"><b>Country Eg.(USA)</b>

<?php
include("db_connect.php");
?>

<select  class="country form-control" name="country" id="country">
    <option value="">Select Country</option>
    <?php 
$res = $db->prepare('SELECT * FROM gmaps_countries');
$res->execute(array());
$count = $res->rowCount();

    if($count > 0){
while ($row = $res->fetch()) {
        $country =$row['country'];
        $id =$row['id_gmaps'];
$country_code =$row['iso'];
    ?>
    <option value="<?php echo $country_code; ?>_<?php echo $country; ?>" ><?php echo $country; ?> </option>
   <?php
    }}
    ?>
</select>


</span>



</div>




                    <div class="form-group">
                            

                        <div id="loader"></div>
                        <div id="result"></div>
                    </div>
<br><br>
                    <input type="button" id="save" class="cp" value="Submit Now" />
    </form>

</div>



<!--end form-->

<br>






</div><br><br>

<br><br>

<!--form ENDS-->


        </div>
        <div class="modal-footer" style="color:black;background:#c1c1c1">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>
























<div class="container_page">

  <div class="modal fade " id="myModal_participants" role="dialog">
    <div class="modal-dialog modal-lg modal-appear-center1 pull-right1 modaling_sizing1">
      <div class="modal-content">
        <div class="modal-header" style="color:black;background:#c1c1c1">
 <button type="button" class="pull-right btn btn-default" data-dismiss="modal">Close</button>
      <h4 class="modal-title">Gender Equity Petition Signed Details</h4>
        </div>
        <div class="modal-body">






<div id="content"></div>


<div class='col-sm-12' style='background:#ddd;color:black;padding:10px;border-style: dashed; border-width:2px; border-color: orange;'>


        <script>
		

            $(function () {
               
                   
               
var countryx = $('#countryx').val();
var country_code = $('#country_code').val();


// start if validate
if(country_code==""){
alert('Selected Country Code cannot be Empty. Please Refresh the Page');
}
else if(countryx==""){
alert('Selected Country Name cannot be Empty. Please Refresh the Page');
}

else{

          var form_data = new FormData();
		  form_data.append('countryx', countryx);
                   form_data.append('country_code', country_code);
          
                    $('#loaderxv').fadeIn(400).html('<br><span class="well" style="color:black"><img src="ajax-loader.gif">&nbsp;Pls Wait. Selected Country Details is being Loaded...</span>');
                    $.ajax({
                        url: 'posts_load.php',
                        data: form_data,
                        processData: false,
                        contentType: false,
                        ache: false,
                        type: 'POST',
                       
                        success: function (msg) {
				$('#loaderxv').hide();
				$('#resultxv').html(msg);
				
                        }
                    });
}
                });
          

			
			
			</script>



                        <div id="loaderxv"></div>
                        <div id="resultxv"></div>


<br>






</div><br><br>

<br><br>

<!--form ENDS-->


        </div>
        <div class="modal-footer" style="color:black;background:#c1c1c1">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>











<script>

// clear Modal div content on modal closef closed
$(document).ready(function(){
$('#myModal_searchy').on('hidden.bs.modal', function() {
//alert('Modal Closed');
   $('.myform_clean_searchy').empty();  
 console.log("modal closed and content cleared");
 });
});

</script>

</body>
</html>