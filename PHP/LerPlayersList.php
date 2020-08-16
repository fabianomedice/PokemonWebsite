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
//Busca do User, vetor Ban, vetor Pick
//---------------------------------------
//Procura de termo
$sql = "SELECT User, Ban, Pick FROM torneios WHERE CodigoTorneio = '".$_GET["CodigoTorneio"]."';";
//echo $sql."<br>";
$result = $BancoDeDados->query($sql);

//---------------------------------------
//Mostra de Resultados
//---------------------------------------

if ($result->num_rows > 0) 
{
  // output data of each row
  //while($row = $result->fetch_assoc()) //Outra maneira de escrever o while
  while($row = mysqli_fetch_array($result)) 
  {
    $User[] = $row["User"];
    $vetorBan[] = $row["Ban"];
    $vetorPick[] = $row["Pick"];
  }
} 
else 
{
  echo "0 results";
}
//Salva os dados
/*echo "<br>User = ";
print_r($User);
echo "<br>Ban = ";
print_r($vetorBan);
echo "<br>Pick = ";
print_r($vetorPick);
echo "<br>";*/

//Cria os Arrays com os vetores de Ban
for($i=0;$i<count($vetorBan);$i++)
{
  //Cria um vetor com os index das virgulas
  $index_das_virgulas = [];
  $index_das_virgulas [0]=0; //O index do inicio
  //Acha as virgulas
  for($j=0;$j<strlen($vetorBan[$i]);$j++)
  {
    if ($vetorBan[$i][$j]==",")
      {
        //Salva os index do char depois das virgulas
        $index_das_virgulas []=$j;
      }
  }
  $index_das_virgulas []=strlen($vetorBan[$i])-1;//O index do fim

  //Cria o array
  $vetorSalvo = $vetorBan[$i];
  for ($j=0;$j<count($index_das_virgulas)-1;$j++)
  {
    if($vetorSalvo[$index_das_virgulas[$j]]==",")
    {
      //O primeiro index é virgula
      if($vetorSalvo[$index_das_virgulas[$j+1]]==",")
      {
        //O primeiro e segundo index são virgula, adiciona +1 no indexador e tira 1 do tamanho
        $ArrayBan[$i][$j]=substr($vetorSalvo,$index_das_virgulas[$j]+1,$index_das_virgulas[$j+1]-$index_das_virgulas[$j]-1);
      }
      else
      {
        //Só o primeiro index é virgula, adiciona +1 no indexador
        $ArrayBan[$i][$j]=substr($vetorSalvo,$index_das_virgulas[$j]+1,$index_das_virgulas[$j+1]-$index_das_virgulas[$j]);
      }
    }
    else
    {
      //O primeiro index não é virgula
      if($vetorSalvo[$index_das_virgulas[$j+1]]==",")
      {
        //O segundo index é uma vírgula,não muda em nada o tamanho ou index
        $ArrayBan[$i][$j]=substr($vetorSalvo,$index_das_virgulas[$j],$index_das_virgulas[$j+1]-$index_das_virgulas[$j]);
      }
      else
      {
        //Nem o primeiro e nem o segundo index é uma vírgula (somente com uma entrada de string, sem virgula) - Caso impossível pois o vetor sempre tem virgula
      }
    }
  }
}

//Cria os Arrays com os vetores de Pick
for($i=0;$i<count($vetorPick);$i++)
{
  //Cria um vetor com os index das virgulas
  $index_das_virgulas = [];
  $index_das_virgulas [0]=0; //O index do inicio
  //Acha as virgulas
  for($j=0;$j<strlen($vetorPick[$i]);$j++)
  {
    if ($vetorPick[$i][$j]==",")
      {
        //Salva os index do char depois das virgulas
        $index_das_virgulas []=$j;
      }
  }
  $index_das_virgulas []=strlen($vetorPick[$i])-1;//O index do fim

  //Cria o array
  $vetorSalvo = $vetorPick[$i];
  for ($j=0;$j<count($index_das_virgulas)-1;$j++)
  {
    if($vetorSalvo[$index_das_virgulas[$j]]==",")
    {
      //O primeiro index é virgula
      if($vetorSalvo[$index_das_virgulas[$j+1]]==",")
      {
        //O primeiro e segundo index são virgula, adiciona +1 no indexador e tira 1 do tamanho
        $ArrayPick[$i][$j]=substr($vetorSalvo,$index_das_virgulas[$j]+1,$index_das_virgulas[$j+1]-$index_das_virgulas[$j]-1);
      }
      else
      {
        //Só o primeiro index é virgula, adiciona +1 no indexador
        $ArrayPick[$i][$j]=substr($vetorSalvo,$index_das_virgulas[$j]+1,$index_das_virgulas[$j+1]-$index_das_virgulas[$j]);
      }
    }
    else
    {
      //O primeiro index não é virgula
      if($vetorSalvo[$index_das_virgulas[$j+1]]==",")
      {
        //O segundo index é uma vírgula,não muda em nada o tamanho ou index
        $ArrayPick[$i][$j]=substr($vetorSalvo,$index_das_virgulas[$j],$index_das_virgulas[$j+1]-$index_das_virgulas[$j]);
      }
      else
      {
        //Nem o primeiro e nem o segundo index é uma vírgula (somente com uma entrada de string, sem virgula) - Caso impossível pois o vetor sempre tem virgula
      }
    }
  }
}

/*echo "<br> ArrayBan = " ;
print_r($ArrayBan);
echo "<br> ArrayPick = " ;
print_r($ArrayPick);
echo "<br>";*/

//---------------------------------------
//Procura os Nomes e Avatares dos usuários
//---------------------------------------
for ($i=0;$i<count($User);$i++)
{
  //Procura de termo
  $sql = "SELECT Nome, Avatar FROM user_list WHERE User = '".$User[$i]."';";
  //echo $sql."<br>";
  $result = $BancoDeDados->query($sql);
  if ($result->num_rows > 0) 
  {
    // output data of each row
    //while($row = $result->fetch_assoc()) //Outra maneira de escrever o while
    while($row = mysqli_fetch_array($result)) 
    {
      $Nome[] = $row["Nome"];
      $Avatar[] = $row["Avatar"];
    }
  } 
  else 
  {
    echo "0 results";
  }
}

/*echo "<br> Nome = " ;
print_r($Nome);
echo "<br> Avatar = " ;
print_r($Avatar);
echo "<br>";*/

//---------------------------------------
//Cria os Dados dos jogadores e envia pro site
//---------------------------------------
for ($i=0;$i<count($User);$i++)
{
  $Banco_de_Dados_Recebido[$i]=['User' => $User[$i], 'Nome' => $Nome[$i], 'Avatar' => $Avatar[$i],'Ban'=>$ArrayBan[$i],'Pick'=>$ArrayPick[$i] ];
}
/*echo "<br>";
print_r($Banco_de_Dados_Recebido);*/
$Banco_de_Dados_Recebido_Em_JSON = json_encode($Banco_de_Dados_Recebido);

echo $Banco_de_Dados_Recebido_Em_JSON;

//---------------------------------------
//Termino de Conexão
//---------------------------------------
$BancoDeDados->close();

?>
