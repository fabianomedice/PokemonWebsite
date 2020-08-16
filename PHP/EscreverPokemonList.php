<?php
//---------------------------------------
//Conexão
//---------------------------------------

//$servername = '127.0.0.1'; //ou "localhost"
$servername = "localhost"; //ou "localhost"
$username = 'root';
$password = ''; //To be completed if you have set a password to root
$database = 'pokemon'; //To be completed to connect to a database. The database must exist.
$port = 3308; //Default must be NULL to use default port
$BancoDeDados = new mysqli($servername, $username, $password, $database, $port);


/*if ($BancoDeDados->connect_error) 
{
  die('Connect Error (' . $BancoDeDados->connect_errno . ') '. $BancoDeDados->connect_error);
}
echo '<p>Connection OK '. $BancoDeDados->host_info.'</p>';
echo '<p>Server '.$BancoDeDados->server_info.'</p>';*/

//---------------------------------------
//Procura de termo
//---------------------------------------

$sql = "UPDATE pokemon_list SET StatusPick='".$_GET["Status"]."' WHERE Codigo='".$_GET["Codigo"]."'";

//echo $sql;

$result = $BancoDeDados->query($sql);

//---------------------------------------
//Termino de Conexão
//---------------------------------------
$BancoDeDados->close();

?>
