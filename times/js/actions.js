var global_esquerda;
var global_direita;   
var gols;
var global_jogador;
var ul_atual;

$(document).ready(function () 
{
    $("#envia_gol").click(function(){envia_gol("gol")})
    $("#envia_assist").click(function(){envia_gol("assist")})
    $("#atualiza").click(function(){envia_times("atualiza")})
})

function envia_times(evento)
{    

    $.post("../acoes.php",
           {video: "teste", momento: "momento", radio_duracao: "radio_duracao", radio_campo: "radio_campo", jogada:"jogada", craque: "craque", equipe: "equipe"},
           function(data){} )
}