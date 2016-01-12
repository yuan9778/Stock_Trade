		 <div class="col-md-3">
			 <span>Hello, <?= $_SESSION['fname'] ?>!</span>
			 <form class="form-inline" style="float: right" action="/index.php" method="post" role="form">
				<label for="space"></label>
				<button type="submit" class="btn btn-info btn-sm">Log out</button>
			 </form>	
		  </div>	
		</div>
		
		
		<!--for transaction-->
		<div class="row">

				<!--tab design for account-->
			  <h2>My Account</h2> 
			  <br>
			  <ul class="nav nav-tabs"> 
				<li class="active"><a data-toggle="tab" href="#home">Profile</a></li>
				<li><a data-toggle="tab" href="#menu1">Trade Stock</a></li>
				<li><a data-toggle="tab" href="#menu2">Transaction History</a></li>
			  </ul>
			  
			  <? // connect to database stock and fetch info that will be used on tabs
					$conn = connectDB("stock");		
					 
					// fetch info for this user from database
					$sql = sprintf("SELECT * FROM users WHERE email='%s'", $_SESSION['email']);
					$result = $conn->query($sql);
					foreach($result as $row) {
						$id = $row['userid'];
						$name = $row['firstname'] . " " . $row['lastname'];
						$email = $row['email'];
						$balance = $row['balance'];
					}
					$_SESSION['id'] = $id;
					$_SESSION['balance'] = $balance;
					$sql = sprintf("SELECT * FROM portfolio WHERE userid='%s'", $id);
					$portfolio = $conn->query($sql);
					$sql = sprintf("SELECT * FROM history WHERE userid='%s'", $id);
					$history = $conn->query($sql);
					$total = 0;					
			  ?>
			  
			  <div class="tab-content">
					<!--for profile tab, this is the default tab-->
					<div id="home" class="tab-pane fade in active">
						<br><br>
						  <ul class="list-group">
							  <li class="list-group-item"><span style="color: blue; font-weight: bold">Name: </span><?= $name ?></li>
							  <li class="list-group-item"><span style="color: blue; font-weight: bold">Email: </span><?= $email ?></li>
							  <li class="list-group-item"><span style="color: blue; font-weight: bold">Balance: </span>$<?= $balance ?></li>
						  </ul>
					</div> <!--profile-->
					
					
					<!--for trade stock/portfolio tab-->
					<div id="menu1" class="tab-pane fade">
						<h3>Your Portforlio</h3>
						<table class="table">
							<thead>
							  <tr>
								<th>Company</th>
								<th>Shares</th>
								<th>Current Price</th>
								<th>Current Value</th>
								<th>Trade</th>
							  </tr>
							</thead>
							
							<tbody>
								<? foreach($portfolio as $item): ?>
									<tr class="success">
										<? $curr_price = getQuote($item['symbol']);  ?>
										<td><?= $item['symbol'] ?></td>
										<td><?= $item['shares'] ?></td>
										<td>$<?= $curr_price ?></td>
										<td>$<?= $item['shares'] * $curr_price ?></td>
										<td>
											<? $_SESSION['symbol'] = $item['symbol']; ?>
											<form action="trade.php" onsubmit="return tradeValidate(this);" method="post" role="form">
												<input type="hidden" name="symbol" value="<?= $item['symbol'] ?>" />
												<input type="hidden" name="balance" value="<?= $balance ?>" />
												<input type="hidden" name="shares" value="<?= $item['shares'] ?>" />
												<input type="hidden" name="price" value="<?= $curr_price ?>" />
												<input style="width: 100px" type="number" name="quantity" min="1" placeholder="quantity">
												<select name="select">
													<option value="buy">buy</option>
													<option value="sell">sell</option>
												</select>
												<input type="submit" name="submit" value="Submit">
											</form>										
										</td>
									 </tr>
									 <? $total += $item['shares'] * $curr_price; ?>
								 <? endforeach ?>
								 <tr >	
										<td></td>
										<td></td>
										<td></td>
										<td><strong>Total: $<?= $total ?></strong></td>
								 </tr>
							 </tbody>
						</table>

						<br><br>
						<!--this is the place to buy new stock-->
						<h3>Want to buy a new stock? (Your balance is $<?= $balance ?>)</h3>										
							<form action="trade.php" onsubmit="return tradeValidate(this);" method="post" role="form">
								<input type="hidden" name="balance" value="<?= $balance ?>" />
								<input type="hidden" name="price" />
															
								Type the Symbol and click outside the field to get the stock price. <br>
								If the price is not shown, it means the symbol is invalid. <br>
								Check <a href="http://www.nasdaq.com/screening/company-list.aspx">here</a> for a complete list of company symbols.

								<input style="width:90px" id="symbol_p" name="symbol" type="text" class="form-control input-sm" placeholder="symbol">
								Current Price: $<span style="font-weight: bold" id="price_p"></span><br><br>								
								How many shares you want to buy?
								<input style="width: 80px" type="number" id="quantity" name="quantity" class="form-control input-sm" min="1" placeholder="quantity"><br>
								Cost: $<span id="cost"></span><br><br>
								<input type="submit" class="btn btn-success btn-sm" name="submit" value="Buy">
							</form>
					</div><!--portfolio-->				

					
					<!--for history tab-->
					<div id="menu2" class="tab-pane fade">
						
						<h3>History</h3>
						<table class="table">
							<thead>
							  <tr>
								<th>Time</th>
								<th>Buy/Sell</th>
								<th>Company</th>
								<th>Shares</th>								
								<th>Price</th>
								<th>Value</th>
							  </tr>
							</thead>
							
							<tbody>
								<? foreach($history as $record): ?>
									<tr class="info">
										<td><?= $record['time'] ?></td>
										<td><?= ($record['sell_buy']) ? "buy" : "sell" ?></td>
										<td><?= $record['symbol'] ?></td>
										<td><?= $record['shares'] ?></td>
										<td>$<?= $record['price'] ?></td>
										<td><?= ($record['sell_buy']) ? $record['cost'] : -$record['cost'] ?></td>
									</tr>
								<? endforeach ?>
							</tbody>
						</table>							  
					</div> <!--History-->			
			  </div>			
		</div>		
	
	</div> <!--container-->
