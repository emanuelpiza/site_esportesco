<?php
    $id = $_POST['id'];
    $key = $_POST['key'];
    $title = $_POST['title'];
    $tipo = $_POST['tipo'];
    $pagina_nome = "Painel Administrativo";
    $mensagem = "O link abaixo possui a chave de acesso ao Painel Administrativo. Compartilhe esse endereço apenas com outros administradores.";
    $prefixo = "";
    if ($tipo == "campeonato"){
        $pagina = "http://www.esportes.co/times/admincopa.php?key=";
    }else if ($tipo == "time"){
        $pagina = "http://www.esportes.co/times/admintime.php?key=";    
    }else if ($tipo == "jogador"){
        $pagina = "http://www.esportes.co/cadastro/edit_jogador.php?key=";
        $pagina_nome = "Formulário de Edição";
        $mensagem = "O link abaixo possui a chave de acesso ao Formulário de Edição. Acesse para completar as informações de seu perfil.";
        $prefixo = "Perfil de ";
    }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title></title>
  <!-- Designed by https://github.com/kaytcat -->
  <!-- Robot header image designed by Freepik.com -->

  <style type="text/css">
  @import url(http://fonts.googleapis.com/css?family=Droid+Sans);
  @import url(https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css);

  /* Take care of image borders and formatting */

  img {
    max-width: 600px;
    outline: none;
    text-decoration: none;
    -ms-interpolation-mode: bicubic;
  }

  a {
    text-decoration: none;
    border: 0;
    outline: none;
    color: #bbbbbb;
  }

  a img {
    border: none;
  }

  /* General styling */

  td, h1, h2, h3  {
    font-family: Helvetica, Arial, sans-serif;
    font-weight: 400;
  }

  td {
    text-align: center;
  }

  body {
    -webkit-font-smoothing:antialiased;
    -webkit-text-size-adjust:none;
    width: 100%;
    height: 100%;
    color: #37302d;
    background: #ffffff;
    font-size: 16px;
  }

   table {
    border-collapse: collapse !important;
  }

  .headline {
    color: #ffffff;
    font-size: 36px;
  }

 .force-full-width {
  width: 100% !important;
 }

 .force-width-80 {
  width: 80% !important;
 }




  </style>

  <style type="text/css" media="screen">
      @media screen {
         /*Thanks Outlook 2013! http://goo.gl/XLxpyl*/
        td, h1, h2, h3 {
          font-family: 'Droid Sans', 'Helvetica Neue', 'Arial', 'sans-serif' !important;
        }
      }
  </style>

  <style type="text/css" media="only screen and (max-width: 480px)">
    /* Mobile styles */
    @media only screen and (max-width: 480px) {

      table[class="w320"] {
        width: 320px !important;
      }

      td[class="mobile-block"] {
        width: 100% !important;
        display: block !important;
      }


    }
  </style>
</head>
<body class="body" style="padding:0; padding-bottom:30px; margin:0; display:block; background:#ffffff; -webkit-text-size-adjust:none" bgcolor="#ffffff">
<table align="center" cellpadding="0" cellspacing="0" class="force-full-width" height="100%">
  <tr>
    <td align="center" valign="top" bgcolor="#ffffff"  width="100%">
      <center>
        <table style="margin: 0 auto;" cellpadding="0" cellspacing="0" width="600" class="w320">
          <tr>
            <td align="center" valign="top">

                <table style="margin: 0 auto;" cellpadding="0" cellspacing="0" class="force-full-width" style="margin:0 auto;">
                  <tr>
                    <td style="font-size: 30px; text-align:center;">
                      <br>
                        Esportes.Co
                      <br>
                      <br>
                    </td>
                  </tr>
                </table>

                <table style="margin: 0 auto; width:100%;" cellpadding="0" cellspacing="0" class="force-full-width" bgcolor="#4dbfbf">
                  <tr>
                    <td>
                    <br>
                    </td>
                  </tr>
                  <tr>
                    <td class="headline">
                        <?php echo $prefixo.$title; ?> está no ar!
                    </td>
                  </tr>
                  <tr>
                    <td>

                      <center>
                        <table style="margin: 0 auto;" cellpadding="0" cellspacing="0" width="60%">
                          <tr>
                            <td style="color:#187272;">
                            <br>
                                <?php echo $mensagem; ?>
                            <br>
                            <br>
                            </td>
                          </tr>
                        </table>
                      </center>

                    </td>
                  </tr>
                  <tr>
                    <td>
                      <div><!--[if mso]>
                        <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="http://" style="height:50px;v-text-anchor:middle;width:200px;" arcsize="8%" stroke="f" fillcolor="#178f8f">
                          <w:anchorlock/>
                          <center>
                        <![endif]-->
                            <a href="<?php echo $pagina.$key; ?>"
                      style="background-color:#178f8f;border-radius:4px;color:#ffffff;display:inline-block;font-family:Helvetica, Arial, sans-serif;font-size:16px;font-weight:bold;line-height:50px;text-align:center;text-decoration:none;width:200px;-webkit-text-size-adjust:none;"><?php echo $pagina_nome; ?></a>
                        <!--[if mso]>
                          </center>
                        </v:roundrect>
                      <![endif]--></div>
                      <br>
                      <br>
                    </td>
                  </tr>
                </table>

                <table style="margin: 0 auto;" cellpadding="0" cellspacing="0" class="force-full-width" bgcolor="#f5774e">
                  <tr>
                    <td style="background-color:#f5774e; width:100%;">

                    <center>
                      <table style="margin:0 auto;" cellspacing="0" cellpadding="0" class="force-width-80">
                        <tr>
                          <td style="text-align:left; color:#933f24">
                          <br>
                          <br>
                            <span style="color:#ffffff;">Esportes.Company</span> <br>
                            Campinas - SP 
                          </td>
                          <td style="text-align:right; vertical-align:top; color:#933f24">
                          <br>
                          <br>
                            <span style="color:#ffffff;">Id: 00<?php echo $id; ?></span> <br>
                            Abril, 2017
                          </td>
                        </tr>
                      </table>


                      <table style="margin:0 auto;" cellspacing="0" cellpadding="0" class="force-width-80">
                        <tr>
                          <td  class="mobile-block" >
                          <br>
                          <br>

                            <table cellspacing="0" cellpadding="0" class="force-full-width">
                              <tr>
                                <td style="color:#ffffff; background-color:#ac4d2f; padding: 10px 0px;">
                                  Versão Contratada
                                </td>
                              </tr>
                              <tr>
                                <td style="color:#933f24; padding:10px 0px; background-color: #f7a084;">
                                  01 - Sem patrocinadores.
                                </td>
                              </tr>
                            </table>

                            <br>
                          </td>
                        </tr>
                      </table>

                      <table style="margin: 0 auto;" cellspacing="0" cellpadding="0" class="force-width-80">
                        <tr>
                          <td style="text-align:left; color:#933f24;">
                          <br>
                            Obrigado pelo cadastro. Caso queira ajuda para levantar patrocinadores, responda a este email.
                          <br>
                          <br>
                          Emanuel - Esportes.Co
                          <br>
                          <br>
                          <br>
                          </td>
                        </tr>
                      </table>
                        
                    </center>
                    </td>
                  </tr>


                </table>

                <table style="margin: 0 auto; width:100%;" cellpadding="0" cellspacing="0" class="force-full-width" bgcolor="#414141" style="margin: 0 auto">
                  <tr>
                    <td style="background-color:#414141;">
                    <br><a href="https://www.facebook.com/Esportes-Co-295544220637495/" target="_blank" style="color:white;">
                      facebook</a>
                      <br>
                    </td>
                  </tr>
                  <tr>
                    <td style="color:#bbbbbb; font-size:12px;">
                       © 2017 Esportes.Co - Todos os direitos reservados.
                       <br>
                       <br>
                    </td>
                  </tr>
                </table>
            </td>
          </tr>
        </table>
    </center>
    </td>
  </tr>
</table>
</body>
</html>