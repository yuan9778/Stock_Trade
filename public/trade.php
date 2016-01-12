<?
	// load functions
    require('../functions/functions.php');
	
	session_start();

	$conn = connectDB("stock");	
	
	$host = $_SERVER["HTTP_HOST"];
    $path = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
    	
	$today = date("F j, Y, g:i a");
	
	if ($_POST['submit'] == "Submit" && $_POST['select'] == "sell") { // sell stocks that owned 
		echo "howdy1!";
		$sql = sprintf("UPDATE users
						SET balance='%f' WHERE userid='%d'",
						$_SESSION['balance'] + $_POST['quantity'] * $_POST['price'], $_SESSION['id']);
		$conn->exec($sql);// update balance in users table
					
		$sql = sprintf("UPDATE portfolio
						SET shares='%d' WHERE userid='%d' AND symbol='%s'",
						$_POST['shares'] - $_POST['quantity'], $_SESSION['id'], $_POST["symbol"]);
		$conn->exec($sql);//update shares in portfolio table
		
		$sql = sprintf("INSERT INTO history (userid, symbol, shares, sell_buy, price, cost, time) 
						VALUES ('%d', '%s', '%d', '0', '%f', '%f', '%s')",
						$_SESSION['id'], $_POST["symbol"], $_POST["quantity"], $_POST["price"], $_POST["quantity"] * $_POST["price"], $today);
		 $conn->exec($sql); // insert a record into table history
	}	
	else { // buy stocks
		$sql = sprintf("SELECT shares FROM portfolio WHERE userid='%d' AND symbol='%s'", $_SESSION['id'], $_POST["symbol"]);
		$portfolioRet = $conn->query($sql);		
		$result = $portfolioRet->rowCount();
		
		$shares1 = 0;
		if ($result > 0) {
			foreach($portfolioRet as $row) {
				$shares1 = $row['shares'];
			}
		}
		
		if ($_POST['submit'] == "Submit" || $result > 0) { // buy more stocks
			$shares2 = ($result > 0) ? $shares1 : $_POST['shares'];	
						
			$sql = sprintf("UPDATE users
						SET balance='%f' WHERE userid='%d'",
						$_SESSION['balance'] - $_POST['quantity'] * $_POST['price'], $_SESSION['id']);
			$conn->exec($sql);// update balance in users table
						
			$sql = sprintf("UPDATE portfolio
							SET shares='%d' WHERE userid='%d' AND symbol='%s'",
							$_POST['quantity'] + $shares2, $_SESSION['id'], $_POST["symbol"]);
			$conn->exec($sql);//update shares in portfolio table
			
			$sql = sprintf("INSERT INTO history (userid, symbol, shares, sell_buy, price, cost, time) 
							VALUES ('%d', '%s', '%d', '1', '%f', '%f', '%s')",
							$_SESSION['id'], $_POST["symbol"], $_POST["quantity"], $_POST["price"], $_POST["quantity"] * $_POST["price"], $today);
			$conn->exec($sql); // insert a record into table history
		}
		else { // buy new stocks
			$sql = sprintf("UPDATE users
						SET balance='%f' WHERE userid='%d'",
						$_SESSION['balance'] - $_POST['quantity'] * $_POST['price'],$_SESSION['id']);						
			$conn->exec($sql);// update balance in users table
						
			$sql = sprintf("INSERT INTO portfolio (userid, symbol, shares)
							VALUES ('%d', '%s', '%d')",
							$_SESSION['id'], $_POST['symbol'], $_POST['quantity']);							
			$conn->exec($sql);//update shares in portfolio table
			
			$sql = sprintf("INSERT INTO history (userid, symbol, shares, sell_buy, price, cost, time) 
							VALUES ('%d', '%s', '%d', '1', '%f', '%f', '%s')",
							$_SESSION['id'], $_POST["symbol"], $_POST["quantity"], $_POST["price"], $_POST["quantity"] * $_POST["price"], $today);			
			$conn->exec($sql); // insert a record into table history
		}
	}
	
	header("Location: http://$host$path/profile.php");
    exit();
?>
