<html>
<head>
	<title>SignUp</title>
</head>
 <body> 
 <h1>Url is :  <?php echo base_url('Webservice/send_otp'); ?> </h1>
    This is Post api<br><br>
      <?php 
         echo $this->session->flashdata('email_sent'); 
         echo form_open('/Webservice/send_otp'); 
      ?> 	
     <p>mobile<input type="text" name="mobile" size="10" min="10" required></p>
     <p>otp<input type="text" name="otp" size="10" min="10" required></p>
      <input type = "submit" value = "SEND OTP"> 		
      <?php 
         echo form_close(); 
      ?> 
   </body>
</html>