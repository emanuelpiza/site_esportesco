<?php
// FONTE: http://www.codingcage.com/2016/02/upload-insert-update-delete-image-using.html


	error_reporting( ~E_NOTICE );
	
    include('../admin/dbcon/dbcon.php');
	

    $key = mysqli_real_escape_string($mysqli,$_GET['key']);
    $sqlgeral = mysqli_query($mysqli,"SELECT id_players FROM players where admin_key='$key'");
    $id = mysqli_fetch_assoc($sqlgeral)['id_players'];
	if(isset($key) && !empty($key))
	{
        
        $sqlgeral = mysqli_query($mysqli,"SELECT p.*, t.admin_key as admin_key_team FROM players p left join teams t on p.players_team_id = t.id_teams where p.admin_key='$key';");
        $dados = mysqli_fetch_assoc($sqlgeral);
        $player = $dados['id_players'];
        $whole_name = $dados['whole_name'];
        $nickname = $dados['nickname'];
        $email = $dados['email'];
        $shirt = $dados['shirt'];
        $player_picture = $dados['player_picture'];
        $team = $dados['players_team_id'];
        $team_key = $dados['admin_key_team'];
	}
	else
	{
		header("Location: ../index.php");
	}
	
	
	
	if(isset($_POST['btn_save_updates']))
	{
        
        $whole_name = mysqli_real_escape_string($mysqli,$_POST['whole_name']);
        $nickname = mysqli_real_escape_string($mysqli,$_POST['nickname']);
        $email = mysqli_real_escape_string($mysqli,$_POST['email']);
        $shirt = mysqli_real_escape_string($mysqli,$_POST['shirt']);
        $foto_padrao = mysqli_real_escape_string($mysqli,$_POST['foto_padrao']);
		$imgFile = mysqli_real_escape_string($mysqli,$_FILES['player_picture']['name']);
		$tmp_dir = $_FILES['player_picture']['tmp_name'];
		$imgSize = $_FILES['player_picture']['size'];
					
		if ($foto_padrao == 1){
			$userpic = "0.jpg";
        }else if($imgFile)
		{
			$upload_dir = './img/jogadores/'; // upload directory	
			$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
			$userpic = rand(1000,1000000).".".$imgExt;
			if(in_array($imgExt, $valid_extensions))
			{			
				if($imgSize < 5000000)
				{
					unlink($upload_dir.$player_picture);
					move_uploaded_file($tmp_dir,$upload_dir.$userpic);
				}
				else
				{
					$errMSG = "Sorry, your file is too large it should be less then 5MB";
				}
			}
			else
			{
				$errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";		
			}	
		}
		else
		{
			// if no image selected the old image remain as it is.
			$userpic = $player_picture; // old image from database
		}	
						

        $sql = "
               UPDATE `players` SET 
                    players_name= IF('".$nickname."' <> '', '".$nickname."', UC_Words(CONCAT_WS(' ', substring_index(whole_name, ' ', 1), substring_index(whole_name, ' ', -1))))
                where id_players = '".$player."';";
        mysqli_query($mysqli, $sql);
		
        
		// if no error occured, continue ....
		if(!isset($errMSG))
		{
            $sql = "
                UPDATE `players` SET 
                    players_name = IF('".$nickname."' <> '', '".$nickname."', UC_Words(CONCAT_WS(' ', substring_index(whole_name, ' ', 1), substring_index(whole_name, ' ', -1)))),
                    nickname= '".$nickname."',
                    shirt= '".$shirt."',
                    email= '".$email."',
                    player_picture= '".$userpic."' 
                where id_players = '".$player."';";
            
            if(mysqli_query($mysqli, $sql)){
			?>
                <script>
				alert('Cadastro atualizado com Sucesso...!');
				window.location.href='./admintime.php?key=<?php echo $team_key; ?>';
				</script>
                <?php
			}
			else{
				$errMSG = "O arquivo não pode ser carregado !";
			}
		
		}
		
						
	}
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head> <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Atualizar Info - Esportes.Co</title>

    <!-- Sweet Alert -->
    <script src="../js/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/sweetalert.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <script src="../js/bootstrap.min.js"></script>
    <script src="./js/jquery.js"></script>
</head>
<body>
<div class="container">


	<div class="page-header">
    	<h1 class="h2"> <small>Alterar Informações:<br /> </small><?php echo $whole_name;?></h1>
    </div>

<div class="clearfix"></div>

<form method="post" enctype="multipart/form-data" class="form-horizontal">
	
    
    <?php
	if(isset($errMSG)){
		?>
        <div class="alert alert-danger">
          <span class="glyphicon glyphicon-info-sign"></span> &nbsp; <?php echo $errMSG; ?>
        </div>
        <?php
	}
	?>
   
    
	<table class="table table-bordered table-responsive">
	
    <tr>
    	<td><label class="control-label">Apelido.</label></td>
        <td><input class="form-control" type="text" name="nickname" value="<?php echo $nickname;?>"/></td>
    </tr>
    
    <tr>
    	<td><label class="control-label">Camisa.</label></td>
        <td><input class="form-control" type="text" name="shirt" value="<?php echo $shirt; ?>"/></td>
    </tr>
        
    <tr>
    	<td><label class="control-label">Email.</label></td>
        <td><input class="form-control" type="text" name="email" value="<?php echo $email; ?>"/></td>
    </tr>
    
    <tr>
    	<td><label class="control-label">Profile Img.</label></td>
        <td>
        	<p><img src="./img/jogadores/<?php echo $player_picture; ?>" width="150" height="200"/></p>
        	<input class="input-group" type="file" name="player_picture" accept="image/*" />
            
            <input type="checkbox" name="foto_padrao" value="1"> Deixar sem foto.<br>
        </td>
    </tr>
    
    <tr>
        <td colspan="2">
            <button type="submit" name="btn_save_updates" style="float:right;"  class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i> Atualizar </button>
            <a class="btn btn-default" href="./admintime.php?key=<?php echo $team_key; ?>"> <i class="fa fa-times" aria-hidden="true"></i> Cancelar </a>
        </td>
    </tr>
    
    </table>
</form>
    <button type="button"class="btn btn-danger" onclick='remover("players", "<?php  echo $id ?>")'>Excluir Jogador</button>
</div>
    <script>
       function remover(table, id) {   
       swal({

            title: "Excluir definitivamente?",
            text: "Atenção! Esta ação não pode ser desfeita.",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Sim, excluir!",
            closeOnConfirm: false,
            closeOnCancel: false
            },
            function(isConfirm){
                if (isConfirm) {
                    $.post("http://www.esportes.co/times/acoes.php",{acao: "remover", table: table, id: id},function(data){});
                    swal({
                        title: "Concluído!",
                        text: "Exclusão feita com sucesso. Você será redirecionado para a página de criação de times da competição.",
                        type: "success",
                        showCancelButton: false,
                        closeOnConfirm: false,
                    },
                    function(){
                        window.location.replace("./admintime.php?key=<?php echo $team_key; ?>");
                    });
              } else {
                swal("Cancelado", ":)", "error");
              }
            });
        };
    </script>
</body>
</html>