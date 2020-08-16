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
//Procura o valor do $indexPickBan e $vetorPickBan no servidor
//---------------------------------------

//Procura de termo
$sql = "SELECT indexPickBan, vetorPickBan FROM vetores_torneio WHERE CodigoTorneio='".$CodigoTorneio."';";
//echo $sql."<br>";
$result = $BancoDeDados->query($sql);

while($row = mysqli_fetch_array($result)) 
{
  //echo "Gen = ".$row["Gen"]." indexPickBan = ".$row["indexPickBan"]." VetorPickBan = ".$row["VetorPickBan"]."<br>"; //Mostrar os dados
  $Banco_de_Dados_Recebido = ['indexPickBan'=>$row["indexPickBan"], 'VetorPickBan'=>$row["vetorPickBan"]];
}
/*print_r($Banco_de_Dados_Recebido);
echo "<br>";*/

echo "Valores anteriores<br>";

// Criando $indexPickBan
$indexPickBan = $Banco_de_Dados_Recebido['indexPickBan'];
echo "indexPickBan = ".$indexPickBan."<br>";

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
echo "VetorPickBan = ";
print_r ($VetorPickBan);
echo "<br>";

//---------------------------------------
//Atualiza o valor do $indexPickBan e $vetorPickBan no servidor
//---------------------------------------
//Atualiza o $indexPickBan
//confere se é necessário aumentar ou diminuir o vetor
echo "<br>Operações<br>";

if (htmlspecialchars($_GET["Operacao"])=="INCREMENTO")
{
    echo "indexPickBan++<br>";
    $indexPickBan++;
}
elseif (htmlspecialchars($_GET["Operacao"])=="DECREMENTO") 
{
    if($indexPickBan>0)
    {
        echo "indexPickBan--<br>";
        $indexPickBan--;
    }
    
}
else
{
    echo "<br>GIRLLLL, NOT HERE HACKER<br>";
}

//Atualiza o $vetorPickBan
//confere se o $vetorPickBan é o inicial (=0)
if (count($VetorPickBan)==1)
{
    if ($VetorPickBan[0]==0)
    {
        //Vetor Zerado
        if(htmlspecialchars($_GET["Operacao"])=="INCREMENTO") 
        {
            echo "Novo Pick/Ban - Novo Valor = ".$_GET["CodigoPokemon"]."<br>";
            $VetorPickBan[0] = $_GET["CodigoPokemon"]; //Adiciona o primeiro código
        }
    }
    else
    {
        //Vetor já possui um novo código
        if(htmlspecialchars($_GET["Operacao"])=="DECREMENTO") 
        {
            //Limpar o pick anterior
            echo "Limpeza do Pick/Ban Inicial - Novo Valor = 0<br>";
            $VetorPickBan[count($VetorPickBan)-1] = 0; //Limpa o primeiro código
        }
        else
        {
            //Adicionar o novo código
            echo "Novo Pick/Ban - Novo Valor = ".$_GET["CodigoPokemon"]."<br>";
            $VetorPickBan[count($VetorPickBan)] = $_GET["CodigoPokemon"]; //Adiciona o segundo código
        }        
    }
}
else
{
    //Vetor já possui um novo código
    if(htmlspecialchars($_GET["Operacao"])=="DECREMENTO") 
    {
        //Limpar o pick anterior
        echo "Limpeza do Pick/Ban Anterior - Deletado último elemento<br>";
        unset($VetorPickBan[count($VetorPickBan)-1]); //Deleta o ultimo elemento do $VetorPickBan
    }
    else
    {
        //Adicionar o novo código
        echo "Novo Pick/Ban - Novo Valor = ".$_GET["CodigoPokemon"]."<br>";
        $VetorPickBan[count($VetorPickBan)] = $_GET["CodigoPokemon"]; //Adiciona o novo código
    }  
}
//Montagem do String para o servidor
$VetorPickBanEnviado = "";
for($i=0;$i<count($VetorPickBan);$i++)
{
    if($i==count($VetorPickBan)-1)
    {
        //Ultimo index, então tira a virgula
        $VetorPickBanEnviado = $VetorPickBanEnviado.$VetorPickBan[$i];
    }
    else
    {
        $VetorPickBanEnviado = $VetorPickBanEnviado.$VetorPickBan[$i].",";
    }
    
}

echo "<br>Valores atualizados<br>";
echo "indexPickBan = ".$indexPickBan."<br>";
echo "VetorPickBan = ";
print_r ($VetorPickBan);
echo "<br>";
//Procura de termo
$sql = "UPDATE vetores_torneio SET indexPickBan='".$indexPickBan."', vetorPickBan='".$VetorPickBanEnviado."' WHERE CodigoTorneio='".$_GET["CodigoTorneio"]."'";
//echo $sql;
$result = $BancoDeDados->query($sql);

//---------------------------------------
//Termino de Conexão
//---------------------------------------
$BancoDeDados->close();

?>
