<h1><?php echo base_url('Webservice/update_password'); ?></h1>
<div class="col-md-6 col-lg-6 col-sm-6">
	<?php echo form_open('Webservice/update_password'); ?>		
		<div class="col-md-6 col-lg-6 col-sm-6">
		<p>email<input type="text" name="email" ></p>
		<p>old_password<input type="password" name="old_password" ></p>
		<p>password<input type="password" name="password" ></p>
		</div>	
		<p><input type="submit" name="save" value="Submit"></p>	
	</form>
</div>
