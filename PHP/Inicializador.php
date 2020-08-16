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

//---------------------------------------
// Criação $vetorPlayersUser
//---------------------------------------
//Procura de termo
$sql = "SELECT User,OrdemPickBan FROM torneios WHERE CodigoTorneio LIKE '".$CodigoTorneio."';";
//echo $sql."<br>";
$result = $BancoDeDados->query($sql);

//Cria o banco de dados recebido
while($row = mysqli_fetch_array($result)) 
{
  //echo "User = ".$row["User"]." OrdemPickBan = ".$row["OrdemPickBan"]."<br>"; //Mostrar os dados
  $Banco_de_Dados_Recebido[] = ['User'=>$row["User"], 'OrdemPickBan'=>$row["OrdemPickBan"]];
}
/*echo "<br>";
print_r($Banco_de_Dados_Recebido); //printa ele na tela
echo "<br><br>";*/

//Cria o $vetorPlayersUser
for($i=0;$i<$result->num_rows;$i++)
{
  $vetorPlayersUser[$Banco_de_Dados_Recebido[$i]['OrdemPickBan']-1]=$Banco_de_Dados_Recebido[$i]['User'];
}

ksort($vetorPlayersUser); //organiza o array por ordem crescente de pick
//print_r($vetorPlayersUser);//printa ele na tela

//---------------------------------------
// Criação $Gen, $indexPickBan e $VetorPickBan
//---------------------------------------
//Procura de termo
$sql = "SELECT Gen,indexPickBan,VetorPickBan FROM vetores_torneio WHERE CodigoTorneio = '".$CodigoTorneio."';";
//echo $sql."<br>";
$result = $BancoDeDados->query($sql);
while($row = mysqli_fetch_array($result)) 
{
  //echo "Gen = ".$row["Gen"]." indexPickBan = ".$row["indexPickBan"]." VetorPickBan = ".$row["VetorPickBan"]."<br>"; //Mostrar os dados
  $Banco_de_Dados_Recebido = ['Gen'=>$row["Gen"], 'indexPickBan'=>$row["indexPickBan"], 'VetorPickBan'=>$row["VetorPickBan"]];
}
//print_r($Banco_de_Dados_Recebido);
//echo "<br>";

// Criando $Gen
$Gen = $Banco_de_Dados_Recebido['Gen'];
/*echo "Gen = ".$Gen."<br>";*/

// Criando $indexPickBan
$indexPickBan = $Banco_de_Dados_Recebido['indexPickBan'];
/*echo "indexPickBan = ".$indexPickBan."<br>";*/

// Criando $VetorPickBan
if (strlen($Banco_de_Dados_Recebido['VetorPickBan'])==1)
{
  //Vetor zerado ou com uma entrada de uma string
  $VetorPickBan[] = $Banco_de_Dados_Recebido['VetorPickBan'];
}
else
{
  //Vetor com uma entrada com mais de uma string ou mais de uma entrada
  //Cria um vetor com os index das virgulas
  $index_das_virgulas [0]=0; //O index do inicio
  //Acha as virgulas
  for ($i=0;$i<strlen($Banco_de_Dados_Recebido['VetorPickBan']);$i++)
  {
    if ($Banco_de_Dados_Recebido['VetorPickBan'][$i]==",")
    {
      //Salva os index do char depois das virgulas
      $index_das_virgulas []=$i;
    }
  }
  $index_das_virgulas []=strlen($Banco_de_Dados_Recebido['VetorPickBan'])-1;//O index do fim
  //Cria o vetor
  for ($i=0;$i<count($index_das_virgulas)-1;$i++)
  {
    if($Banco_de_Dados_Recebido['VetorPickBan'][$index_das_virgulas[$i]]==",")
    {
      //O primeiro index é virgula
      if($Banco_de_Dados_Recebido['VetorPickBan'][$index_das_virgulas[$i+1]]==",")
      {
        //O primeiro e segundo index são virgula, adiciona +1 no indexador e tira 1 do tamanho
        $VetorPickBan[]=substr($Banco_de_Dados_Recebido['VetorPickBan'],$index_das_virgulas[$i]+1,$index_das_virgulas[$i+1]-$index_das_virgulas[$i]-1);
      }
      else
      {
        //Só o primeiro index é virgula, adiciona +1 no indexador
        $VetorPickBan[]=substr($Banco_de_Dados_Recebido['VetorPickBan'],$index_das_virgulas[$i]+1,$index_das_virgulas[$i+1]-$index_das_virgulas[$i]);
      }
    }
    else
    {
      //O primeiro index não é virgula
      if($Banco_de_Dados_Recebido['VetorPickBan'][$index_das_virgulas[$i+1]]==",")
      {
        //O segundo index é uma vírgula,não muda em nada o tamanho ou index
        $VetorPickBan[]=substr($Banco_de_Dados_Recebido['VetorPickBan'],$index_das_virgulas[$i],$index_das_virgulas[$i+1]-$index_das_virgulas[$i]);
      }
      else
      {
        //Nem o primeiro e nem o segundo index é uma vírgula (somente com uma entrada de string, sem virgula), adiciona +1 no tamanho
        $VetorPickBan[]=substr($Banco_de_Dados_Recebido['VetorPickBan'],$index_das_virgulas[$i],$index_das_virgulas[$i+1]-$index_das_virgulas[$i]+1);
      }
      
    }
  }
}
/*echo "VetorPickBan = ";
print_r ($VetorPickBan);
echo "<br>";*/

//---------------------------------------
//Criação da matriz em JSON
//---------------------------------------
//São dois vetores e 2 constantes
if (count ($vetorPlayersUser)>count ($VetorPickBan))
{
  //$vetorPlayersUser tem maior número de dados
  for($i=0;$i<count($VetorPickBan);$i++)
  {
    //Adiciona todos os dados dos dois vetores
    $Banco_de_Dados_Enviado[$i]=['vetorPlayersUser' => $vetorPlayersUser[$i], 'Gen' => $Gen, 'indexPickBan' => $indexPickBan,'VetorPickBan'=>$VetorPickBan[$i] ];
  }
  for($i=count($VetorPickBan);$i<count($vetorPlayersUser);$i++)
  {
    //Adiciona os dados do vetor $vetorPlayersUser
    $Banco_de_Dados_Enviado[$i]=['vetorPlayersUser' => $vetorPlayersUser[$i], 'Gen' => $Gen, 'indexPickBan' => $indexPickBan,'VetorPickBan'=>"-" ];
  }
}
else
{
  //$VetorPickBan tem maior número de dados 
  for($i=0;$i<count($vetorPlayersUser);$i++)
  {
    //Adiciona todos os dados dos dois vetores
    $Banco_de_Dados_Enviado[$i]=['vetorPlayersUser' => $vetorPlayersUser[$i], 'Gen' => $Gen, 'indexPickBan' => $indexPickBan,'VetorPickBan'=>$VetorPickBan[$i] ];
  }
  for($i=count($vetorPlayersUser);$i<count($VetorPickBan);$i++)
  {
    //Adiciona os dados do vetor $VetorPickBan
    $Banco_de_Dados_Enviado[$i]=['vetorPlayersUser' => "-", 'Gen' => $Gen, 'indexPickBan' => $indexPickBan,'VetorPickBan'=>$VetorPickBan[$i] ];
  }
}

/*echo "<br>";
print_r($Banco_de_Dados_Enviado);
echo "<br>";*/

$Banco_de_Dados_Enviado_Em_JSON = json_encode($Banco_de_Dados_Enviado);
echo $Banco_de_Dados_Enviado_Em_JSON;

//---------------------------------------
//Inicializa os pokemons pickados
//---------------------------------------
//Reseta o status do banco de dados
//Procura de termo
$sql = "UPDATE pokemon_list SET StatusPick='false';";
//echo $sql."<br>";
$result = $BancoDeDados->query($sql);

//Preenche o status do banco de dados com os pokemons do pick e ban
$sql = "UPDATE pokemon_list SET StatusPick='true' WHERE ";
//Cria os "Codigo = CodigoDoPokemon" para atualizar o status pick
for($i=0;$i<count($VetorPickBan);$i++)
  {
    if($i==count($VetorPickBan)-1)
    {
      //Ultimo termo do array
      $sql=$sql."Codigo = '".$VetorPickBan[$i]."';";
    }
    else
    {
      $sql=$sql."Codigo = '".$VetorPickBan[$i]."' OR ";
    }
  }
  /*echo "<br>";
  echo $sql;*/
  $result = $BancoDeDados->query($sql);

//---------------------------------------
//Termino de Conexão
//---------------------------------------
$BancoDeDados->close();

?>
