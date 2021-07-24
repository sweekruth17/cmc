<?php
include 'config.php';
$url = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest';
$parameters = [
  'start' => '1',
  'limit' => '5000',
  'convert' => 'USD'
];

$headers = [
  'Accepts: application/json',
  'X-CMC_PRO_API_KEY: a862acd2-b5fb-4a99-984b-4c722bbf188c'
];
//$qs = http_build_query($parameters); // query string encode the parameters
$request = "{$url}"; // create the request URL
//?{$qs}

$curl = curl_init(); // Get cURL resource
// Set cURL options
curl_setopt_array($curl, array(
  CURLOPT_URL => $request,            // set the request URL
  CURLOPT_HTTPHEADER => $headers,     // set the headers 
  CURLOPT_RETURNTRANSFER => 1         // ask for raw response instead of bool
));

$response = curl_exec($curl);
$output = json_decode($response); // Send the request, save the response and json decoded response
 
//for($i =0;$i < sizeof($output->data);$i++){
   // print_r($output->data[$i]); // print
  //  echo "<br><br>";
    // $id  = $output->data[$i]->id;
	// $name = mysqli_real_escape_string($connection,$output->data[$i]->name);
	// $symbol = $output->data[$i]->symbol;
	// $slug = $output->data[$i]->slug;
	// $sql = "Insert into coin_list(id,name, symbol, slug) values ('$id', '$name', '$symbol','$slug')";

	// if($connection->query($sql) == FALSE)
	// {
	// 	echo "Error ".$connection->error;
	// }
//}
foreach($output->data as $key =>$value)
{
	// print_r($output->data->$key);
	$id = $output->data->$key->id;
	$name = $output->data->$key->name;
	$symbol = $output->data->$key->symbol;
	//$rank = $output->data->$key->cmc_rank;
	$slug = $output->data->$key->slug;
    $sql = "Insert into coin_list(id,name, symbol, slug) values ('$id', '$name', '$symbol','$slug')";
    if($connection->query($sql) == FALSE)
	{
		echo "Error ".$connection->error;
	}
}
curl_close($curl); // Close request
?>