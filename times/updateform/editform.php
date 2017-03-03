<?php
// FONTE: http://www.codingcage.com/2016/02/upload-insert-update-delete-image-using.html


	error_reporting( ~E_NOTICE );
	
    include('../../admin/dbcon/dbcon.php');
	
    $id = $_GET['id'];
	if(isset($id) && !empty($id))
	{
		//$id = $_GET['edit_id'];
		//$stmt_edit = $DB_con->prepare('SELECT userName, userProfession, userPic FROM tbl_users WHERE userID =:uid');
		//$stmt_edit->execute(array(':uid'=>$id));
		//$edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
		//extract($edit_row);
        
        $sqlgeral = mysqli_query($mysqli,"SELECT * FROM players where id_players='$id'");
        $dados = mysqli_fetch_assoc($sqlgeral);
        $player = $dados['id_players'];
        $whole_name = $dados['whole_name'];
        $nickname = $dados['nickname'];
        $email = $dados['email'];
        $shirt = $dados['shirt'];
        $player_picture = $dados['player_picture'];
        $team = $dados['players_team_id'];
	}
	else
	{
		header("Location: ../index.php");
	}
	
	
	
	if(isset($_POST['btn_save_updates']))
	{
        
        $whole_name = $_POST['whole_name'];
        $nickname = $_POST['nickname'];
        $email = $_POST['email'];
        $shirt = $_POST['shirt'];
        $foto_padrao = $_POST['foto_padrao'];
		$imgFile = $_FILES['player_picture']['name'];
		$tmp_dir = $_FILES['player_picture']['tmp_name'];
		$imgSize = $_FILES['player_picture']['size'];
					
		if ($foto_padrao == 1){
			$userpic = "0.jpg";
        }else if($imgFile)
		{
			$upload_dir = '../img/jogadores/'; // upload directory	
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
						
		
		// if no error occured, continue ....
		if(!isset($errMSG))
		{
            $sql = "
                UPDATE `players` SET 
                    nickname= '".$nickname."',
                    shirt= '".$shirt."',
                    email= '".$email."',
                    player_picture= '".$userpic."' 
                where id_players = '".$player."';";
            
            if(mysqli_query($mysqli, $sql)){
			?>
                <script>
				alert('Cadastro atualizado com Sucesso...!');
				window.location.href='../admintime.php?id=<?php echo $team; ?>';
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
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Atualizar Info - Esportes.Co</title>

<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">

<!-- custom stylesheet -->
<link rel="stylesheet" href="style.css">

<!-- Latest compiled and minified JavaScript -->
<script src="bootstrap/js/bootstrap.min.js"></script>

<script src="jquery-1.11.3-jquery.min.js"></script>
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
        	<p><img src="../img/jogadores/<?php echo $player_picture; ?>" width="150" height="200"/></p>
        	<input class="input-group" type="file" name="player_picture" accept="image/*" />
            
            <input type="checkbox" name="foto_padrao" value="1"> Deixar sem foto.<br>
        </td>
    </tr>
    
    <tr>
        <td colspan="2"><button type="submit" name="btn_save_updates" class="btn btn-default">
        <span class="glyphicon glyphicon-save"></span> Atualizar
        </button>
        
        <a class="btn btn-default" href="../admintime.php?id=<?php echo $team; ?>"> <span class="glyphicon glyphicon-backward"></span> Cancelar </a>
        
        </td>
    </tr>
    
    </table>
    
</form>

</div>
</body>
</html>