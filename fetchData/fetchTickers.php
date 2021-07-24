<?php
include 'config.php';
$url = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest';
$parameters = [
  'start' => '1',
  'limit' => '200',
  'convert' => 'USD'
];

$headers = [
  'Accepts: application/json',
  'X-CMC_PRO_API_KEY: b9515116-8551-41a6-9275-8aa60ac6beb2'
];
$qs = http_build_query($parameters); // query string encode the parameters
$request = "{$url}?{$qs}"; // create the request URL


$curl = curl_init(); // Get cURL resource
// Set cURL options
curl_setopt_array($curl, array(
  CURLOPT_URL => $request,            // set the request URL
  CURLOPT_HTTPHEADER => $headers,     // set the headers 
  CURLOPT_RETURNTRANSFER => 1         // ask for raw response instead of bool
));

$response = curl_exec($curl);
$output = json_decode($response); // Send the request, save the response and json decoded response
 


for($i =0;$i < sizeof($output->data);$i++){
   //print_r($output->data[$i]); // print
  // echo "<br><br>";
    $id  = $output->data[$i]->id;
	$name = mysqli_real_escape_string($connection,$output->data[$i]->name);
	$symbol = $output->data[$i]->symbol;
    $rank = $output->data[$i]->cmc_rank;
	$slug = $output->data[$i]->slug;
    $circ_supply = $output->data[$i]->circulating_supply;	
	$total_supply = $output->data[$i]->total_supply;
	$max_supply = $output->data[$i]->max_supply;

    	$usd_price = $output->data[$i]->quote->USD->price;
	$usd_vol24 = $output->data[$i]->quote->USD->volume_24h;
	$usd_marketcap = $output->data[$i]->quote->USD->market_cap;
	$usd_per1h = $output->data[$i]->quote->USD->percent_change_1h;
	$usd_per24h = $output->data[$i]->quote->USD->percent_change_24h;
	$usd_per7d = $output->data[$i]->quote->USD->percent_change_7d;

	

    $check = "Select * from `tickers` where `id` = '$id'";
	$result = $connection->query($check);

	if($result->num_rows > 0)
	{   
        //echo "Coin Exists :".$name;
		$updateTickers = "UPDATE `tickers` SET `rank`='$rank',`circ_supply`='$circ_supply',`usd_price`='$usd_price',`usd_vol24`='$usd_vol24',`usd_marketcap`='$usd_marketcap',`usd_per1h`='$usd_per1h',`usd_per24h`='$usd_per24h',`usd_per7d`='$usd_per7d' where `id` = '$id'";
		if($connection->query($updateTickers) == FALSE)
	{
		echo "Error ".$connection->error;
	}
}
else{   

   $sql = "INSERT INTO `tickers`(`id`, `name`, `symbol`, `rank`, `slug`, `circ_supply`, `total_supply`, `max_supply`, `usd_price`, `usd_vol24`, `usd_marketcap`, `usd_per1h`, `usd_per24h`, `usd_per7d`) VALUES ('$id', '$name', '$symbol', '$rank', '$slug', '$circ_supply', '$total_supply', '$max_supply', '$usd_price', '$usd_vol24', '$usd_marketcap', '$usd_per1h', '$usd_per24h', '$usd_per7d')";
   if($connection->query($sql) == FALSE)
   {
       echo "Error ".$connection->error;
   }
}

    
	
}
curl_close($curl); // Close request
?>