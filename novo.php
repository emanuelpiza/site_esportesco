<?php
	
    # Evita o armazenamento em Cache
    @header("Cache-Control: no-cache, must-revalidate");  
    @header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");  
	
	$renderMessage = false;
	
	if ( !empty($_POST)) {
	
		$servername = "localhost";
		$username = "root";
		$password = "k1llersql";
		$dbname = "Esportes";

		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
		$conn->query("SET NAMES 'utf8'");
		mb_language('uni'); 
		mb_internal_encoding('UTF-8');
		
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 

		//Saving file
		$target_dir = "uploads/";
		$target_file = $target_dir . basename($_FILES["image"]["name"]);
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		
		move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

		
		//Getting data from request
		$championshipName = $_POST['championshipName'];
		$contact = $_POST['email'] ;
		$phone = $_POST['phone'];
		$address = $_POST['address'];
		$image = $target_file;
		$category = $_POST['category'];
		$cost = $_POST['cost'];
		$days = $_POST['days'];
		$startDate = $_POST['startDate'];
		$limitDate = $_POST['limitDate'];
		
		//SQL
		$sql = "INSERT INTO cups (IS_ACTIVE, NAME, cathegory, entry_fee, date_limit, matches_timeofweek, location_details, email, cell, image)	VALUES (0, '".$championshipName."','". $category."','". $cost ."','". $limitDate."','". $days ."','". $address ."','". $contact ."','". $phone ."','". $image."');";
        
		// prepare and bind
		//$stmt = $conn->prepare($sql);
		//$stmt->bind_param("sssssssss", $championshipName, $category, $cost , $limitDate, $days, $address, $contact, $phone, $image);

		//$stmt->execute();
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

    <title>Competições - Esportes.Co</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/1-col-portfolio.css" rel="stylesheet">
	
	<!-- AdminLTE CSS -->
	<link rel="stylesheet" href="css/AdminLTE.min.css">
	<link rel="stylesheet" href="css/_all-skins.min.css">

	<!-- Font awesome -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	
	<!-- bootstrap datepicker -->
    <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">

	<!-- Bootstrap time Picker -->
    <link rel="stylesheet" href="plugins/timepicker/bootstrap-timepicker.min.css">
	
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
						  <h1 class="box-title">Cadastro de Campeonato</h1>
						</div>
						
						<?php 
							if ($renderMessage) {
								echo '<div class="alert alert-success alert-dismissible">
										<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
										<h4><i class="icon fa fa-check"></i>Sucesso!</h4>
										Campeonato enviado para validação.
									  </div>';
								
							}
						?>

						<form method="post" role="form"  action="" enctype="multipart/form-data">
							<div class="box-body">
								<div class="form-group">
								  <label for="championshipName">Nome do Campeonato</label>
								  <input type="text" class="form-control" id="championshipName" name="championshipName" placeholder="Nome do Campeonato" required="true">
								</div>
								<div class="form-group">
								  <label for="contact">Contato</label>
								  <div class="input-group">
									  <span class="input-group-addon">@</span>
									  <input type="email" name="email" id="email" class="form-control" id="exampleInputEmail1" placeholder="Email" required="true">
								  </div>
								  <div class="input-group">
									  <div class="input-group-addon">
										<i class="fa fa-phone"></i>
									  </div>
									  <input type="text" name="phone" id="phone" placeholder="Cel" class="form-control" data-inputmask='"mask": "(99) 99999-9999"' data-mask>
									</div>
								</div>
								<div class="form-group">
									<label>Endereços dos Campos</label>
									<textarea name="address" id="address" class="form-control" rows="3" placeholder="Endereço..."></textarea>
								</div>
								
								<div class="form-group">
									<label>Imagem de Divulgação</label>
									<div class="input-group image-preview">
										<input type="text" class="form-control image-preview-filename" disabled="disabled"> <!-- don't give a name === doesn't send on POST/GET -->
										<span class="input-group-btn">
											<!-- image-preview-clear button -->
											<button type="button" class="btn btn-default image-preview-clear" style="display:none;">
												<span class="glyphicon glyphicon-remove"></span> Clear
											</button>
											<!-- image-preview-input -->
											<div class="btn btn-default image-preview-input">
												<span class="glyphicon glyphicon-folder-open"></span>
												<span class="image-preview-input-title">Browse</span>
												<input type="file" name="image" id="image" accept="image/png, image/jpeg, image/gif" name="input-file-preview"/> <!-- rename it -->
											</div>
										</span>
									</div>
								</div>
								
								<div class="form-group">
									<label for="category">Categoria</label>
									<input type="text" class="form-control" id="category" name="category" placeholder="Sub-15, Feminino, etc...">
								</div>
								<!--<div class="form-group">
									<label for="age">Idade</label>
									<input type="text" value="" class="slider form-control" 
										data-slider-min="0" 
										data-slider-max="100" 
										data-slider-step="1" 
										data-slider-value="[10,80]" 
										data-slider-orientation="horizontal" 
										data-slider-selection="before" 
										data-slider-tooltip="always" 
										data-slider-id="green">
								</div> -->
								<div class="form-group">
									<label for="cost">Valor por Jogador</label>
									<div class="input-group">
										<span class="input-group-addon">R$</span>
										<input type="text" class="form-control" name="cost" id="cost">
										<span class="input-group-addon">,00</span>
									</div>
								</div>
								<div class="form-group">
									<label>Dias dos Jogos</label>
									<textarea class="form-control" name="days" id="days" rows="3" placeholder="Preencha os dias e horários dos jogos..."></textarea>
								</div>
								<!-- <div class="form-group">
									<label for="weekDays">Dias dos Jogos</label>
									<div class="checkbox">
										<label><input type="checkbox" name="weekDays">D</label>
										<label><input type="checkbox" name="weekDays">S</label>
										<label><input type="checkbox" name="weekDays">T</label>
										<label><input type="checkbox" name="weekDays">Q</label>
										<label><input type="checkbox" name="weekDays">Q</label>
										<label><input type="checkbox" name="weekDays">S</label>
										<label><input type="checkbox" name="weekDays">S</label>
									</div>
								</div>
								<div class="form-group">
									<div class="bootstrap-timepicker">
										<label for="weekDays">Horário dos Jogos</label>
										<div class="input-group">
											<div class="input-group-addon">
											  <i class="fa fa-clock-o"></i>
											</div>
											<input type="text" class="form-control timepicker">
										</div>
									</div>
								</div> -->
								<div class="form-group">
									<label for="datepicker">Início do Campeonato</label>
									<div class="input-group date">
										<div class="input-group-addon">
											<i class="fa fa-calendar"></i>
										</div>
										<input type="text" name="startDate" class="form-control pull-right" id="datepicker">
									</div>
								</div>
								
								<!-- Data limite para inscrição -->
								<div class="form-group">
									<label for="datepicker2">Data Limite para Inscrição</label>
									<div class="input-group date">
										<div class="input-group-addon">
											<i class="fa fa-calendar"></i>
										</div>
										<input type="text" name="limitDate" class="form-control pull-right" id="datepicker2">
									</div>
								</div>
								
							</div>
							
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
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

	<!-- bootstrap datepicker -->
	<script src="plugins/datepicker/bootstrap-datepicker.js"></script>

	<!-- bootstrap time picker -->
	<script src="plugins/timepicker/bootstrap-timepicker.min.js"></script>
	
	<!-- InputMask -->
	<script src="plugins/input-mask/jquery.inputmask.js"></script>
	<script src="plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
	<script src="plugins/input-mask/jquery.inputmask.extensions.js"></script>
	
	<script>
		$(function () {

			//Date picker
			$('#datepicker').datepicker({
			  autoclose: true,
			  todayHighlight: true,
			  format: 'yyyy/mm/dd'
			});
			
			//Date picker
			$('#datepicker2').datepicker({
			  autoclose: true,
			  todayHighlight: true,
			  format: 'yyyy/mm/dd'
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
				$(".image-preview-input-title").text("Browse"); 
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
					$(".image-preview-input-title").text("Change");
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