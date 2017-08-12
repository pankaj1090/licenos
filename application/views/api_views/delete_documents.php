<html>
<head>
	<title>SignUp</title>
</head>
<body>

  <?php echo form_open_multipart('Webservice/delete_documents'); ?> 

    <h1>Url is :  <?php echo base_url('Webservice/delete_documents'); ?> </h1>
    This is Post api<br><br>
    id*<input type="text" name="id"><br>
    <input type="submit" value="submit"><br>

</form>
 

</body>
</html>