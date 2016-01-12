<?
    /**
     * quote.php
     *
     * Outputs price, low, and high of given symbol in JSON format
     * using PHP's JSON extension.
     */

    // defines a stock
    class Stock
    {
        public $price;
        public $high;
        public $low;
        public $qtime;
    }

    // set MIME type
    header("Content-type: application/json");

    // try to get quote
    $handle = @fopen("http://download.finance.yahoo.com/d/quotes.csv?s={$_GET['symbol']}&f=sl1d1t1c1ohgv", "r");

    if ($handle !== FALSE)
    {
        $data = fgetcsv($handle);
        if ($data !== FALSE)
        {
            $stock = new Stock();
        
            if (is_numeric($data[1]))
                $stock->price = $data[1];
            if (is_numeric($data[6]))
                $stock->high = $data[6];
            if (is_numeric($data[7]))
                $stock->low = $data[7];
            $stock->qtime = $data[2] . " " . $data[3];
        }
        fclose($handle);
    }

    // output JSON
    print(json_encode($stock));
?>
