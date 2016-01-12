		<div class="row">
			<h3 style="text-align:center">Welcome to stock trade system, you will get $10000 after your finish registration!</h3>
			<?php if ($_SESSION['exist']): ?>
				<p style="color:red; text-align: center">This email has been used. Please choose a different email address!</p>
			 <?php endif ?> 
			 <?
				if ($_SESSION['exist']) $_SESSION['exist'] = false;
			 ?>
			<br><br>
		</div>
	
		<!--for registration form-->
		<div class="row center">
			<form action="/validation.php" method="post" onsubmit="return validate(this);" role="form">
			  First name: <input name="firstname" type="text" class="form-control input-sm textinput"><br>
			  Last name: <input name="lastname" type="text" class="form-control input-sm textinput"><br>
			  Email: (will be used as username)<input name="email" type="text" class="form-control input-sm textinput"><br>
			  Password: (at least 6 characters that contain both letters and numbers)<input name="password1" type="password" class="form-control input-sm textinput"><br>
			  Confirm password:<input name="password2" type="password" class="form-control input-sm textinput"><br>
			  <button type="submit" class="btn btn-success btn-sm">Register</button>		
			</form>	
		</div>
		
	</div> <!--container-->
