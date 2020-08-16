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
//Criação do código do torneio
//---------------------------------------

//Procura de termo
$sql = "SELECT DISTINCT CodigoTorneio FROM torneios WHERE CodigoTorneio LIKE '".date("Y.m.d")."%'";
$result = $BancoDeDados->query($sql);

if ($result->num_rows > 0) 
{
    //Existe Resultado de Torneio
    $CodigoTorneio = date("Y.m.d").".".($result->num_rows+1);
}
else 
{
    //Sem resultado de Torneio novo
    $CodigoTorneio = date("Y.m.d").".".($result->num_rows+1);
}

//---------------------------------------
//Cadastramento dos players no torneio (Lista: Torneios)
//---------------------------------------

//Recebimento dos nomes dos Usernames
$NumPlayers = sizeof($_POST)-1; //Todos os jogadores - 1 de Gen

for ($i=1;$i<=$NumPlayers;$i++)
{   
    $Player[$i-1] = htmlspecialchars($_POST["username$i"]);
}

//Criação da ordem aleatória dos picks
$OrdemPickBan = range(1, $NumPlayers); //cria um array de 1 a $NumPlayers
shuffle($OrdemPickBan);

//---------------------------------------
//Resumo dos Dados construídos
//---------------------------------------
echo "Codigo Torneio: ".$CodigoTorneio."<br>";
echo "Geração: ".$_POST["Gen"]."<br>";
echo "Número Jogadores: ".$NumPlayers."<br>";
for ($i=1;$i<=$NumPlayers;$i++)
{   
    echo "Jogador$i: ".$Player[$i-1]." com ordem de Pick ".$OrdemPickBan[$i-1]."<br>";
}


//---------------------------------------
//Envio para Servidor
//---------------------------------------
if ($NumPlayers<=3)
{
    //Até 3 players, são 8 bans por tier
    if($_POST["Gen"]==1)
    {
        //Como só há 15 no tier 1, só da pra ter 1 ban
        $VetorBan = '0,'.// Tier 1
                    '0,0,0,0,0,0,0,0,'.// Tier 2
                    '0,0,0,0,0,0,0,0';// Tier 3
    }
    else
    {
        //Para as outras gens, há no minimo 40
        $VetorBan = '0,0,0,0,0,0,0,0,'.// Tier 1
                    '0,0,0,0,0,0,0,0,'.// Tier 2
                    '0,0,0,0,0,0,0,0';// Tier 3
    }
}
else
{
    if($_POST["Gen"]==1)
    {
        //Como só há 15 no tier 1, só da pra ter 1 ban
        $VetorBan = '0,'.// Tier 1
                    '0,0,0,0,'.// Tier 2
                    '0,0,0,0';// Tier 3
    }
    else
    {
        //Para as outras gens, há no minimo 40
        $VetorBan = '0,0,0,0,'.// Tier 1
                    '0,0,0,0,'.// Tier 2
                    '0,0,0,0';// Tier 3
    }
}

$VetorPick = '0,0,0,0,0,0';
//$sql = "INSERT INTO torneios (CodigoTorneio,Generation,User,OrdemPickBan,Ban,Pick) VALUES ('".$CodigoTorneio."',".$_POST["Gen"].",'".$Player[0]."',".$OrdemPickBan[0].",0,0);";
$sql = "INSERT INTO torneios (CodigoTorneio,Generation,User,OrdemPickBan,Ban,Pick) VALUES";
for ($i=1;$i<=$NumPlayers;$i++)
{   
    $sql = $sql."('".$CodigoTorneio."',".$_POST["Gen"].",'".$Player[$i-1]."',".$OrdemPickBan[$i-1].",'".$VetorBan."','".$VetorPick."')";
    if($i==$NumPlayers)
    {
        //Ultimos valores - insere ; no final
        $sql = $sql.";";
    }
    else
    {
        //Outros valores - insere , no final
        $sql = $sql.",";
    }
}

//echo $sql;
$result = $BancoDeDados->query($sql);

//---------------------------------------
//Cadastramento dos players no banco de dados (Lista: User_List)
//---------------------------------------
echo "<br> Conferir se necessita cadastrar os players<br>";

// Confere se o username existe no banco de dados
for ($i=0;$i<$NumPlayers;$i++)
{   
    $sql = "SELECT DISTINCT User FROM user_list WHERE User = '".$Player[$i]."'";
    //echo $sql."<br>";
    $result = $BancoDeDados->query($sql);
    
    
    if ($result->num_rows > 0) 
    {
        //Existe Resultado
        echo "<br>Existe ".$Player[$i];
        echo "<br>";
        //Cadastra o torneio
        //Busca os torneios anteriores
        $sql = "SELECT DISTINCT Torneios FROM user_list WHERE User = '".$Player[$i]."'";
        //echo $sql."<br>";
        $result = $BancoDeDados->query($sql);
        while($row = mysqli_fetch_array($result)) 
        {
            $Banco_de_Dados_Recebido = ['Torneios'=>$row["Torneios"]];
        }
        if ($Banco_de_Dados_Recebido['Torneios']==0)
        {
            echo "Sem torneios previos<br>";
            $NovoTextoTorneio = $CodigoTorneio;
            //echo $NovoTextoTorneio."<br>";
        }
        else
        {
            echo "Existe torneios previos <br>".$Banco_de_Dados_Recebido['Torneios']."<br>";
            $NovoTextoTorneio = $Banco_de_Dados_Recebido['Torneios']." , ".$CodigoTorneio;
            //echo $NovoTextoTorneio."<br>";
        }
        //Atualiza os torneios do usuário
        $sql = "UPDATE user_list SET Torneios='".$NovoTextoTorneio."' WHERE User = '".$Player[$i]."'";
        //echo $sql."<br>";
        $result = $BancoDeDados->query($sql);
        echo "Novo Torneio Cadastrado<br>";

    }
    else 
    {
        //Sem resultado
        echo"<br>Não Existe ".$Player[$i];
        echo "<br>";
        //Cadastra o usuário
        $Banco_de_Dados_Enviado = ['User'=>$Player[$i], 'Nome'=>$Player[$i], 'Avatar'=>"None", 'Torneios'=>0];
        //print_r($Banco_de_Dados_Enviado);
        //echo "<br>";

        //Adiciona o novo usuário
        $sql = "INSERT INTO user_list (User,Nome,Avatar,Torneios) VALUES"."('".$Banco_de_Dados_Enviado['User']."','".$Banco_de_Dados_Enviado['Nome']."','".$Banco_de_Dados_Enviado['Avatar']."',".$Banco_de_Dados_Enviado['Torneios'].");";
        //$sql = "UPDATE user_list SET Torneios='".$NovoTextoTorneio."' WHERE User = '".$Player[$i]."'";
        //echo $sql."<br>";
        $result = $BancoDeDados->query($sql);

        //Cadastra o torneio
        //Busca os torneios anteriores
        $sql = "SELECT DISTINCT Torneios FROM user_list WHERE User = '".$Player[$i]."'";
        //echo $sql."<br>";
        $result = $BancoDeDados->query($sql);
        while($row = mysqli_fetch_array($result)) 
        {
            $Banco_de_Dados_Recebido = ['Torneios'=>$row["Torneios"]];
        }
        if ($Banco_de_Dados_Recebido['Torneios']==0)
        {
            echo "Sem torneios previos<br>";
            $NovoTextoTorneio = $CodigoTorneio;
            //echo $NovoTextoTorneio."<br>";
        }
        else
        {
            echo "Existe torneios previos <br>".$Banco_de_Dados_Recebido['Torneios']."<br>";
            $NovoTextoTorneio = $Banco_de_Dados_Recebido['Torneios']." , ".$CodigoTorneio;
            //echo $NovoTextoTorneio."<br>";
        }
        //Atualiza os torneios do usuário
        $sql = "UPDATE user_list SET Torneios='".$NovoTextoTorneio."' WHERE User = '".$Player[$i]."'";
        //echo $sql."<br>";
        $result = $BancoDeDados->query($sql);
        echo "Novo Torneio Cadastrado<br>";
    }
} 

//---------------------------------------
//Criação dos vetores do torneio
//---------------------------------------

$sql = "INSERT INTO vetores_torneio (CodigoTorneio,Gen,indexPickBan,vetorPickBan) VALUES('".$CodigoTorneio."',".$_POST["Gen"].",'0',0);";
$result = $BancoDeDados->query($sql);

//---------------------------------------
//Termino de Conexão
//---------------------------------------
$BancoDeDados->close();


//---------------------------------------
//Redirecionamento em PHP
//---------------------------------------
header('Location:http://100.66.96.91:8080/PickBan.html?CodigoTorneio='.$CodigoTorneio);

exit();

?>