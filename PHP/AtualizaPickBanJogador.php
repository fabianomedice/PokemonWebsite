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

//---------------------------------------
//Recebimento do input
//---------------------------------------
$CodigoTorneio = htmlspecialchars($_GET["CodigoTorneio"]);
$User = htmlspecialchars($_GET["User"]);
$Pick_OU_Ban = htmlspecialchars($_GET["Pick_OU_Ban"]);
$CodigoPokemon = htmlspecialchars($_GET["CodigoPokemon"]);

//---------------------------------------
//Procura o valor do $indexPickBan e $vetorPickBan no servidor
//---------------------------------------

//Procura de termo
$sql = "SELECT Ban, Pick FROM torneios WHERE CodigoTorneio='".$CodigoTorneio."' AND User = '".$User."';";
echo $sql."<br>";
$result = $BancoDeDados->query($sql);

while($row = mysqli_fetch_array($result)) 
{
  $vetorBan = $row["Ban"];
  $vetorPick = $row["Pick"];
}

//Cria um vetor com os index das virgulas
$index_das_virgulas = [];
$index_das_virgulas [0]=0; //O index do inicio
//Acha as virgulas
for($j=0;$j<strlen($vetorBan);$j++)
{
  if ($vetorBan[$j]==",")
    {
      //Salva os index do char depois das virgulas
      $index_das_virgulas []=$j;
    }
}
$index_das_virgulas []=strlen($vetorBan)-1;//O index do fim

//Cria o $Ban
$vetorSalvo = $vetorBan;
$vetorBan = [];
for ($j=0;$j<count($index_das_virgulas)-1;$j++)
{
  if($vetorSalvo[$index_das_virgulas[$j]]==",")
  {
    //O primeiro index é virgula
    if($vetorSalvo[$index_das_virgulas[$j+1]]==",")
    {
      //O primeiro e segundo index são virgula, adiciona +1 no indexador e tira 1 do tamanho
      $vetorBan[$j]=substr($vetorSalvo,$index_das_virgulas[$j]+1,$index_das_virgulas[$j+1]-$index_das_virgulas[$j]-1);
    }
    else
    {
      //Só o primeiro index é virgula, adiciona +1 no indexador
      $vetorBan[$j]=substr($vetorSalvo,$index_das_virgulas[$j]+1,$index_das_virgulas[$j+1]-$index_das_virgulas[$j]);
    }
  }
  else
  {
    //O primeiro index não é virgula
    if($vetorSalvo[$index_das_virgulas[$j+1]]==",")
    {
      //O segundo index é uma vírgula,não muda em nada o tamanho ou index
      $vetorBan[$j]=substr($vetorSalvo,$index_das_virgulas[$j],$index_das_virgulas[$j+1]-$index_das_virgulas[$j]);
    }
    else
    {
      //Nem o primeiro e nem o segundo index é uma vírgula (somente com uma entrada de string, sem virgula) - Caso impossível pois o vetor sempre tem virgula
    }
  }
}

//Cria um vetor com os index das virgulas
$index_das_virgulas = [];
$index_das_virgulas [0]=0; //O index do inicio
//Acha as virgulas
for($j=0;$j<strlen($vetorPick);$j++)
{
  if ($vetorPick[$j]==",")
    {
      //Salva os index do char depois das virgulas
      $index_das_virgulas []=$j;
    }
}
$index_das_virgulas []=strlen($vetorPick)-1;//O index do fim

//Cria o array
$vetorSalvo = $vetorPick;
$vetorPick =[];
for ($j=0;$j<count($index_das_virgulas)-1;$j++)
{
  if($vetorSalvo[$index_das_virgulas[$j]]==",")
  {
    //O primeiro index é virgula
    if($vetorSalvo[$index_das_virgulas[$j+1]]==",")
    {
      //O primeiro e segundo index são virgula, adiciona +1 no indexador e tira 1 do tamanho
      $vetorPick[$j]=substr($vetorSalvo,$index_das_virgulas[$j]+1,$index_das_virgulas[$j+1]-$index_das_virgulas[$j]-1);
    }
    else
    {
      //Só o primeiro index é virgula, adiciona +1 no indexador
      $vetorPick[$j]=substr($vetorSalvo,$index_das_virgulas[$j]+1,$index_das_virgulas[$j+1]-$index_das_virgulas[$j]);
    }
  }
  else
  {
    //O primeiro index não é virgula
    if($vetorSalvo[$index_das_virgulas[$j+1]]==",")
    {
      //O segundo index é uma vírgula,não muda em nada o tamanho ou index
      $vetorPick[$j]=substr($vetorSalvo,$index_das_virgulas[$j],$index_das_virgulas[$j+1]-$index_das_virgulas[$j]);
    }
    else
    {
      //Nem o primeiro e nem o segundo index é uma vírgula (somente com uma entrada de string, sem virgula) - Caso impossível pois o vetor sempre tem virgula
    }
  }
}
echo "<br> Antigos Vetores";
echo "<br> VetorBan = " ;
print_r($vetorBan);
echo "<br> VetorPick = " ;
print_r($vetorPick);
echo "<br>";

//---------------------------------------
//Atualiza o valor do $indexPickBan ou $vetorPickBan com a nova entrada
//---------------------------------------
echo "<br>Evento enviado = ".$Pick_OU_Ban."<br>";
if($Pick_OU_Ban[0] == "B")
{
  echo "Operação - Ban <br>";
  echo "Atualizando o ".substr($Pick_OU_Ban,1)."º Ban com o Pokemon ".$CodigoPokemon."<BR>";
  $vetorBan[substr($Pick_OU_Ban,1)-1] = $CodigoPokemon;
}
else
{
  echo "Operação - Pick <br>";
  echo "Atualizando o ".(substr($Pick_OU_Ban,1))."º Pick com o Pokemon ".$CodigoPokemon."<BR>";
  $vetorPick[substr($Pick_OU_Ban,1)-1] = $CodigoPokemon;
}

echo "<br> Novos Vetores";
echo "<br> VetorBan = " ;
print_r($vetorBan);
echo "<br> VetorPick = " ;
print_r($vetorPick);
echo "<br>";

//---------------------------------------
//Atualiza o valor do $indexPickBan e $vetorPickBan no servidor
//---------------------------------------
$stringVetorBan ="";
for ($i=0;$i<count($vetorBan);$i++)
{
  if($i==count($vetorBan)-1)
  {
    //Ultimo número, não entra a virgula
    $stringVetorBan = $stringVetorBan.$vetorBan[$i];
  }
  else
  {
    //Qualquer outro número, adiciona a vírgula
    $stringVetorBan = $stringVetorBan.$vetorBan[$i].",";
  }
}
//echo $stringVetorBan."<br>";

$stringVetorPick ="";
for ($i=0;$i<count($vetorPick);$i++)
{
  if($i==count($vetorPick)-1)
  {
    //Ultimo número, não entra a virgula
    $stringVetorPick = $stringVetorPick.$vetorPick[$i];
  }
  else
  {
    //Qualquer outro número, adiciona a vírgula
    $stringVetorPick = $stringVetorPick.$vetorPick[$i].",";
  }
}
//echo $stringVetorPick."<br>";


//Procura de termo
//$sql = "SELECT Ban, Pick FROM torneios WHERE CodigoTorneio='".$CodigoTorneio."' AND User = '".$User."';";
$sql = "UPDATE torneios SET Ban='".$stringVetorBan."', Pick='".$stringVetorPick."' WHERE CodigoTorneio='".$CodigoTorneio."' AND User = '".$User."';";
echo "<br>".$sql."<br>";
$result = $BancoDeDados->query($sql);

//---------------------------------------
//Termino de Conexão
//---------------------------------------
$BancoDeDados->close();

?>
