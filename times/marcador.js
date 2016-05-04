var global_esquerda;
var global_direita;   
var gols;
var global_jogador;
var ul_atual;

$(document).ready(function () 
{
    
    alert("Hello! I am an alert box!!");
    $("#atualiza").click(function(){envia_times("atualiza")})
})

function envia_times(evento)
{    
    alert("Hello! I am an alert box!!");
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
    
   // $.post("times.php",
   //        {evento: fevento, time_dir: ftime_dir, time_esq: ftime_esq, equipe_gol: fequipe_gol},
   //        function(data)
    //       {
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
 //                   $("#d").removeClass("error");
                    // adiciona a classe sucess na div 
//                   $("#d").addClass("sucess");
                    // insere o conteudo vindo do data.php na div
//                    $("#d").html(data);
  //                  console.log(data);
                //}
                // torna a div invisivel
//                $("#d").css("display","none");
                // torna a div visivel usando o efeito show com a slow de parametro
  //              $("#d").show("slow");
//            }
  //    )
}