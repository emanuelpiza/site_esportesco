
<?php
    header('Content-Type: text/html; charset=utf-8');
    session_start();

    ob_start();
    include('../admin/dbcon/dbcon.php');

	if ( !empty($_POST)) {
      
		//Getting data from request
		$name = mysqli_real_escape_string($mysqli,$_POST['name']);
		$sport = $_POST['sport'];
		$contact_name = mysqli_real_escape_string($mysqli,$_POST['contact_name']);
		$contact_email = mysqli_real_escape_string($mysqli,$_POST['contact_email']);
		$contact_telefone = mysqli_real_escape_string($mysqli,$_POST['contact_telefone']);
		$date_mysql = mysqli_real_escape_string($mysqli,$_POST['datepicker']);
        
        $sql = "INSERT INTO cups (name, sport, date_limit, contact_name, contact_email, contact_telefone, datahora) VALUES ('".$name."', '".$sport."', DATE_ADD(DATE_FORMAT(STR_TO_DATE('".$date_mysql."', '%d/%m/%Y'), '%Y-%m-%d'), INTERVAL 1 DAY), '".$contact_name."', '".$contact_email."', '".$contact_telefone."', NOW());";
        mysqli_query($mysqli, $sql);
        
        $sql_novo = mysqli_query($mysqli,"SELECT id, admin_key from cups order by id DESC limit 1;");
        $novo = mysqli_fetch_assoc($sql_novo);
        $key = $novo['admin_key'];
        $id = $novo['id'];
        
        //EMAIL COM CHAVE
        include ('../admin/PHPMailer_config.php');
        $sUrl = 'http://www.esportes.co/cadastro/template_1.php';
        $params = array('http' => array(
            'method' => 'POST',
        'content' => 'title='.$name.'&key='.$key.'&id='.$id.'&tipo=campeonato'
        ));

        $ctx = stream_context_create($params);
        $fp = @fopen($sUrl, 'rb', false, $ctx);
        if (!$fp)
        {
            throw new Exception("Problem with $sUrl, $php_errormsg");
        }

        $response = @stream_get_contents($fp);
        if ($response === false) 
        {
        throw new Exception("Problem reading data from $sUrl, $php_errormsg");
        }
        $mail->Subject = $name.' já está disponível para acesso! Esportes.Co';
        $mail->Body = $response;
        $mail->addAddress($contact_email, '');     // Add a recipient
        if(!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
           $success = true;
        }
		$mysqli->close();
	}

?>

<!DOCTYPE html>
<html lang="en" content="text/html; charset=utf-8">
<head>
    <link rel="shortcut icon" href="../img/favicon-trophy.ico" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Criar Campeonato - Esportes.Co</title>

    <!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../css/1-col-portfolio.css" rel="stylesheet">
	
	<!-- AdminLTE CSS -->
	<link rel="stylesheet" href="../css/AdminLTE.min.css">
	<link rel="stylesheet" href="../css/_all-skins.min.css">
    
    
    <!-- Sweet Alert -->
    <script src="../js/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/sweetalert.css">

	<!-- Font awesome -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        
    <link href="https://fonts.googleapis.com/css?family=Oleo+Script:400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Teko:400,700" rel="stylesheet">
	<style>
		.image-preview-input {
			position: relative;
			overflow: hidden;
			margin: 0px;    
			color: #333;
			background-color: #fff;
			border-color: #ccc;    
		}
		.image-preview-input input[type=file] {
			position: absolute;
			top: 0;
			right: 0;
			margin: 0;
			padding: 0;
			font-size: 20px;
			cursor: pointer;
			opacity: 0;
			filter: alpha(opacity=0);
		}
		.image-preview-input-title {
			margin-left:2px;
		}
		.im-centered {
			margin: auto;
			max-width: 500px;
		}
        
        /*Contact sectiom*/
        .content-header{
          font-family: 'Oleo Script', cursive;
          color:#73bfc1;
          font-size: 45px;
        }

        .section-content{
          text-align: center;
          padding:5px;

        }
        #contact{
            font-family: 'Teko', sans-serif;
            width: 100%;
            width: 100vw;
            height: 100%;
            color : #fff;    
            margin-bottom: 60px;
        }
        .contact-section{
          padding-top: 40px;
        }
        .contact-section .col-md-6{
          width: 50%;
        }

        .form-line{
          border-right: 1px solid #B29999;
        }

        .form-group{
          margin-top: 10px;
        }
        label{
          font-size: 1.3em;
          line-height: 1em;
          font-weight: normal;
        }
        .form-control{
          font-size: 1.3em;
          color: #080808;
        }
        textarea.form-control {
            height: 135px;
           /* margin-top: px;*/
        }

        .submit{
          font-size: 1.5em;
          float: right;
          width: 150px;
          background-color: transparent;
          color: #fff;

        }
        body{
            background: #3a6186; /* fallback for old browsers */
            background: -webkit-linear-gradient(to left, #3a6186 , #89253e); /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to left, #e74c3c , #e74c3c); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        }

	</style>
	

	
</head>

<body>
    
    <?php 
    if ( !empty($_POST)) {
        echo 
            '<!-- Google Code for Convers&atilde;o site Esportes.Co Conversion Page -->
            <script type="text/javascript">
            /* <![CDATA[ */
            var google_conversion_id = 1011268021;
            var google_conversion_language = "en";
            var google_conversion_format = "3";
            var google_conversion_color = "ffffff";
            var google_conversion_label = "GzU7CN_1jWsQtfOa4gM";
            var google_remarketing_only = false;
            /* ]]> */
            </script>
            <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
            </script>
            <noscript>
            <div style="display:inline;">
            <img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/1011268021/?label=GzU7CN_1jWsQtfOa4gM&amp;guid=ON&amp;script=0"/>
            </div>
            </noscript>';
    }?>
  
        <section id="contact">
            <div class="section-content">
                <h1 class="section-header">Crie seu <span class="content-header wow fadeIn " data-wow-delay="0.2s" data-wow-duration="2s" style="margin-left:-10px;">Campeonato</span></h1>
                <h3>Preencha os campos abaixo para criar um campeonato e começar a receber as inscrições dos times.</h3>
            </div>
            <div class="contact-section">
                <div class="container">
                    <form method="post" role="form"  action="" enctype="multipart/form-data">
                        <div class="col-sm-6">
                             <div class="form-group">
                              <label for="championshipName">Nome</label>
                              <input type="text" class="form-control" id="name" name="name" placeholder="Exemplo: Liga Futsal Rioclarense Masculino" required="true">
                            </div>
                            <div class="form-group">
                                <label for="championshipName">Esporte</label>
                                <select id="sport" name="sport" class="form-control bg-white">
                                    <option value="Indefinida"></option>
                                    <option value='Futebol de Campo'>Futebol de Campo</option>
                                    <option value='Futebol Society'>Futebol Society</option>
                                    <option value='Futebol de Salão'>Futsal</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Último dia para inscrições:</label><br>
                                <input id="datepicker" style="color:#555;" class="form-control" name="datepicker" type="text" placeholder="DD/MM/AAAA" required="true"/>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                              <label for="contact">Organizador</label>
                              <div class="input-group">
                                  <span class="input-group-addon"> <i class="fa fa-user" style="width:15px;"></i></span>
                                  <input type="contact_name" name="contact_name" id="contact_name" class="form-control" id="exampleInputEmail1" placeholder="Nome" required="true">
                              </div>                                   
                              <div class="input-group">
                                  <span class="input-group-addon">
                                    <i class="fa fa-envelope"  style="width:15px;"></i></span>
                                  <input type="contact_email" name="contact_email" id="email" class="form-control" id="exampleInputEmail1" placeholder="Email" required="true">
                              </div>
                              <div class="input-group">
                                  <div class="input-group-addon">
                                     <i class="fa fa-phone"  style="width:15px;"></i>
                                  </div>
                                  <input type="text" name="contact_telefone" id="contact_telefone" placeholder="Telefone" class="form-control" data-inputmask='"mask": "(99) 99999-9999"' data-mask required="true">
                                </div>
                            </div>
                             <div class="form-group">
                                <label for="size" style="font-size:18px;">Li e concordo com os <a href="../termos.php" target="_blank" style="color:#73bfc1;">Termos de Uso</a>. </label>
                                <input type="hidden" name="checkbox_aceite" value="0" />
                                <input type="checkbox" name="checkbox_aceite" value="1" required="true"/>
                            </div> 
                            <button type="submit" class="btn btn-default submit">Criar<i class="fa fa-trophy" aria-hidden="true" style="margin-left:20px;"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </section> 
    <?php if ($success == true) {
        echo '
            <script type="text/javascript">
                swal({
                    title: "Campeonato Criado!",
                    text: "Um email foi enviado com o link de acesso. Clique abaixo para acessar o Painel Administrativo.",
                    type: "success",
                    showCancelButton: false,
                    closeOnConfirm: false
                    },
                    function(){
                        window.location.replace("../times/admincopa.php?key='.$key.'");
                    });
            </script>';
    }?>
    <!-- jQuery -->
    <script src="../js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../js/bootstrap.min.js"></script>
    
	<!-- bootstrap time picker -->
	<script src="../plugins/timepicker/bootstrap-timepicker.min.js"></script>
	
	<!-- InputMask -->
	<script src="../plugins/input-mask/jquery.inputmask.js"></script>
	<script src="../plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
	<script src="../plugins/input-mask/jquery.inputmask.extensions.js"></script>
	<script>

		$(function() {
            $("#datepicker").inputmask("99/99/9999",{ "placeholder": "DD/MM/AAAA" });
         
			// Create the close button
			var closebtn = $('<button/>', {
				type:"button",
				text: 'x',
				id: 'close-preview',
				style: 'font-size: initial;',
			});
			closebtn.attr("class","close pull-right");
			// Set the popover default content
			$('.image-preview').popover({
				trigger:'manual',
				html:true,
				title: "<strong>Preview</strong>"+$(closebtn)[0].outerHTML,
				content: "There's no image",
				placement:'bottom'
			});
			// Clear event
			$('.image-preview-clear').click(function(){
				$('.image-preview').attr("data-content","").popover('hide');
				$('.image-preview-filename').val("");
				$('.image-preview-clear').hide();
				$('.image-preview-input input:file').val("");
				$(".image-preview-input-title").text("Buscar"); 
			}); 
			// Create the preview image
			$(".image-preview-input input:file").change(function (){     
				var img = $('<img/>', {
					id: 'dynamic',
					width:250,
					height:200
				});      
				var file = this.files[0];
				var reader = new FileReader();
				// Set preview image into the popover data-content
				reader.onload = function (e) {
					$(".image-preview-input-title").text("Trocar");
					$(".image-preview-clear").show();
					$(".image-preview-filename").val(file.name);            
					img.attr('src', e.target.result);
					$(".image-preview").attr("data-content",$(img)[0].outerHTML).popover("show");
				}        
				reader.readAsDataURL(file);
			});  
		});
    </script>
	
</body>

</html>