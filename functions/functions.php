<?
    session_start();

    function getQuote($symbol) {
        // try to get quote
	$handle = @fopen("http://download.finance.yahoo.com/d/quotes.csv?s={$symbol}&f=sl1d1t1c1ohgv", "r");
	if ($handle !== FALSE) {
	    $data = fgetcsv($handle);
	    if ($data !== FALSE) {
	        return $data[1];
	    }
	}		
    }
	
	
    function load_page($template) {
        $path = '../views/' . $template;
        if (file_exists($path)) {
            require($path);
        }
	else {
	    echo "path not found!";
	}
    }
	
	
    function connectDB($myDB) {
        $servername = "localhost";
        $username = "root";
        $password = "19810925";
        try {
            //connect to server and the chosen database
            $conn = new PDO("mysql:host=$servername;dbname=$myDB", $username, $password);
	    // set the PDO error mode to exception
	    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);		
	    //echo "Connected successfully"; 
        }
	catch(PDOException $e) {
	    echo "Connection failed: " . $e->getMessage();
	}
	return $conn;
    }
?>
