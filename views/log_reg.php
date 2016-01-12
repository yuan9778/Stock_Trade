
		  <div class="col-md-5">
			<div class="row">
				<!--log in-->
				<form class="form-inline" style="float: left" action="/verification.php" method="post" role="form">
					<input type="email" class="form-control input-sm" style="width: 150px" name="email" placeholder="email">
					<input type="password" class="form-control input-sm" style="width: 80px" name="pwd" placeholder="password">					
					<button type="submit" class="btn btn-info btn-sm">Login</button>					
				</form>
				<!--register-->
				<form class="form-inline" style="float: left" action="/register.php" method="post" role="form">
					<label for="space"></label>
					<button type="submit" class="btn btn-info btn-sm">Register</button>
				</form>				
			</div>
			<div class="row">	
				<?php if (!$_SESSION['match']): ?>
					<?php $_SESSION['match'] = true ?> 
					<span style="color:red">Incorrect email and/or password, please try again!</span>
				 <?php endif ?> 
			</div>
		  </div> <!--col-md-5-->	
		</div><!--row well well-sm-->
