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

$sql = "SELECT Generation, Codigo, Nome, TierGen".$_GET["Gen"].", StatusPick, Imagem FROM pokemon_list WHERE TierGen".$_GET["Gen"]."<> 0";

$result = $BancoDeDados->query($sql);

//---------------------------------------
//Mostra de Resultados
//---------------------------------------

if ($result->num_rows > 0) 
{
  // output data of each row
  //while($row = $result->fetch_assoc()) //Outra maneira de escrever o while
  $Banco_de_Dados_Recebido = array();
  while($row = mysqli_fetch_array($result)) 
  {
    //echo "Generation = ".$row["Generation"]." Codigo = ".$row["Codigo"]. " Nome = ".$row["Nome"]." Tier = ".$row["TierGen7"]." StatusPick = ".$row["StatusPick"]." Imagem = ".$row["Imagem"]."<br>"; //Mostrar os dados
    $Banco_de_Dados_Recebido[] = ['Generation'=>$row["Generation"], 'Pokedex'=>$row["Codigo"], 'Nome'=>$row["Nome"], 'Tier'=>$row["TierGen".$_GET["Gen"]], 'StatusPick'=>filter_var($row["StatusPick"],FILTER_VALIDATE_BOOLEAN),'Imagem'=>$row["Imagem"]];

    //Necessário utilizar o 'StatusPick'=>filter_var($row["StatusPick"],FILTER_VALIDATE_BOOLEAN) para transformar o texto "true" ou "false" em variáveis booleanas
  }
} 
else 
{
  echo "0 results";
}

//print_r($Banco_de_Dados_Recebido); //printa ele na tela

$Banco_de_Dados_Recebido_Em_JSON = json_encode($Banco_de_Dados_Recebido);

echo $Banco_de_Dados_Recebido_Em_JSON;

//---------------------------------------
//Termino de Conexão
//---------------------------------------
$BancoDeDados->close();

?>
