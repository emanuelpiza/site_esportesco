<?php
    header("Content-Type: text/html;charset=UTF-8");
    session_start();

    ob_start();
    include('../admin/dbcon/dbcon.php');

    $renderMessage = false;
    $key =  mysqli_real_escape_string($mysqli,$_GET['key']);
    $sqljogador = mysqli_query($mysqli,"SELECT *, DATE_FORMAT(birthdate,'%d/%m/%Y') as birthdate_fmt FROM players where admin_key='$key'");
    $jogador = mysqli_fetch_assoc($sqljogador);
    $team = $jogador['players_team_id'];
    $name = $jogador['players_name'];
    $team = $jogador['players_team_id'];
    $whole_name = $jogador['whole_name'];
    $cpf = $jogador['cpf'];
    $rg = $jogador['rg'];
    $birthdate = $jogador['birthdate_fmt'];
    $name_responsible = $jogador['name_responsible'];
    $phone = $jogador['phone'];
    $email = $jogador['email'];
    $player_picture = $jogador['player_picture'];

    $player_position = $jogador['player_position'];
    $player_strongfoot = $jogador['player_strongfoot'];

    $player_height = $jogador['player_height'];
    $shirt = $jogador['shirt'];

    $sqlgeral = mysqli_query($mysqli,"SELECT * FROM teams where id_teams='$team'");
    $dados = mysqli_fetch_assoc($sqlgeral);
    $id = $dados['id_teams'];
    $teams_name = $dados['teams_name'];
    $team_picture = $dados['teams_picture'];
    $short_name = $dados['short_name'];
    $key_team = $dados['admin_key'];

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
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

    <title>Editar Jogador - <?php echo $name; ?> - Esportes.Co</title>

    <!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../css/1-col-portfolio.css" rel="stylesheet">
	
	<!-- AdminLTE CSS -->
	<link rel="stylesheet" href="../css/AdminLTE.min.css">
	<link rel="stylesheet" href="../css/_all-skins.min.css">

	<!-- Font awesome -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	
    <!-- Sweet Alert -->
    <script src="../js/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/sweetalert.css">
    
    <link rel="stylesheet" href="../js/cropperjs/dist/cropper.css">
    <script src="../js/cropperjs/dist/cropper.js"></script>
    
    <link href='https://fonts.googleapis.com/css?family=Poiret+One' rel='stylesheet' type='text/css'>
    <style>
        .img-container img {
          max-width: 100%;
        }
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
        .exibicao{
            width: 130px;
            height: 190px;
            padding: 5px;
            background-color: #FEFEFE;
            box-shadow: 0px 1px 1px 0px grey;
            margin: 0 auto;
        }
        #estrela_content{
            display:-moz-box;
            -moz-box-pack:center;
            -moz-box-align:center;
            display:-webkit-box;
            -webkit-box-pack:center;
            -webkit-box-align:center;
            display:box;
            box-pack:center;
            box-align:center;
            text-align: center;
            margin-bottom:10px;
        }   
        .estrela {
            width:50%;
        }         
        body{
            background: #e74c3c;
            padding-right:10px;
            padding-left:10px;
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
	</style>
</head>

<body>
    
    <div class="container" >
        <div class="modal fade" id="modal" role="dialog" aria-labelledby="modalLabel" tabindex="-1">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Ajustar e Recortar Foto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body">
                <div class="img-container">
                  <img id="image" alt="Picture">
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button id="crop_button" class="btn btn-success">Salvar</button> 
              </div>
            </div>
          </div>
        </div>

    <div class="row">
        <?php 
                echo '
                <div id="estrela_content">
                    <a href="../times/admintime.php?key='.$key_team.'">
                        <img src="../cadastro/uploads/'.$team_picture.'" class="estrela" style="width:100px;margin-left:30px; margin-right:30px; margin-bottom:10px;margin-top:-30px;">
                         <span style="font-family: \'Poiret One\', Arial, serif; font-size:25px; color:white;"><br>'.$short_name.'</span>
                    </a>
                </div>';
        ?>
    </div>
    </div>    
    <section id="contact">
        <div class="section-content" style="text-align:center; margin-bottom:-50px;margin-top:-20px;">
            <h1 class="section-header">Edição de Jogador</h1>
        </div>
    </section>
        
			<div class="row">
				<div class="col-lg-offset-1 col-lg-10" > 
					
					<div class="box box-primary">
						<div class="box-header with-border">
						  <h1 class="box-title"><?php echo $whole_name; ?></h1>
						</div>

						<form method="post" id="form" name="form" role="form"  action="" enctype="multipart/form-data">
                            <input type="hidden" name="admin_key" value="<?php echo $key;?>">
                            <input type="hidden" name="team" value="<?php echo $id;?>">
                            <input type="hidden" name="image_name" value="<?php echo $player_picture;?>">
							<div class="box-body">
                                <div class="row">
                                    <div class="col-sm-6" style="padding-left:30px;padding-right:30px;">
                                        <div class="form-group">
                                          <label for="name">Nome Reduzido ou Apelido</label>
                                          <input type="text" class="form-control" id="name" name="name" value="<?php echo $name;?>">
                                        </div>
                                        <div class="form-group">
                                          <label for="group">RG</label>
                                          <input type="text" maxlength="14" class="form-control" id="rg" name="rg"  value="<?php echo $rg;?>" >
                                        </div>
                                    </div>

                                    <div class="col-sm-6" style="padding-left:30px;padding-right:30px;">
                                        <div class="form-group">
                                          <label for="group">CPF</label>
                                          <input type="text" class="form-control" maxlength="15" id="cpf" name="cpf"   value="<?php echo $cpf;?>">
                                        </div>
                                        <div class="form-group">
                                          <label for="group">Data de Nascimento</label><br>
                                            <input id="datepicker" class="form-control" name="datepicker" type="text"   value="<?php echo $birthdate;?>"/>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-sm-6" style="padding-left:30px;padding-right:30px;">
                                         <div class="form-group">
                                          <label for="group">Posição / Função</label>
                                          <input type="text" class="form-control" id="player_position" name="player_position" placeholder="Indefinido" value="<?php echo $player_position;?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="col-md-4">
                                             <div class="form-group">
                                              <label for="group">Número da Camisa</label>
                                              <input type="text" class="form-control" id="shirt" name="shirt" maxlength="3" placeholder="Indefinido" value="<?php echo $shirt;?>">
                                            </div>
                                        </div>   
                                        <div class="col-md-4">
                                             <div class="form-group">
                                              <label for="group">Altura</label>
                                              <input type="text" class="form-control" id="player_height" name="player_height" maxlength="4" placeholder="Indefinido" value="<?php echo $player_height;?>">
                                            </div>
                                        </div>    
                                        <div class="col-md-4" style="padding-right:-20px;">
                                             <div class="form-group">
                                                <label for="group">Pé Dominante</label><br>
                                                <select name="player_strongfoot" style="width:100%; height:35px;">
                                                  <option value="0" <?php if ($player_strongfoot == 0): ?> selected="selected"<?php endif; ?>>Indefinido</option>
                                                    <option value="1" <?php if ($player_strongfoot == 1): ?> selected="selected"<?php endif; ?>>Ambos</option>
                                                    <option value="2" <?php if ($player_strongfoot == 2): ?> selected="selected"<?php endif; ?>>Direito</option>
                                                    <option value="3" <?php if ($player_strongfoot == 3): ?> selected="selected"<?php endif; ?>>Esquerdo</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                
                                <div class="row">
                                    <div class="form-group" style="text-align:center; width:100%">
                                        <label>Foto</label>
                                        <div id="cropped_result" class="exibicao">
                                            <img id="img_padrao" src="../times/img/jogadores/<?php echo $player_picture;?>" width="120">
                                        </div>
                                        <div class="input-group image-preview">
                                            <span class="input-group-btn">
                                                <!-- image-preview-clear button -->
                                                <button type="button" class="btn btn-default image-preview-clear" style="display:none;">
                                                    <span class="glyphicon glyphicon-remove"></span> Remover
                                                </button>
                                                <!-- image-preview-input -->
                                                <div class="btn btn-default image-preview-input" style="margin-top:10px;">
                                                    <i class="fa fa-file-image-o" aria-hidden="true"></i>
                                                    <span class="image-preview-input-title">Trocar</span>
                                                    <input type="file" name="image" id="image" accept="image/png, image/jpeg, image/gif" name="input-file-preview"/>
                                                </div>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-sm-6 col-sm-offset-3">
                                    <div class="form-group">
                                        <label for="contact">Contatos</label>                 
                                      <div class="input-group">
                                          <span class="input-group-addon">
                                            <i class="fa fa-envelope"  style="width:15px;"></i></span>
                                          <input type="contact_email" name="contact_email" id="email" class="form-control" id="exampleInputEmail1" placeholder="Email" value="<?php echo $email;?>">
                                      </div>
                                      <div class="input-group">
                                          <div class="input-group-addon">
                                             <i class="fa fa-phone"  style="width:15px;"></i>
                                          </div>
                                          <input type="text" name="contact_telefone" id="contact_telefone" placeholder="Telefone" class="form-control" data-inputmask='"mask": "(99) 99999-9999"' data-mask value="<?php echo $phone;?>">
                                        </div>
                                         <div class="input-group">
                                          <span class="input-group-addon"> <i class="fa fa-user" style="width:15px;"></i></span>
                                          <input type="contact_name" name="contact_name" id="contact_name" class="form-control" id="exampleInputEmail1" placeholder="Nome do Familiar ou Responsável" value="<?php echo $name_responsible;?>">
                                      </div>   
                                    </div>
                                </div>
                            </div>
                        </form> 
                        <div class="box-footer">
                            <button class="btn btn btn-default" onclick="window.location.replace('../times/admintime.php?key=<?php echo $key_team; ?>')" style="float:left;">Voltar</button>
                            <button class="btn btn btn-success" onclick="cadastrar();" style="float:right;">Salvar</button>
                        </div>
					</div>
				</div>
			</div>
        <!-- </div> -->
                    

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
        var formData = new FormData();
        $(function () {

            $("#datepicker").inputmask("99/99/9999",{ "placeholder": "dd/mm/aaaa" });
            
			// Create the preview image
			$(".image-preview-input input:file").change(function (){
                var img = $('<img/>', {
					id: 'dynamic',
					width:150,
					height:200
				});  
				var file = this.files[0];
				var reader = new FileReader();
				reader.onload = function (e) {
                    $("#image").attr("src",e.target.result);
					$('#modal').modal('show');
				}        
				reader.readAsDataURL(file);
			});  
            
            window.addEventListener('DOMContentLoaded', function () {
                var image = document.getElementById('image');
                var cropBoxData;
                var canvasData;
                var cropper;

                $('#modal').on('shown.bs.modal', function () {
                    cropper = new Cropper(image, {
                    dragMode: 'move',
                    aspectRatio: 3 / 4,
                    autoCropArea: 0.65,
                    restore: false,
                    guides: true,
                    center: false,
                    highlight: false,
                    cropBoxMovable: false,
                    cropBoxResizable: false,
                    toggleDragModeOnDblclick: false,
                    });
                }).on('hidden.bs.modal', function () {
                    cropBoxData = cropper.getCropBoxData();
                    canvasData = cropper.getCanvasData();
                    cropper.destroy();
                });

                 document.getElementById('crop_button').addEventListener('click', function(){

                var imgurl =  cropper.getCroppedCanvas().toDataURL();
                    var img = document.createElement("img");
                    img.src = imgurl;
                    img.width = "120";
                    document.getElementById("cropped_result").appendChild(img);
                    $('#modal').modal('hide');
                    $("#img_padrao").hide();

                    cropper.getCroppedCanvas().toBlob(function (blob) {
                          formData.append('croppedImage', blob);
                    });
                 });  
            });
        });
        function cadastrar() {
            var other_data = $('form').serializeArray();
            $.each(other_data,function(key,input){
                formData.append(input.name,input.value);
            });
            $.ajax('./form_edit_jogador.php', {
                        method: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function () { 
                            swal({
                                  title: "Jogador Atualizado!",
                                  text: "Você será redirecionado para a página do time.",
                                  type: "success",
                                  closeOnConfirm: true
                                },
                                function(isConfirm) {
                                  if (isConfirm) {
                                      window.location.replace("../times/admintime.php?key=<?php echo $key_team; ?>");
                                  };
                            });  
                        },
                        error: function () {
                            swal('Ops!', "Houve um problema no cadastro. Caso o problema persista, procure o responsável pelo campeonato.");
                        }
            });
        } 
  </script>
</body>

</html>