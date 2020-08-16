// -------------------------------------------------------
//Função para mudança de status de pick/ban
// -------------------------------------------------------
function MudancaPickBan(Index)
{
    //confere se o pokemon anterior já foi escolhido
    var JaEscolhido=false; //reseta toda vez q chama a função
    for (i=0;i<=$indexPickBan;i++)
    {
        //procura dentro do vetorPickBan se o index enviado já foi escolhido antes
        if($vetorPickBan[i]==$Pokemon_List.Dados[Index].Pokedex)
        {
            //se achou
            JaEscolhido=true;
        }
    }

    //Já escolhido, o status não muda
    if(JaEscolhido)
    {
        //confere se não é o último a ser escolhido
        if($vetorPickBan[$indexPickBan-1]==$Pokemon_List.Dados[Index].Pokedex)
        {
            //se for, o status muda junto com a retirada dele do vetor
            //$Pokemon_List.Dados[Index].StatusPick = !$Pokemon_List.Dados[Index].StatusPick;
            Mudar_Status_Banco_de_Dados($Pokemon_List.Dados[Index].Pokedex,!$Pokemon_List.Dados[Index].StatusPick);
        }

    }
    else
    {
        //status de pick no banco de dados muda
        //$Pokemon_List.Dados[Index].StatusPick = !$Pokemon_List.Dados[Index].StatusPick;
        Mudar_Status_Banco_de_Dados($Pokemon_List.Dados[Index].Pokedex,!$Pokemon_List.Dados[Index].StatusPick);
    }
    
    //Conferer o status no banco de dados e muda de acordo com ele
    if ($Pokemon_List.Dados[Index].StatusPick)
    {
        document.getElementById('Dex'+$Pokemon_List.Dados[Index].Pokedex).style.filter = "grayscale(1)";
    }
    else
        document.getElementById('Dex'+$Pokemon_List.Dados[Index].Pokedex).style.filter = "grayscale(0)";		
}

// -------------------------------------------------------
// Função para criação dos botões de cada seção
// -------------------------------------------------------
function Criar_Botoes(Valor_Tier_Selecionado)
{
    //Atualiza o Tier no site
    document.getElementById("Titulo").innerHTML = "Escolhas do Tier "+Valor_Tier_Selecionado;

    if(Valor_Tier_Selecionado==undefined)
    {
        document.getElementById("Titulo").innerHTML = "Termino do Pick e Ban";
    }

    //Faz a criação dos botões
    Tamanho_Banco_de_Dados = $Pokemon_List.Dados.length;

    for (j = 1; j<=7; j++)
    {
        //Criação do texto dos botões da Gens
        var Texto_Botoes = ""; // limpa a cada novo ciclo
        var Primeiro_Botao = 0; // limpa a cada novo ciclo
        for (i = 0; i<Tamanho_Banco_de_Dados ; i++)	
        {
            if($Pokemon_List.Dados[i].Tier==Valor_Tier_Selecionado)
            {
                if($Pokemon_List.Dados[i].Generation==j)
                {
                    if(Primeiro_Botao==0)
                    {
// dois onclick events - onclick="Display1();Display2()"
                        //Confere se o botão já foi apertado antes e se sim, coloca o filtro
                        if($Pokemon_List.Dados[i].StatusPick)
                        {
                            Texto_Botoes = '<button onclick="MudancaPickBan('+i+');ListaPickBan('+i+')">'+
                                '<img id=Dex'+$Pokemon_List.Dados[i].Pokedex+' src='+$Pokemon_List.Dados[i].Imagem+' alt='+$Pokemon_List.Dados[i].Nome+' height="100" width="100" style="filter:grayscale(1)">'+
                                '<br>'+$Pokemon_List.Dados[i].Nome+
                            '</button>';
                            Primeiro_Botao++; //Não entra de novo aqui
                        }
                        else
                        {
                            Texto_Botoes = '<button onclick="MudancaPickBan('+i+');ListaPickBan('+i+')">'+
                                '<img id=Dex'+$Pokemon_List.Dados[i].Pokedex+' src='+$Pokemon_List.Dados[i].Imagem+' alt='+$Pokemon_List.Dados[i].Nome+' height="100" width="100">'+
                                '<br>'+$Pokemon_List.Dados[i].Nome+
                            '</button>';
                            Primeiro_Botao++; //Não entra de novo aqui
                        }
                    }
                    else
                    {
                        //Confere se o botão já foi apertado antes e se sim, coloca o filtro
                        if($Pokemon_List.Dados[i].StatusPick)
                        {
                            Texto_Botoes = Texto_Botoes+'<button onclick="MudancaPickBan('+i+');ListaPickBan('+i+')">'+
                                '<img id=Dex'+$Pokemon_List.Dados[i].Pokedex+' src='+$Pokemon_List.Dados[i].Imagem+' alt='+$Pokemon_List.Dados[i].Nome+' height="100" width="100" style="filter:grayscale(1)">'+
                                '<br>'+$Pokemon_List.Dados[i].Nome+
                            '</button>';
                        }
                        else
                        {
                            Texto_Botoes = Texto_Botoes+'<button onclick="MudancaPickBan('+i+');ListaPickBan('+i+')">'+
                                '<img id=Dex'+$Pokemon_List.Dados[i].Pokedex+' src='+$Pokemon_List.Dados[i].Imagem+' alt='+$Pokemon_List.Dados[i].Nome+' height="100" width="100">'+
                                '<br>'+$Pokemon_List.Dados[i].Nome+
                            '</button>';
                        }
                    }
                }
            }
        }	
        idGeracao = 'Gen'+j; //identificando os Ids
        switch(j)
        {
            case 1:
                document.getElementById(idGeracao).innerHTML = '<h2 style="text-align:center;">Gen I</h2> <hr>'+Texto_Botoes;
            break;
            case 2:
                document.getElementById(idGeracao).innerHTML = '<h2 style="text-align:center;">Gen II</h2> <hr>'+Texto_Botoes;
            break;
            case 3:
                document.getElementById(idGeracao).innerHTML = '<h2 style="text-align:center;">Gen III</h2> <hr>'+Texto_Botoes;
            break;
            case 4:
                document.getElementById(idGeracao).innerHTML = '<h2 style="text-align:center;">Gen IV</h2> <hr>'+Texto_Botoes;
            break;
            case 5:
                document.getElementById(idGeracao).innerHTML = '<h2 style="text-align:center;">Gen V</h2> <hr>'+Texto_Botoes;
            break;
            case 6:
                document.getElementById(idGeracao).innerHTML = '<h2 style="text-align:center;">Gen VI</h2> <hr>'+Texto_Botoes;
            break;
            case 7:
                document.getElementById(idGeracao).innerHTML = '<h2 style="text-align:center;">Gen VII</h2> <hr>'+Texto_Botoes;
            break;
        }	
    }
}

// -------------------------------------------------------
// Função para criação os jogadores no site
// -------------------------------------------------------
function Criar_Jogadores(vetorPlayersUser)
{
    Valor_Num_Jogadores=vetorPlayersUser.length;
    var Texto_Players = ""; // limpa a cada nova chamada

    for (i=1; i<=Valor_Num_Jogadores; i++)
    {	
        for(j=0;j<$Jogadores.Dados.length;j++)
        {
            if (vetorPlayersUser[i-1]==$Jogadores.Dados[j].User)
            {
                Jogador = $Jogadores.Dados[j];
            }
        }

        if(i==1)
        {
            //Primeiro texto
            /*Texto_Players = '<div>'+
                            '<h2>Player '+i+ '</h2>';
                            if(Jogador.Avatar!="None")
                            {
                                Texto_Players=Texto_Players+ '<img src='+Jogador.Avatar+' alt="Imagem Usuário" height="100" width="100">'+
                                '<p><b>'+Jogador.Nome+'</b></p>'+
                                '<p>Ban</p>';
                            }
                            else
                            {
                                Texto_Players=Texto_Players+ '<img src="https://image.flaticon.com/icons/png/512/21/21104.png" alt="Imagem Usuário" height="100" width="100">'+
                                '<p><b>'+Jogador.Nome+'</b></p>'+
                                '<p>Ban</p>';
                            }*/
            Texto_Players = '<div>' +
                                '<div style="float:left;">'+
                                    '<h2>Player '+i+ '</h2>';
                            if(Jogador.Avatar!="None")
                            {
                                    Texto_Players=Texto_Players+ '<img src='+Jogador.Avatar+' alt="Imagem Usuário" height="100" width="100">'+
                                    '<p><b>'+Jogador.Nome+'</b></p>'+
                                '</div>'+
                                '<div style="float:right;">';
                            }
                            else
                            {
                                    Texto_Players=Texto_Players+ '<img src="https://image.flaticon.com/icons/png/512/21/21104.png" alt="Imagem Usuário" height="100" width="100">'+
                                    '<p><b>'+Jogador.Nome+'</b></p>'+
                                '</div>'+
                                '<div style="float:right;">';
                            }                
        }
        else
        {
            /*Texto_Players = Texto_Players+'<div>'+
                            '<h2>Player '+i+ '</h2>';
                            if(Jogador.Avatar!="None")
                            {
                                Texto_Players=Texto_Players+ '<img src='+Jogador.Avatar+' alt="Imagem Usuário" height="100" width="100">'+
                                '<p><b>'+Jogador.Nome+'</b></p>'+
                                '<p>Ban</p>';
                            }
                            else
                            {
                                Texto_Players=Texto_Players+ '<img src="https://image.flaticon.com/icons/png/512/21/21104.png" alt="Imagem Usuário" height="100" width="100">'+
                                '<p><b>'+Jogador.Nome+'</b></p>'+
                                '<p>Ban</p>';
                            }*/
            Texto_Players = Texto_Players+'<div>'+
                                '<div style="float:left;">'+
                                    '<h2>Player '+i+ '</h2>';
                            if(Jogador.Avatar!="None")
                            {
                                Texto_Players=Texto_Players+ '<img src='+Jogador.Avatar+' alt="Imagem Usuário" height="100" width="100">'+
                                    '<p><b>'+Jogador.Nome+'</b></p>'+
                                '</div>'+
                                '<div style="float:right;">';
                            }
                            else
                            {
                                Texto_Players=Texto_Players+ '<img src="https://image.flaticon.com/icons/png/512/21/21104.png" alt="Imagem Usuário" height="100" width="100">'+
                                    '<p><b>'+Jogador.Nome+'</b></p>'+
                                '</div>'+
                                '<div style="float:right;">';
                            }
        }
        Texto_Players = Texto_Players+'<p>Pick</p>';
        //Lista de Pick
        for (j=1;j<=6;j++)
        {
            if(Jogador.Pick[j-1]!=0)
            {
                for(k=0;$Pokemon_List.Dados[k].Pokedex!=Jogador.Pick[j-1];k++)
                {								
                    //Procura qual indice da dex ($Pokemon_List.Dados[k].Pokedex) possui o valor do ban (Jogadores.Dados[i-1].Ban[j-1]). Ao achar, sai do FOR
                }
                Texto_Players = Texto_Players+'<img src='+$Pokemon_List.Dados[k].Imagem+' alt="Imagem Usuário" height="50" width="50" style="border: 1px solid black;">';
            }
            else
            {
                Texto_Players = Texto_Players+'<img src="https://pngimg.com/uploads/pokeball/pokeball_PNG13.png" alt="Imagem Usuário" height="50" width="50" style="border: 1px solid black;">';
            }						
        }
        Texto_Players = Texto_Players+'<p>Ban</p>';
        //Lista de Ban
        for (j=1;j<=$Jogadores.Dados[0].Ban.length;j++)
        {
            if(Jogador.Ban[j-1]!=0)
            {
                for(k=0;$Pokemon_List.Dados[k].Pokedex!=Jogador.Ban[j-1];k++)
                {								
                    //Procura qual indice da dex ($Pokemon_List.Dados[k].Pokedex) possui o valor do ban (Jogadores.Dados[i-1].Ban[j-1]). Ao achar, sai do FOR
                }
                Texto_Players = Texto_Players+'<img src='+$Pokemon_List.Dados[k].Imagem+' alt="Imagem Usuário" height="50" width="50" style="border: 1px solid black;filter: grayscale(1);">';
            }
            else
            {
                Texto_Players = Texto_Players+'<img src="https://pngimg.com/uploads/pokeball/pokeball_PNG13.png" alt="Imagem Usuário" height="50" width="50" style="border: 1px solid black;filter: grayscale(1);">';
            }
            if(j==6||j==12||j==18||j==24)
            {
                //Criado 6 pokebolas de ban antes
                Texto_Players = Texto_Players+'<br>';
            }
        }
        
        /*Texto_Players = Texto_Players+'</div>';*/
        Texto_Players = Texto_Players+'</div></div><br style="clear:both;"/>';
    }
    document.getElementById("ListaPickBan").innerHTML = Texto_Players;
    //console.log(Texto_Players);
}

// -------------------------------------------------------
// Faz o Pick e Ban
// -------------------------------------------------------
function ListaPickBan(Index)
{
    var OperacaoIndex;
    var MesmoBotao = false;
    if ($indexPickBan<=Eventos.Player.length)
    {
        //Somente entra se tiver com index menor que o escolhido
        //Primeiro Ban
        if($indexPickBan==0)
        {
            /*
            $vetorPickBan[$indexPickBan]=$Pokemon_List.Dados[Index].Pokedex;
            $indexPickBan++;
            */
            OperacaoIndex = "INCREMENTO";
            Atualiza_PickBan($CodigoTorneio,"INCREMENTO",$Pokemon_List.Dados[Index].Pokedex);
        }
        else
        {
            //conferir se não é o mesmo botão apertado
            if($vetorPickBan[$indexPickBan-1]==$Pokemon_List.Dados[Index].Pokedex)
            {
                //apertou o mesmo botão
                /*
                $vetorPickBan[$indexPickBan-1]=0; //deleta a dex anterior
                $indexPickBan--; //volta para o anterior
                */
                OperacaoIndex = "DECREMENTO";
                Atualiza_PickBan($CodigoTorneio,"DECREMENTO",$Pokemon_List.Dados[Index].Pokedex);
                MesmoBotao = true;
            }
            else
            {
                //confere se o pokemon anterior já foi escolhido
                var JaEscolhido=false; //reseta toda vez q chama a função
                for (i=0;i<=$indexPickBan;i++)
                {
                    //procura dentro do vetorPickBan se o index enviado já foi escolhido antes
                    if($vetorPickBan[i]==$Pokemon_List.Dados[Index].Pokedex)
                    {
                        //se achou
                        JaEscolhido=true;
                    }
                }
                if(JaEscolhido)
                {
                    alert("Pokemon já escolhido");
                }
                else
                {
                    /*
                    $vetorPickBan[$indexPickBan]=$Pokemon_List.Dados[Index].Pokedex;
                    $indexPickBan++;
                    */
                    OperacaoIndex = "INCREMENTO";
                    Atualiza_PickBan($CodigoTorneio,"INCREMENTO",$Pokemon_List.Dados[Index].Pokedex);
                }
            }
        }
    }
    else
    {
        //------------Seção não funcionando---------------------------------------------------------------
        //se for o ultimo indice, confere se não é o mesmo botão apertado
        if($vetorPickBan[$indexPickBan-1]==$Pokemon_List.Dados[Index].Pokedex)
        {
            //apertou o mesmo botão
            /*
            $vetorPickBan[$indexPickBan-1]=0; //deleta a dex anterior
            $indexPickBan--; //volta para o anterior	
            */
            OperacaoIndex = "DECREMENTO";
            Atualiza_PickBan($CodigoTorneio,"DECREMENTO",$Pokemon_List.Dados[Index].Pokedex);
            MesmoBotao = true;			
        }
        //-------------------------------------------------------------------------------------------------
    }
    
    //Atualiza os status no Banco de Dados dos Jogadores
    if (OperacaoIndex == "INCREMENTO")
    {
        //Index ta com +1
        Numero_Player = (Eventos.Player[$indexPickBan-1]); //acha qual player é o turno
        PlayerUsername = $vetorPlayersUser[Numero_Player-1];//pega o username do player no vetor de jogadores
    }
    else
    {
        //Index ta com -1, ou seja, já voltou ao anterior
        Numero_Player = (Eventos.Player[$indexPickBan]); //acha qual player é o turno
        PlayerUsername = $vetorPlayersUser[Numero_Player-1];//pega o username do player no vetor de jogadores
    }

    //Procura o username no banco de dados
    for(i=0;i<$Jogadores.Dados.length;i++)
    {
        //Ao achar, atualiza
        if(PlayerUsername==$Jogadores.Dados[i].User)
        {
            if (MesmoBotao)
            {
                //Não atualiza, ou seja, limpa o pick

                //.charAt() pega o char da string - (0) - B ou P / (1) - Qual pick ou ban
                //Procura se o evento é "B" de Ban ou "P" de Pick 
                if(Eventos.Situacao[$indexPickBan].charAt(0)=="B")
                {
                    Atualiza_PickBan_Jogadores($CodigoTorneio,$Jogadores.Dados[i].User,Eventos.Situacao[$indexPickBan],0);
                }
                else
                {
                    Atualiza_PickBan_Jogadores($CodigoTorneio,$Jogadores.Dados[i].User,Eventos.Situacao[$indexPickBan],0);                   
                }
                
            }
            else
            {
                if(JaEscolhido)
                {
                    //Não atualiza
                }
                else
                {
                    //.charAt() pega o char da string - (0) - B ou P / (1) - Qual pick ou ban
                    //Procura se o evento é "B" de Ban ou "P" de Pick 
                    if(Eventos.Situacao[$indexPickBan-1].charAt(0)=="B")
                    {
                        //$Jogadores.Dados[i].Ban[Eventos.Situacao[$indexPickBan-1].charAt(1)-1] = $Pokemon_List.Dados[Index].Pokedex;
                        Atualiza_PickBan_Jogadores($CodigoTorneio,$Jogadores.Dados[i].User,Eventos.Situacao[$indexPickBan-1],$Pokemon_List.Dados[Index].Pokedex);
                    }
                    else
                    {
                        //$Jogadores.Dados[i].Pick[Eventos.Situacao[$indexPickBan-1].charAt(1)-1] = $Pokemon_List.Dados[Index].Pokedex;
                        Atualiza_PickBan_Jogadores($CodigoTorneio,$Jogadores.Dados[i].User,Eventos.Situacao[$indexPickBan-1],$Pokemon_List.Dados[Index].Pokedex);                   
                    }
                }
                
            }
            
            
        }
    }
    //Chama o Criar_Jogadores para atualizar os valores das pokebolas
    Criar_Jogadores($vetorPlayersUser);
    //Chama o Criar_Jogadores para atualizar os valores dos tiers
    Criar_Botoes(Eventos.Tier[$indexPickBan]);
}

// -------------------------------------------------------
// Cria a ordem dos picks e bans
// -------------------------------------------------------
function Criar_Ordem_Eventos(vetorPlayersUser)
{
    Valor_Num_Jogadores=vetorPlayersUser.length;
    if ($Gen==1)
    {
        //Seleciona a ordem dos eventos do torneio
        switch(Valor_Num_Jogadores)
        {
            case 2:
                Eventos = {
                    Player:[1,2,1,2,2,1,2,1,2,1,1,2,1,2,2,1,2,1,1,2,2,1,2,1,1,2,1,2,1,2,2,1,2,1,1,2,1,2,2,1,1,2,1,2,2,1,2,1],
                    Situacao:["B1","B1","P1","P1","B2","B2","P2","P2","B3","B3","B4","B4","B5","B5","B6","B6","P3","P3","B7","B7","B8","B8","B9","B9","B10","B10","P4","P4","B11","B11","B12","B12","B13","B13","B14","B14","P5","P5","B15","B15","B16","B16","B17","B17","B18","B18","P6","P6"],
                    Tier:[1,1,1,1,1,1,1,1,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,]
                            };
            break;
            case 3:
                Eventos = {
                    Player:[1,2,3,1,2,3,3,2,1,3,2,1,3,1,2,1,3,2,1,3,2,3,1,2,3,1,2,1,3,2,3,1,2,3,1,2,1,3,2,1,3,2,2,1,3,2,3,1,2,3,1,2,1,3,2,1,3,2,3,1,2,1,3,2,1,3,2,3,1,2,3,1],
                    Situacao:["B1","B1","B1","P1","P1","P1","B2","B2","B2","P2","P2","P2","B3","B3","B3","B4","B4","B4","B5","B5","B5","B6","B6","B6","P3","P3","P3","B7","B7","B7","B8","B8","B8","B9","B9","B9","B10","B10","B10","P4","P4","P4","B11","B11","B11","B12","B12","B12","B13","B13","B13","B14","B14","B14","P5","P5","P5","B15","B15","B15","B16","B16","B16","B17","B17","B17","B18","B18","B18","P6","P6","P6"],
                    Tier:[1,1,1,1,1,1,1,1,1,1,1,1,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3]
                            };
            break;
            case 4:
                Eventos = {
                    Player:[1,2,3,4,1,2,3,4,4,3,2,1,3,4,1,2,2,1,4,3,3,4,1,2,2,1,4,3,3,4,1,2,2,1,4,3,4,3,1,2,1,2,4,3,4,3,1,2,1,2,4,3,4,3,1,2,1,2,4,3],
                    Situacao:["B1","B1","B1","B1","P1","P1","P1","P1","P2","P2","P2","P2","B2","B2","B2","B2","B3","B3","B3","B3","P3","P3","P3","P3","B4","B4","B4","B4","B5","B5","B5","B5","P4","P4","P4","P4","B6","B6","B6","B6","B7","B7","B7","B7","P5","P5","P5","P5","B8","B8","B8","B8","B9","B9","B9","B9","P6","P6","P6","P6"],
                    Tier:[1,1,1,1,1,1,1,1,1,1,1,1,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3]
                            };
            break;
            case 5:
                Eventos = {
                    Player:[1,2,3,4,5,1,2,3,4,5,5,4,3,2,1,3,1,4,2,5,2,4,5,1,3,3,1,4,2,5,2,4,5,1,3,3,1,4,2,5,2,4,5,1,3,2,5,4,1,3,1,4,3,5,2,2,5,4,1,3,1,4,3,5,2,2,5,4,1,3,1,4,3,5,2],
                    Situacao:["B1","B1","B1","B1","B1","P1","P1","P1","P1","P1","P2","P2","P2","P2","P2","B2","B2","B2","B2","B2","B3","B3","B3","B3","B3","P3","P3","P3","P3","P3","B4","B4","B4","B4","B4","B5","B5","B5","B5","B5","P4","P4","P4","P4","P4","B6","B6","B6","B6","B6","B7","B7","B7","B7","B7","P5","P5","P5","P5","P5","B8","B8","B8","B8","B8","B9","B9","B9","B9","B9","P6","P6","P6","P6","P6"],
                    Tier:[1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3]
                            };
            break;
            case 6:
                Eventos = {
                    Player:[1,2,3,4,5,6,6,5,4,3,2,1,4,3,6,5,2,1,1,2,5,6,3,4,4,3,6,5,2,1,1,2,5,6,3,4,4,3,6,5,2,1,1,2,5,6,3,4,5,6,1,2,3,4,4,3,2,1,6,5,5,6,1,2,3,4,4,3,2,1,6,5,5,6,1,2,3,4,4,3,2,1,6,5],
                    Situacao:["P1","P1","P1","P1","P1","P1","P2","P2","P2","P2","P2","P2","B2","B2","B2","B2","B2","B2","B3","B3","B3","B3","B3","B3","P3","P3","P3","P3","P3","P3","B4","B4","B4","B4","B4","B4","B5","B5","B5","B5","B5","B5","P4","P4","P4","P4","P4","P4","B6","B6","B6","B6","B6","B6","B7","B7","B7","B7","B7","B7","P5","P5","P5","P5","P5","P5","B8","B8","B8","B8","B8","B8","B9","B9","B9","B9","B9","B9","P6","P6","P6","P6","P6","P6"],
                    Tier:[1,1,1,1,1,1,1,1,1,1,1,1,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3]
                            };
            break;
        }
    }
    else
    {
        //Seleciona a ordem dos eventos do torneio
        switch(Valor_Num_Jogadores)
        {
            case 2:
                Eventos = {
                    Player:[1,2,2,1,2,1,1,2,1,2,2,1,1,2,1,2,2,1,2,1,2,1,1,2,1,2,2,1,2,1,1,2,2,1,2,1,1,2,1,2,1,2,2,1,2,1,1,2,1,2,2,1,1,2,1,2,2,1,2,1],
                    Situacao:["B1","B1","B2","B2","B3","B3","B4","B4","P1","P1","B5","B5","B6","B6","B7","B7","B8","B8","P2","P2","B9","B9","B10","B10","B11","B11","B12","B12","P3","P3","B13","B13","B14","B14","B15","B15","B16","B16","P4","P4","B17","B17","B18","B18","B19","B19","B20","B20","P5","P5","B21","B21","B22","B22","B23","B23","B24","B24","P6","P6"],
                    Tier:[1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3]
                            };
            break;
            case 3:
                Eventos = {
                    Player:[1,2,3,3,2,1,3,2,1,1,2,3,1,2,3,3,2,1,1,2,3,1,2,3,3,2,1,3,2,1,3,1,2,1,3,2,1,3,2,3,1,2,3,1,2,1,3,2,3,1,2,3,1,2,1,3,2,1,3,2,2,1,3,2,3,1,2,3,1,2,1,3,2,1,3,2,3,1,2,1,3,2,1,3,2,3,1,2,3,1],
                    Situacao:["B1","B1","B1","B2","B2","B2","B3","B3","B3","B4","B4","B4","P1","P1","P1","B5","B5","B5","B6","B6","B6","B7","B7","B7","B8","B8","B8","P2","P2","P2","B9","B9","B9","B10","B10","B10","B11","B11","B11","B12","B12","B12","P3","P3","P3","B13","B13","B13","B14","B14","B14","B15","B15","B15","B16","B16","B16","P4","P4","P4","B17","B17","B17","B18","B18","B18","B19","B19","B19","B20","B20","B20","P5","P5","P5","B21","B21","B21","B22","B22","B22","B23","B23","B23","B24","B24","B24","P6","P6","P6"],
                    Tier:[1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3]
                            };
            break;
            case 4:
                Eventos = {
                    Player:[1,2,3,4,4,3,2,1,1,2,3,4,4,3,2,1,1,2,3,4,4,3,2,1,3,4,1,2,2,1,4,3,3,4,1,2,2,1,4,3,3,4,1,2,2,1,4,3,4,3,1,2,1,2,4,3,4,3,1,2,1,2,4,3,4,3,1,2,1,2,4,3],
                    Situacao:["B1","B1","B1","B1","B2","B2","B2","B2","P1","P1","P1","P1","B3","B3","B3","B3","B4","B4","B4","B4","P2","P2","P2","P2","B5","B5","B5","B5","B6","B6","B6","B6","P3","P3","P3","P3","B7","B7","B7","B7","B8","B8","B8","B8","P4","P4","P4","P4","B9","B9","B9","B9","B10","B10","B10","B10","P5","P5","P5","P5","B11","B11","B11","B11","B12","B12","B12","B12","P6","P6","P6","P6"],
                    Tier:[1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3]
                            };
            break;
            case 5:
                Eventos = {
                    Player:[1,2,3,4,5,5,4,3,2,1,1,2,3,4,5,5,4,3,2,1,1,2,3,4,5,5,4,3,2,1,3,1,4,2,5,2,4,5,1,3,3,1,4,2,5,2,4,5,1,3,3,1,4,2,5,2,4,5,1,3,2,5,4,1,3,1,4,3,5,2,2,5,4,1,3,1,4,3,5,2,2,5,4,1,3,1,4,3,5,2],
                    Situacao:["B1","B1","B1","B1","B1","B2","B2","B2","B2","B2","P1","P1","P1","P1","P1","B3","B3","B3","B3","B3","B4","B4","B4","B4","B4","P2","P2","P2","P2","P2","B5","B5","B5","B5","B5","B6","B6","B6","B6","B6","P3","P3","P3","P3","P3","B7","B7","B7","B7","B7","B8","B8","B8","B8","B8","P4","P4","P4","P4","P4","B9","B9","B9","B9","B9","B10","B10","B10","B10","B10","P5","P5","P5","P5","P5","B11","B11","B11","B11","B11","B12","B12","B12","B12","B12","P6","P6","P6","P6","P6"],
                    Tier:[1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3]
                            };
            break;
            case 6:
                Eventos = {
                    Player:[1,2,3,4,5,6,6,5,4,3,2,1,1,2,3,4,5,6,6,5,4,3,2,1,1,2,3,4,5,6,6,5,4,3,2,1,4,3,6,5,2,1,1,2,5,6,3,4,4,3,6,5,2,1,1,2,5,6,3,4,4,3,6,5,2,1,1,2,5,6,3,4,5,6,1,2,3,4,4,3,2,1,6,5,5,6,1,2,3,4,4,3,2,1,6,5,5,6,1,2,3,4,4,3,2,1,6,5],
                    Situacao:["B1","B1","B1","B1","B1","B1","B2","B2","B2","B2","B2","B2","P1","P1","P1","P1","P1","P1","B3","B3","B3","B3","B3","B3","B4","B4","B4","B4","B4","B4","P2","P2","P2","P2","P2","P2","B5","B5","B5","B5","B5","B5","B6","B6","B6","B6","B6","B6","P3","P3","P3","P3","P3","P3","B7","B7","B7","B7","B7","B7","B8","B8","B8","B8","B8","B8","P4","P4","P4","P4","P4","P4","B9","B9","B9","B9","B9","B9","B10","B10","B10","B10","B10","B10","P5","P5","P5","P5","P5","P5","B11","B11","B11","B11","B11","B11","B12","B12","B12","B12","B12","B12","P6","P6","P6","P6","P6","P6"],
                    Tier:[1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3]
                            };
            break;
        }
    }
}

// -------------------------------------------------------
// Chamada do banco de dados da Pokemon List
// -------------------------------------------------------
function Chamar_Banco_de_Dados_Pokemon(Gen) 
{
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() 
    {
        if (this.readyState == 4 && this.status == 200) 
        {
            Dados = JSON.parse(this.responseText);
            $Pokemon_List = {Dados};
        }
    }
    xhttp.open("GET", "PHP/LerPokemonList.php?Gen="+Gen, false); //o false não deixa ser assincrono
    xhttp.send();
}

// -------------------------------------------------------
// Mudança do status do banco de dados da Pokemon List
// -------------------------------------------------------
function Mudar_Status_Banco_de_Dados(Codigo,Status) 
{
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() 
    {
        if (this.readyState == 4 && this.status == 200) 
        {
            //atualiza o banco de dados de pokemon
            Chamar_Banco_de_Dados_Pokemon($Gen);
        }
    }
    xhttp.open("GET", "PHP/EscreverPokemonList.php?Status="+Status+"&Codigo="+Codigo, false); //o false não deixa ser assincrono
    xhttp.send();
}

// -------------------------------------------------------
// Inicializa as informações do site
// -------------------------------------------------------
function Inicializador(CodigoTorneio) 
{
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() 
    {
        if (this.readyState == 4 && this.status == 200) 
        {
            // Inicializa o $vetorPlayersUser, $Gen, $indexPickBan, $vetorPickBan
            DadosRecebidos = JSON.parse(this.responseText);
            
            //$Gen
            $Gen = DadosRecebidos[0].Gen;

            //$indexPickBan
            $indexPickBan =DadosRecebidos[0].indexPickBan;

            //$vetorPlayersUser
            for (i=0;i<DadosRecebidos.length;i++)
            {
                if(DadosRecebidos[i].vetorPlayersUser=="-")
                {
                    //Terminou o vetor
                }
                else
                {
                    $vetorPlayersUser[i]=DadosRecebidos[i].vetorPlayersUser;
                }
            }

            //$vetorPickBan
            for (i=0;i<DadosRecebidos.length;i++)
            {
                if(DadosRecebidos[i].VetorPickBan=="-")
                {
                    //Terminou o vetor
                    break;
                    
                }
                else
                {
                    $vetorPickBan[i]=DadosRecebidos[i].VetorPickBan;
                }
                
            }     
            Criar_Ordem_Eventos($vetorPlayersUser);//cria a ordem de pick e ban

            //Atualiza o valor do torneio e de quem é a vez de jogar
            for(j=0;j<$Jogadores.Dados.length;j++)
            {
                if ($vetorPlayersUser[Eventos.Player[$indexPickBan]-1]==$Jogadores.Dados[j].User)
                {
                    Nome = $Jogadores.Dados[j].Nome;
                }
            }  
            if(Eventos.Situacao[$indexPickBan].charAt(0) == "B")
            {
                Situacao = "Banir o "+Eventos.Situacao[$indexPickBan].substr(1)+" Pokemon";
            }
            else
            {
                Situacao = "Pickar o "+Eventos.Situacao[$indexPickBan].substr(1)+" Pokemon";
            }

            document.getElementById("header").innerHTML =

            '<h1>Torneio Pokemon - Código: '+$CodigoTorneio+'</h1>'+
            '<nav><div id="nav">'+
                '<hr>'+
                '<h2>Navegação por geração</h2>'+
                '<ul style="list-style: none;">'+
                '<li><a href="#Gen1"><b>Gen I</b></a></li>'+
                '<li><a href="#Gen2"><b>Gen II</b></a></li>'+
                '<li><a href="#Gen3"><b>Gen III</b></a></li>'+
                '<li><a href="#Gen4"><b>Gen IV</b></a></li>'+
                '<li><a href="#Gen5"><b>Gen V</b></a></li>'+
                '<li><a href="#Gen6"><b>Gen VI</b></a></li>'+
                '<li><a href="#Gen7"><b>Gen VII</b></a></li>'+
                '</ul>'+
                '<hr>'+
            '</div></nav>'+
            '<h2> Vez do Player '+Eventos.Player[$indexPickBan]+' - '+Nome+' - '+Situacao+'<h2>';
        }
    }
    xhttp.open("GET", "PHP/Inicializador.php?CodigoTorneio="+CodigoTorneio, false); //o false não deixa ser assincrono
    xhttp.send();
}

// -------------------------------------------------------
// Atualiza o $indexPickBan e $vetorPickBan
// -------------------------------------------------------
function Atualiza_PickBan(CodigoTorneio,OperacaoIndexPickBan,CodigoPokemon) 
{
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() 
    {
        if (this.readyState == 4 && this.status == 200) 
        {
            //atualiza o vetor $indexPickBan e $vetorPickBan
            Inicializador(CodigoTorneio);
        }
    }
    xhttp.open("GET", "PHP/AtualizaPickBan.php?CodigoTorneio="+CodigoTorneio+"&Operacao="+OperacaoIndexPickBan+"&CodigoPokemon="+CodigoPokemon, false); //o false não deixa ser assincrono
    xhttp.send();
}

// -------------------------------------------------------
// Chamada do banco de dados de Players
// -------------------------------------------------------
function Chamar_Banco_de_Dados_Players(CodigoTorneio) 
{
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() 
    {
        if (this.readyState == 4 && this.status == 200) 
        {
            Dados = JSON.parse(this.responseText);
            $Jogadores= {Dados};
        }
    }
    xhttp.open("GET", "PHP/LerPlayersList.php?CodigoTorneio="+CodigoTorneio, false); //o false não deixa ser assincrono
    xhttp.send();
}

// -------------------------------------------------------
// Atualiza o $Jogadores.Ban e $Jogadores.Pick 
// -------------------------------------------------------
function Atualiza_PickBan_Jogadores(CodigoTorneio,User,Pick_OU_Ban,CodigoPokemon) 
{
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() 
    {
        if (this.readyState == 4 && this.status == 200) 
        {
            //atualiza o banco de dados de jogadores
            Chamar_Banco_de_Dados_Players(CodigoTorneio);
        }
    }
    xhttp.open("GET", "PHP/AtualizaPickBanJogador.php?CodigoTorneio="+CodigoTorneio+"&User="+User+"&Pick_OU_Ban="+Pick_OU_Ban+"&CodigoPokemon="+CodigoPokemon, false); //o false não deixa ser assincrono
    xhttp.send();
}