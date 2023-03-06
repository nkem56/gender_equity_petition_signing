<?php
error_reporting(0);
include('settings.php');
$timerx = time();

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <script src="jquery.min.js"></script>
<script src="moment.js"></script>
	<script src="livestamp.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">



  <link rel="stylesheet" href="bootstrap.min.css" />
  <script src="jquery.dataTables.min.js"></script>
  <script src="dataTables.bootstrap.min.js"></script>  
  <link rel="stylesheet" href="dataTables.bootstrap.min.css" />
  <script src="bootstrap.min.js"></script>


    <title>Welcome Admin</title>

<style>

.imagelogo_li_remove {
list-style-type: none;
margin: 0;
 padding: 0;
}

.imagelogo_data{
 width:120px;
 height:80px;
}

 .bottomcorner_css{
  //position:fixed;
position:absolute;
  bottom:0;
  right:0;
  }


 .topcorner_css{
  //position:fixed;
position:absolute;
  top:10;
  right:0;
  }


</style>





</head>

<body>
    <div>
        
 <nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Gender Equity Petition</a>
    </div>
    <ul class="nav navbar-nav">

      <li><a style='cursor:pointer;' class="nav-link" href="index.php">Back to Dashboard</a></li>
<li class="nav-item">

                        </li>
    </ul>
  </div>
</nav> 




<br><br><br>


<h3>Welcome  <b>Admin</b></h3>




<h4>Search Petition Signers by <span style='color:fuchsia'> Name, Email, Phone Number, Address, Country</span> etc...</h4><br>


<div class="container">
<div class="row">
<div class="col-sm-12 table-responsive">
<div class="alert_server_response"></div>
<div class="loader_x"></div>
<table id="backup_content" class="table table-bordered table-striped">
<thead><tr>



<th>Signer Name</th>
<th>Email</th>
<th>Phone No</th>
<th>Address</th>
<th>Country</th>
<th>Details</th>
<th>Time</th>
<th>Action</th>
</tr></thead>
</table>
</div>
</div>
</div>






<span class="alert_server_response"></span>
<span class="loader_x"></span>



<script>
$(document).ready(function(){

var get_content = 'get_data';
var backup_type = 'g';
if(get_content=="" && backup_type==""){
alert('There is an Issue with Cotent Database Retrieval');
}
else{
$('.loader_x').fadeIn(400).html('<br><div style="background:#eee; width:100%;height:30%;text-align:center"><img src="ajax-loader.gif">&nbsp;Please Wait, Your Data is being Loaded</div>');
		
 var backupLord144 = $('#backup_content').DataTable({
  "processing":true,
  "serverSide":true,
  "order":[],
  "ajax":{
   url:"view_signers_action.php",
   type:"POST",
   data:{get_content:get_content, backup_type:backup_type}
  },
  "columnDefs":[
   {
    "orderable":false,
   },
  ],
  "pageLength": 10
 });

if(backupLord144 !=''){
$('.loader_x').hide();
}

}

 




// Delete content
$(document).on('click', '.delete', function(){
var id = $(this).attr("id");
var get_content = "Delete";

alert();


var datasend = "id="+ id + "&get_content=" + get_content;
if(confirm("Are you sure you want to delete this Content?")){

$('.loader_x').fadeIn(400).html('<br><div style="background:#eee; width:100%;height:30%;text-align:center"><img src="ajax-loader.gif">&nbsp;Please Wait, Your Data is being Deleted...</div>');

$.ajax({
url:"cancel.php",
method:"POST",
data:datasend,
dataType:"json",
success:function(msg){
$('.loader_x').hide();



$('#contentModal').modal('hide');
backupLord144.ajax.reload();
    }
   });
  }
  else
  {
   return false;
  }
 });
 
});


</script>


<script>
$(document).ready(function(){
//$('.btn_call').click(function(){
$(document).on( 'click', '.btn_call', function(){ 



var id = $(this).data('id');
var email = $(this).data('email');
var fullname = $(this).data('fullname');
var phone_no  = $(this).data('phone_no');
var booking_id = $(this).data('post_id');
var booking_version = $(this).data('post_id');


$('.p_id').html(id);
$('.p_email').html(email);
$('.p_fullname').html(fullname);
$('.p_identity_value').val(id).value;
$('.p_email_value').val(email).value;
$('.p_fullname_value').val(fullname).value;
$('.p_phone_no_value').val(phone_no).value;
$('.p_phone_no').html(phone_no);

$('.p_booking_id_value').val(booking_id).value;
$('.p_booking_version_value').val(booking_version).value;

});

});





// clear Modal div content on modal closef closed
$(document).ready(function(){

$("#myModal_carto").on("hidden.bs.modal", function(){
    //$(".modal-body").html("");
 $('.mydata_empty').empty(); 
$('#qty').val(''); 
});



});


</script>














 <!-- email Modal -->
  <div class="modal fade" id="myModal_email" role="dialog">
    <div class="modal-dialog ">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Contact User Via Email</h4>
        </div>
        <div class="modal-body">



<script>



$(document).ready(function(){
$('#email_users_btn').click(function(){

var email_title = $('#email_title').val();		
var email_message = $('#email_message').val();
var email = $('.p_email_valuex').val();
var fullname = $('.p_fullname_valuex').val();
var postid = $('.p_identity_value').val();

//alert(userid);
/*
if(isNaN(discount)){
return false;
}
*/
if(email_message==""){
alert('Email Message cannot be Empty.');
$('.email_message_alert').html("<div class='alert alert-warning' style='color:red;'>Email Message Cannot be Empty.</div>");


}


else{


$('#loader_recxx').fadeIn(400).html('<br><div style="color:black;background:#ddd;padding:10px;"><img src="loader.gif" style="font-size:20px"> &nbsp;Please Wait, Email is being sent in Progress.</div>');
var datasend = {email_title:email_title, email_message:email_message,email:email,fullname:fullname,postid:postid};


$.ajax({
			
			type:'POST',
			url:'email_users.php',
			data:datasend,
                        crossDomain: true,
			cache:false,
			success:function(msg){


                        $('#loader_recxx').hide();
				//$('#result_recxx').fadeIn('slow').prepend(msg);
$('#result_recxx').html(msg);
$('#alertdata_recxx').delay(7000).fadeOut('slow');
$('#alertdata_recxx').delay(7000).fadeOut('slow');

email_function();

$('#email_title').val('');
$('#email_message').val('');
			
			}
			
		});
		
		}
		
	})
					
});




</script>






<input type="hidden" class="p_email_value p_email_valuex"  value="">
<input type="hidden" class="p_fullname_value p_fullname_valuex"  value="">


<div class='row'>
<div class='col-sm-12' style='background:#ddd;'>

<h4>Users Info</h4>


<b>Name: </b><span class='p_fullname'></span><br>
<b>Email: </b><span class='p_email'></span><br>


               </div>


</div>


<br>

<h5> Send Email to User</h5><br>



 <div class="form-group">
           <b>Email Title</b>
              <input type='text' class="col-sm-12 form-control email_title" id="email_title" name="email_title" value="">

            </div>



 <div class="form-group">
           <b>Message</b>
              <textarea class="col-sm-12 form-control" id="email_message" name="email_message" ></textarea>

            </div>

<div class='email_message_alert mydata_empty'></div>





<div class="form-group">
<div id="loader_recxx" ></div>

<div id="result_recxx" class='mydata_empty'></div>
<br />

<button type="button" id="email_users_btn" class="btn btn-primary" title='Email User'>Email User</button>
</div>







<script>




$(document).ready(function(){
//$('.btn_call').click(function(){
$(document).on( 'click', '.btn_call', function(){ 
var id = $(this).data('id');


if(id==""){
alert('There is an Issue with post Id.');
}
else{
$('#loader_msg').fadeIn(400).html('<br><div style="color:black;background:#ddd;padding:10px;"><img src="loader.gif" style="font-size:20px"> &nbsp;Please Wait,Loading Message.</div>');
var datasend = {postid:id};


$.ajax({
			
			type:'POST',
			url:'msg_email.php',
			data:datasend,
                        crossDomain: true,
			cache:false,
			success:function(msg){


                        $('#loader_msg').hide();
				//$('#result_msg').fadeIn('slow').prepend(msg);
$('#result_msg').html(msg);
$('#alertdata_msg').delay(7000).fadeOut('slow');
$('#alertdata_msg').delay(7000).fadeOut('slow');


			
			}
			
		});
		
		}
		
	});
					
});






</script>


<div id="loader_msg"></div>
<div id="result_msg"></div>




     </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>



<!-- The Modal contact/email users Ends -->







<script>



//$(document).ready(function(){
function sms_function(){
//$(document).on( 'click', '.btx_action', function(){ 
var id =  $('.pidx').val();

//alert(id);
if(id==""){
alert('There is an Issue with User Id.');
}
else{
$('#loader_msgs').fadeIn(400).html('<br><div style="color:black;background:#ddd;padding:10px;"><img src="loader.gif" style="font-size:20px"> &nbsp;Please Wait,Loading Message.</div>');
var datasend = {postid:id};


$.ajax({
			
			type:'POST',
			url:'msg_sms.php',
			data:datasend,
                        crossDomain: true,
			cache:false,
			success:function(msg){


                        $('#loader_msgs').hide();
				//$('#result_msg').fadeIn('slow').prepend(msg);
$('#result_msgs').html(msg);
$('#alertdata_msgs').delay(7000).fadeOut('slow');
$('#alertdata_msgs').delay(7000).fadeOut('slow');


			
			}
			
		});
		
		}
		
	}
					
//});






//$(document).ready(function(){
//$('.btn_action').click(function(){
//$(document).on( 'click', '.btx_action', function(){ 

function email_function(){
var id = $('.pidx').val();


if(id==""){
alert('There is an Issue with post Id.');
}
else{
$('#loader_msg').fadeIn(400).html('<br><div style="color:black;background:#ddd;padding:10px;"><img src="loader.gif" style="font-size:20px"> &nbsp;Please Wait,Loading Message.</div>');
var datasend = {userid:id};


$.ajax({
			
			type:'POST',
			url:'msg_email.php',
			data:datasend,
                        crossDomain: true,
			cache:false,
			success:function(msg){


                        $('#loader_msg').hide();
				//$('#result_msg').fadeIn('slow').prepend(msg);
$('#result_msg').html(msg);
$('#alertdata_msg').delay(7000).fadeOut('slow');
$('#alertdata_msg').delay(7000).fadeOut('slow');


			
			}
			
		});
		
		}
		
}




</script>




<input type="hidden" class="p_identity_value pidx"  value="">









<!-- The Modal sms users start -->
<div class="modal fade" id="myModal_sms" >
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Contact User Via SMS</h4>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body starts-->
      <div class="modal-body">



<script>



$(document).ready(function(){
$('#sms_users_btn').click(function(){

	
var sms_message = $('#sms_message').val();
var email = $('.p_email_valuex').val();
var fullname = $('.p_fullname_valuex').val();
var postid = $('.p_identity_value').val();
var phone_no = $('.p_phone_no_value').val();

alert(phone_no);
/*
if(isNaN(discount)){
return false;
}
*/
if(sms_message==""){
alert('SMS Message cannot be Empty.');
$('.sms_message_alert').html("<div class='alert alert-warning' style='color:red;'>SMS Message Cannot be Empty.</div>");


}


else{


$('#loader_s').fadeIn(400).html('<br><div style="color:black;background:#ddd;padding:10px;"><img src="loader.gif" style="font-size:20px"> &nbsp;Please Wait, SMS is being sent in Progress.</div>');
var datasend = {sms_message:sms_message,email:email,fullname:fullname,postid:postid,phone_no:phone_no};


$.ajax({
			
			type:'POST',
			url:'sms_users.php',
			data:datasend,
                        crossDomain: true,
			cache:false,
			success:function(msg){


                        $('#loader_s').hide();
				//$('#result_s').fadeIn('slow').prepend(msg);
$('#result_s').html(msg);
$('#alertdata_s').delay(7000).fadeOut('slow');
$('#alertdata_s').delay(7000).fadeOut('slow');


//sms_function();
$('#sms_message').val('');			
			}
			
		});
		
		}
		
	})
					
});




</script>






<input type="hidden" class="p_email_value p_email_valuex"  value="">
<input type="hidden" class="p_fullname_value p_fullname_valuex"  value="">


<div class='row'>
<div class='col-sm-12' style='background:#ddd;'>

<h4>Users Info</h4>


<b>Name: </b><span class='p_fullname'></span><br>
<b>Email: </b><span class='p_email'></span><br>
<b>Phone No: </b><span class='p_phone_no'></span><br>

               </div>


</div>


<br>

<h5> Send SMS to User</h5><br>
 <div class="form-group">
           <b>Recipient Phone No.</b>
<input disabled type="" class="p_phone_no_value p_phone_no_valuex col-sm-12 form-control"  value="">
</div>

 <div class="form-group">
           <b>Message</b>
              <textarea class="col-sm-12 form-control" id="sms_message" name="sms_message" ></textarea>

            </div>

<div class='sms_message_alert mydata_empty'></div>





<div class="form-group">
<div id="loader_s" ></div>

<div id="result_s" class='mydata_empty'></div>
<br />

<button type="button" id="sms_users_btn" class="btn btn-primary" title='SMS User'>Send SMS Now</button>
</div>







<script>




$(document).ready(function(){
//$('.btn_action').click(function(){
$(document).on( 'click', '.btn_call', function(){ 
var id = $(this).data('id');


if(id==""){
alert('There is an Issue with post Id.');
}
else{
$('#loader_msgs').fadeIn(400).html('<br><div style="color:black;background:#ddd;padding:10px;"><img src="loader.gif" style="font-size:20px"> &nbsp;Please Wait,Loading Message.</div>');
var datasend = {postid:id};


$.ajax({
			
			type:'POST',
			url:'msg_sms.php',
			data:datasend,
                        crossDomain: true,
			cache:false,
			success:function(msg){


                        $('#loader_msgs').hide();
				//$('#result_msg').fadeIn('slow').prepend(msg);
$('#result_msgs').html(msg);
$('#alertdata_msgs').delay(7000).fadeOut('slow');
$('#alertdata_msgs').delay(7000).fadeOut('slow');


			
			}
			
		});
		
		}
		
	});
					
});






</script>


<div id="loader_msgs"></div>
<div id="result_msgs"></div>




      </div>

      <!-- Modal body ends-->


      <!-- Modal footer -->
      <div class="modal-footer">
   <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>



<!-- The Modal sms users Ends -->






















<input type="hidden" class="p_booking_id_valuex book_pay_id" id="booking_idxx" value="">

































</body>
</html>

