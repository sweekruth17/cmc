<?php
$dbhost = "localhost";
$username = "coinmc";
$databasename= "coinmc";
$password ="2jw6s&J*?fhY4dY";

$connection = new mysqli($dbhost,$username,$password,$databasename);

if($connection -> connect_error){
    echo "Connection Failed!" .$connection->connect_error;

}
else{
    echo "nkn ayytu";
}
?>
