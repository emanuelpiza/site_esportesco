<?php

    # Evita o armazenamento em Cache
    @header("Cache-Control: no-cache, must-revalidate");  
    @header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");  
	
	$renderMessage = false;

    $id = $_GET['id'];
    $servername = "localhost";
    $username = "root";
    $password = "k1llersql";
    $dbname = "Esportes";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    $conn->query("SET NAMES 'utf8'");
    mb_language('uni'); 
    mb_internal_encoding('UTF-8');

    //Comecei a fazer mas não usei o nome do time. Não é primordial.
    $sqlteam_name = mysqli_query($mysqli,"SELECT teams_name FROM teams where id_teams = '$id'");
    $team_name = mysqli_fetch_assoc($sqlteam_name)['teams_name'];

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
	
	if ( !empty($_POST)) {

        $rand = rand();
        
        
		$target_dir = "../times/img/jogadores/";
        
        $target_file_bd = $rand . basename($_FILES["image"]["name"]);
		$target_file = $target_dir . $target_file_bd;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		
		move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

		
		//Getting data from request
		$name = $_POST['name'];
		$rg = $_POST['rg'];
		$cpf = $_POST['cpf'];
		$image = $target_file_bd;
		$contact_name = $_POST['contact_name'];
		$contact_email = $_POST['contact_email'] ;
		$contact_telefone = $_POST['contact_telefone'];  
        $date = str_replace('/', '-', $_POST['datepicker']);
        $birthdate = date('Y-m-d', strtotime($date));
         
		//SQL
        $sql = "INSERT INTO `players` (players_team_id, players_name, player_picture, rg, cpf, birthdate, email, phone, name_responsible) VALUES ('".$id."', '".$name."', '".$image."', '".$rg."', '".$cpf."', '".$birthdate."', '".$contact_email."', '".$contact_telefone."', '".$contact_name."');";
        
		mysqli_query($conn, $sql);
		//$stmt->close();
		$conn->close();
	
		$renderMessage = true;
	}

?>

<!DOCTYPE html>
<html lang="en" content="text/html; charset=utf-8">


<head>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Novo Jogador <?php echo $team_name; ?> - Esportes.Co</title>

    <!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../css/1-col-portfolio.css" rel="stylesheet">
	
	<!-- AdminLTE CSS -->
	<link rel="stylesheet" href="../css/AdminLTE.min.css">
	<link rel="stylesheet" href="../css/_all-skins.min.css">

	<!-- Font awesome -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	
	<!-- bootstrap datepicker -->
    <link rel="stylesheet" href="../plugins/datepicker/datepicker3.css">

	<!-- Bootstrap time Picker -->
    <link rel="stylesheet" href="../plugins/timepicker/bootstrap-timepicker.min.css">
	
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

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
	</style>
	

	
</head>

<body style="background-color: #ecf0f5;">
    
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
  
    <div class="container" >

		<!-- Form -->
		<!-- <div class="im-centered"> -->
		
			<div class="row">
				<div class="col-lg-offset-1 col-lg-10" > 
					
					<div class="box box-primary">
						<div class="box-header with-border">
						  <h1 class="box-title">Novo Jogador <?php echo $team_name; ?></h1>
						</div>
						
						<?php 
							if ($renderMessage) {
								echo '<div class="alert alert-success alert-dismissible">
										<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
										<h4><i class="icon fa fa-check"></i>Jogador cadastrado com sucesso!</h4>
									  </div>';
								
							}
						?>

						<form method="post" role="form"  action="" enctype="multipart/form-data">
							<div class="box-body">
								                         
                               
								<div class="form-group">
								  <label for="name">Nome *</label>
								  <input type="text" class="form-control" id="name" name="name" required="true">
								</div>
                                
                                <div class="form-group">
								  <label for="group">RG</label>
								  <input type="text" class="form-control" id="rg" name="rg">
								</div>
                                
                                <div class="form-group">
								  <label for="group">CPF</label>
								  <input type="text" class="form-control" id="cpf" name="cpf" >
								</div>
                                
                                <div class="form-group">
								  <label for="group">Data de Nascimento</label><br>
								    <input id="datepicker" size="40" name="datepicker" type="text" />
								</div>
                                
                                <div class="form-group">
									<label>Foto .JPG 150px x 200px </label>
									<div class="input-group image-preview">
										<input type="text" class="form-control image-preview-filename" disabled="disabled"> <!-- don't give a name === doesn't send on POST/GET -->
										<span class="input-group-btn">
											<!-- image-preview-clear button -->
											<button type="button" class="btn btn-default image-preview-clear" style="display:none;">
												<span class="glyphicon glyphicon-remove"></span> Remover
											</button>
											<!-- image-preview-input -->
											<div class="btn btn-default image-preview-input">
												<span class="glyphicon glyphicon-folder-open"></span>
												<span class="image-preview-input-title">Buscar</span>
												<input type="file" name="image" id="image" accept="image/png, image/jpeg, image/gif" name="input-file-preview"/> <!-- rename it -->
											</div>
										</span>
									</div>
								</div>
								
                                
								<div class="form-group">
								  <label for="contact">Contatos</label>                 
								  <div class="input-group">
									  <span class="input-group-addon">
										<i class="fa fa-envelope"  style="width:15px;"></i></span>
									  <input type="contact_email" name="contact_email" id="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
								  </div>
								  <div class="input-group">
									  <div class="input-group-addon">
										 <i class="fa fa-phone"  style="width:15px;"></i>
									  </div>
									  <input type="text" name="contact_telefone" id="contact_telefone" placeholder="Telefone" class="form-control" data-inputmask='"mask": "(99) 99999-9999"' data-mask>
									</div>
                                     <div class="input-group">
									  <span class="input-group-addon"> <i class="fa fa-user" style="width:15px;"></i></span>
									  <input type="contact_name" name="contact_name" id="contact_name" class="form-control" id="exampleInputEmail1" placeholder="Nome do Familiar ou Responsável">
								  </div>   
								</div>
								
							</div>
                            <p style="margin-left:10px; margin-top:-20px;">* Campos obrigatórios.</p>
							
							<!-- submit button -->
							<div class="box-footer">
								<button class="btn btn-sm btn-success" type="submit" >Cadastrar</button>
							</div>
						</form> 
					</div>
				</div>
			</div>
        <!-- </div> -->
	</div>
                    

    <!-- jQuery -->
    <script src="../js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../js/bootstrap.min.js"></script>

	<!-- bootstrap datepicker -->
	<script src="../plugins/datepicker/bootstrap-datepicker.js"></script>

	<!-- bootstrap time picker -->
	<script src="../plugins/timepicker/bootstrap-timepicker.min.js"></script>
	
	<!-- InputMask -->
	<script src="../plugins/input-mask/jquery.inputmask.js"></script>
	<script src="../plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
	<script src="../plugins/input-mask/jquery.inputmask.extensions.js"></script>
	
	<script>
		$(function () {

			//Date picker
			$('#datepicker').datepicker({
			  autoclose: true,
			  todayHighlight: true,
			  format: 'dd/mm/yyyy'
			});
			
			//Date picker
			$('#datepicker2').datepicker({
			  autoclose: true,
			  todayHighlight: true,
			  format: 'dd/mm/yyyy'
			});

			//Timepicker
			$(".timepicker").timepicker({
			  showInputs: false
			});
		  });
		  
		  $(document).on('click', '#close-preview', function(){ 
			$('.image-preview').popover('hide');
			// Hover befor close the preview
			$('.image-preview').hover(
				function () {
				   $('.image-preview').popover('show');
				}, 
				 function () {
				   $('.image-preview').popover('hide');
				}
			);    
		});

		$(function() {
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
				title: "<strong>Imagem Escolhida</strong>"+$(closebtn)[0].outerHTML,
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