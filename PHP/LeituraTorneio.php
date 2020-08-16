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
$CodigoTorneio = htmlspecialchars($_POST["CodigoTorneio"]);

//---------------------------------------
//Procura de termo
//---------------------------------------

$sql = "SELECT DISTINCT CodigoTorneio FROM torneios WHERE CodigoTorneio LIKE '".$CodigoTorneio."';";
//echo $sql;

$result = $BancoDeDados->query($sql);

if ($result->num_rows > 0) 
{
    //Existe Resultado de Torneio
    echo "<script>alert('Torneio encontrado');</script>";

    //---------------------------------------
    //Redirecionamento em JavaScript
    //---------------------------------------
    echo "<script>window.location='http://100.66.96.91:8080/PickBan.html?CodigoTorneio=$CodigoTorneio';</script>";
}
else 
{
    //Sem resultado de Torneio novo
    echo "<script>alert('Torneio Não Cadastrado');</script>";
    
    //---------------------------------------
    //Redirecionamento em JavaScript
    //---------------------------------------
    echo "<script>window.location='http://100.66.96.91:8080/index.html';</script>";
}

//---------------------------------------
//Termino de Conexão
//---------------------------------------
$BancoDeDados->close();

?>