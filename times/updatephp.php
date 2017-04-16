<!DOCTYPE HTML>
<html>
<title></title>
    <head>
        <link rel="stylesheet" type="text/css" href="style_update.css">
    </head>
    <body>

        <div class="maindiv">
            <div class="divA">
                <div class="title"><h2>Formulário de Atualização</h2></div>
                <div class="divB">
                    <div class="divD">
                        <p>Jogadores</p>

                        <?php                        
                        include('../admin/dbcon/dbcon.php');
                        $id = $_GET['id'];
                        $update = $_GET['update'];
						
	                   if (!empty($_POST)) {
                            
                            //Tratamento da foto    
                            $rand = uniqid();
                            $target_dir = "../times/img/jogadores/";
        
                            $target_file_bd = $rand . basename($_FILES["image"]["name"]);
                            $target_file = $target_dir . $target_file_bd;
                            $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		
                            move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
                            
                            //Inserção no Banco de Dados   
                            $player = $_POST['player'];
                            $image = $target_file_bd; 
                            $email = $_POST['email'];
                            $mobile = $_POST['phone'];
                            $address = $_POST['shirt'];
                            $sql = "UPDATE `players` SET player_picture='$image', email='$email', phone='$phone', shirt='$shirt' where id_players='$player';";
                            mysqli_query($mysqli, $sql);
                        }
						
                        $query = mysqli_query($mysqli, "SELECT * FROM players where players_team_id = '$id' order by players_name");
                        while($row = mysqli_fetch_assoc($query)){
                            echo "<b><a href=\"updatephp.php?id=".$id."&update=".$row['id_players']."\">".$row['players_name']."</a></b>";
                            echo "<br />";
                        }
                        ?>
                    </div>
                    <?php                
                   if (isset($_POST['submit'])) {
				   echo '<div class="form" id="form3"><br><br><br><br><br><br><Span>Dados atualizados com sucesso......!!</span></div>';
				   } else if (isset($update)) {
                        $query1 = mysqli_query($mysqli,"SELECT * FROM players where id_players =$update");
                        while($row1 = mysqli_fetch_assoc($query1)){
                            echo '<form method="post" role="form"  action="" enctype="multipart/form-data"';
                            echo '<input type="hidden" name="player" value="'.$row1['id_players'].'">';
                            echo "<h2>Dados: ".$row1['players_name']."</h2>";
                            echo "<hr/>";
                            echo "<label>" . "Número da Camisa:" . "</label>" . "<br />";
                            echo"<input class=\"input\" type=\"text\" name=\"shirt\" value=\"".$row1['shirt']."\" />";
                            echo "<br />";
                            echo "<label>" . "Email:" . "</label>" . "<br />";
                            echo"<input class=\"input\" type=\"text\" name=\"email\" value=\"".$row1['email']."\" />";
                            echo "<br />";
                            echo "<label>" . "Telefone:" . "</label>" . "<br />";
                            echo"<input class=\"input\" type=\"text\" name=\"phone\" value=\"".$row1['phone']."\" />";
                            echo "<br />";
                            echo "<label>" . "Foto:" . "</label>" . "<br />";
                            echo "<br />";
                            echo '<img class="figurinha_img" src="img/jogadores/' . $row1['player_picture'] . '" alt="User Image">';
                            echo "<br />";
                            echo "<br />";
                            echo '
                                <span>Trocar Foto<small> (Formato ideal: 150px x 200px)</small></span>
                                <input type="file" name="image" id="image" accept="image/png, image/jpeg, image/gif" name="input-file-preview"/><br />';
                            echo "<button type='submit'>Atualizar</button>";
                            echo "</form>";
                        }
                    }    
                    ?>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
            </div> 
    </div>
</body>
</html>
<?php
mysqli_close($mysqli);
?>