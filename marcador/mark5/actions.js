var global_esquerda;
var global_direita;   
var gols;
var global_jogador;
var global_nome_jogador;
var ul_atual;

$(document).ready(function () 
{
    $("#envia_gol").click(function(){envia("1")})
    $("#envia_falta").click(function(){envia("0")})
    $("#envia_amarelo").click(function(){envia("2")})
    $("#envia_vermelho").click(function(){envia("3")})
    $("#envia_contra").click(function(){envia("4")})
    $("#envia_defesa").click(function(){envia("3")})
    $("#envia_campo").click(function(){envia("8")})
    $("#envia_banco").click(function(){envia("9")})
    $("#atualiza").click(function(){envia_times("atualiza")})
})
    
 function time_esquerda(select)
{
    var option = select.options[select.selectedIndex];
    var ul = select.parentNode.getElementsByTagName('ul')[0];

    global_esquerda = ul.getElementsByTagName('input');
    
    for (var i = 0; i < global_esquerda.length; i++)
    if (global_esquerda[i].value == option.value)
      return;

    var li = document.createElement('li');
    var input = document.createElement('input');
    var text = document.createTextNode(option.firstChild.data);
    input.value = option.value;
   
    input.type = 'hidden';
    input.name = 'time_esquerda[]';
    li.setAttribute('value', option.value); 
    li.setAttribute('id', option.value); 

    li.setAttribute('onclick', 'selecionar_jogador("'+option.value+'")');     
    li.appendChild(input);
    li.appendChild(text);
    ul.appendChild(li);
}
        
 function time_direita(select)
{
    var option = select.options[select.selectedIndex];
    var ul = select.parentNode.getElementsByTagName('ul')[0];

    global_direita = ul.getElementsByTagName('input');
    
    for (var i = 0; i < global_direita.length; i++)
    if (global_direita[i].value == option.value)
      return;

    var li = document.createElement('li');
    var input = document.createElement('input');
    var text = document.createTextNode(option.firstChild.data);
    input.value = option.value;
    
    input.type = 'hidden';
    input.name = 'time_direita[]';
    li.setAttribute('value', option.value); 
    li.setAttribute('id', option.value); 

    li.setAttribute('onclick', 'selecionar_jogador("'+option.value+'")');     
    li.appendChild(input);
    li.appendChild(text);
    ul.appendChild(li);
}

function selecionar_jogador(ojogador){
    global_jogador = ojogador;
    li = document.getElementById(ojogador);    
    global_nome_jogador = document.getElementById(ojogador).textContent;
    document.getElementsByClassName('modal-title')[0].innerHTML = (global_nome_jogador);
    li.setAttribute('data-target', '#myModal');      
    li.setAttribute('data-toggle', 'modal'); 
    remover = document.getElementById("remover");
    ul_atual = li.parentNode;
    //remover.setAttribute('onclick', 'document.getElementById("'+ojogador+'").parentNode.removeChild(document.getElementById("'+ojogador+'"));');  
}



function envia_times(evento)
{    

    ftime_esq = "";
    ftime_dir = "";
    fequipe_gol = "";
    console.log(evento)
    var i;
    
    if (undefined != global_esquerda){
        for (i = 0; i < global_esquerda.length; i++) {
            ftime_esq = ftime_esq + global_esquerda[i].value + ",";
        }
    }
    
    if (undefined != global_esquerda){
        for (i = 0; i < global_direita.length; i++) {
            ftime_dir = ftime_dir +  global_direita[i].value + ",";
        }
    }
    
    if (undefined != gols){
        for (i = 0; i < gols.length; i++) {
            fequipe_gol = fequipe_gol +  gols[i].value + ",";
        }
    }
        
    fevento = evento;
    
    $.post("times.php",
           {evento: fevento, time_dir: ftime_dir, time_esq: ftime_esq, equipe_gol: fequipe_gol},
           function(data)
           {
             //  if (data == 1)
               //{
                    // remove a classe css sucess da div
                  //  $("#d").removeClass("sucess")
                    // adiciona a classe error da div 
                   // $("#d").addClass("error")
                    // insere na div o conteudo/mensagem de erro
                   // $("#d").html("Selecione o time!")
               // }
               // else{
                    // se nao retornou 1 entao os dados foram enviados
                    // remove a classe error da div
                    $("#d").removeClass("error");
                    // adiciona a classe sucess na div 
                    $("#d").addClass("sucess");
                    // insere o conteudo vindo do data.php na div
                    $("#d").html(data);
                    console.log(data);
                //}
                // torna a div invisivel
                $("#d").css("display","none");
                // torna a div visivel usando o efeito show com a slow de parametro
                $("#d").show("slow");
            }
      )
}

function envia(p_type)
{    
        
    fjogador = global_jogador;
    fnome = global_nome_jogador;
    fid = global_id;
    
    $.post("acoes.php",
           {acao:"marcar", type: p_type, player: fjogador, match:fid, field:0, side:0, nome:fnome},
           function(data)
           {
                // se nao retornou 1 entao os dados foram enviados
                // remove a classe error da div
                $("#d").removeClass("error");
                // adiciona a classe sucess na div 
                $("#d").addClass("sucess");
                // insere o conteudo vindo do data.php na div
                $("#d").html(data);
                console.log(data);
                //}
                // torna a div invisivel
                $("#d").css("display","none");
                // torna a div visivel usando o efeito show com a slow de parametro
                $("#d").show("slow");
            }
      )
}