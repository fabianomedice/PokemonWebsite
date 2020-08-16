# PokemonWebsite - http://fabianomedice.myartsonline.com/TorneioPokemon.html
Desafio: Criar um site de pick e ban para torneio de pokemon sem utilizar nenhum template, seja ele wordpress ou bootstrap
<br>
Códigos para o site de Torneio de Pokemon <br>
Eles estão para Wamp Server. Deve se atualizar o ip e senha para o servidor <br>
<br>
O banco de dados deve conter: <br> 
<br>
Tabela 1: "pokemon_list"<br>
Arquivo: "Banco de Dados Pokemon.xlsx" para adicionar esse banco de dados. <br>
13 Colunas:<br>
-"Generation" - tipo: int(11) <br>
-"Pokedex" - tipo: int(11) <br>
-"Codigo" - tipo: text	utf8mb4_unicode_ci <br>
-"Nome" - tipo: text	utf8mb4_unicode_ci <br>
-"TierGen1" - tipo: <br>
-"TierGen2" - tipo: int(11) <br>
-"TierGen3" - tipo: int(11) <br>
-"TierGen4" - tipo: int(11) <br>
-"TierGen5" - tipo: int(11) <br>
-"TierGen6" - tipo: int(11) <br>
-"TierGen7" - tipo: int(11) <br>
-"StatusPick" - tipo: text	utf8mb4_unicode_ci <br>
-"Imagem" - tipo: text	utf8mb4_unicode_ci <br>
<br>
Tabela 2: "torneios"<br>
6 Colunas:<br>
-"CodigoTorneio" - tipo: text utf8mb4_unicode_ci <br>
-"Generation" - tipo: int(11) <br>
-"User" - tipo: text utf8mb4_unicode_ci <br>
-"OrdemPickBan" - tipo: int(11) <br>
-"Ban" - tipo: text utf8mb4_unicode_ci <br>
-"Pick" - tipo: text utf8mb4_unicode_ci <br>
<br>
Tabela 3: "user_list"<br>
4 Colunas:<br>
-"User" - tipo: text utf8mb4_unicode_ci <br>
-"Nome" - tipo: text utf8mb4_unicode_ci <br>
-"Avatar" - tipo: text utf8mb4_unicode_ci <br>
-"Torneios" - tipo: text utf8mb4_unicode_ci <br>
<br>
Tabela 4: "vetores_torneio"<br>
4 Colunas:<br>
-"CodigoTorneio" - tipo: text utf8mb4_unicode_ci <br>
-"Gen" - tipo: int(11) <br>
-"indexPickBan" - tipo: int(11) <br>
-"vetorPickBan" - tipo: text utf8mb4_unicode_ci <br>
<br>
