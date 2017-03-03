<?php
 
    header('Content-Type: text/html; charset=utf-8');
    session_start();

    ob_start();
    include('./admin/dbcon/dbcon.php');

    include ("./classes/PHPExcel/IOFactory.php");  

    $copa = 16;
    $target_dir = "./cadastro/uploads/";
    $rand = rand();    
    $target_file = $target_dir . $rand . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);


    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "Arquivo ". basename( $_FILES["fileToUpload"]["name"]). " atualizado.";
    } else {
        echo "<h3>É necessário carregar o arquivo antes de atualizar a base de dados.<br> <a href='http://www.esportes.co/painel.php?cop".$copa."'>Voltar</a></h3> ";
    }

    $sqlcount_id = mysqli_query($mysqli,"select max(cup_player_id) as maximo from players where cup_id = ".$copa);
    $max_jogadores = mysqli_fetch_assoc($sqlcount_id)['maximo'];
    $sqlcount_id = mysqli_query($mysqli,"select max(match_cup_id) as maximo from matches where cup_id = ".$copa);
    $max_partidas = mysqli_fetch_assoc($sqlcount_id)['maximo'];
   
    $objPHPExcel = PHPExcel_IOFactory::load($target_file); 
    
    if ($objPHPExcel->sheetNameExists("Jogadores")){
        $jogadores = $objPHPExcel->getSheetByName("Jogadores"); 
        $highestRow = $jogadores->getHighestRow();  
        for ($row=2; $row<=$highestRow; $row++)  
        {  
            $nome_completo = mysqli_real_escape_string($mysqli, $jogadores->getCellByColumnAndRow(2, $row)->getValue()); 
            if ($nome_completo <> null ){
                $id = mysqli_real_escape_string($mysqli, $jogadores->getCellByColumnAndRow(0, $row)->getValue()); 
                $team_name = mysqli_real_escape_string($mysqli, $jogadores->getCellByColumnAndRow(1, $row)->getValue());  
                $nickname = mysqli_real_escape_string($mysqli, $jogadores->getCellByColumnAndRow(3, $row)->getValue());
                $shirt = mysqli_real_escape_string($mysqli, $jogadores->getCellByColumnAndRow(4, $row)->getValue());  
                $birthdate = mysqli_real_escape_string($mysqli, date($format = "Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($jogadores->getCellByColumnAndRow(5, $row)->getValue())));  
                $cpf = mysqli_real_escape_string($mysqli, $jogadores->getCellByColumnAndRow(6, $row)->getValue());  
                $rg = mysqli_real_escape_string($mysqli, $jogadores->getCellByColumnAndRow(7, $row)->getValue());  
                $registry = mysqli_real_escape_string($mysqli, $jogadores->getCellByColumnAndRow(8, $row)->getValue());
                $name_responsable = mysqli_real_escape_string($mysqli, $jogadores->getCellByColumnAndRow(9, $row)->getValue());  
                $phone = mysqli_real_escape_string($mysqli, $jogadores->getCellByColumnAndRow(10, $row)->getValue());  
                $email = mysqli_real_escape_string($mysqli, $jogadores->getCellByColumnAndRow(11, $row)->getValue());

                $sqlcount_team = mysqli_query($mysqli,"select count(*) as count from teams where teams_name = '".$team_name."' and cup_id =".$copa);
                $count_teams = mysqli_fetch_assoc($sqlcount_team)['count'];

                if ($count_teams == 0 ){  
                    $sql = "INSERT INTO teams (teams_name, cup_id) VALUES (UCASE('".$team_name."'), ".$copa.")";
                    mysqli_query($mysqli, $sql);
                }
                if ($id > $max_jogadores){
                    $sql = "INSERT INTO players(whole_name, players_team_id, shirt, birthdate, name_responsible, phone, email, nickname, players_name, rg, cpf, registry) VALUES (UC_Words('".$nome_completo."'), (select id_teams from teams where teams_name  = '".$team_name."' and cup_id =".$copa."), '".$shirt."', '".$birthdate."', '".$name_responsable."', '".$phone."', '".$email."', UC_Words('".$nickname."'), UC_Words(CONCAT_WS(' ', substring_index('".$nome_completo."', ' ', 1), substring_index('".$nome_completo."', ' ', -1))), '".$rg."','".$cpf."', '".$registry."');";  
                    mysqli_query($mysqli, $sql);  
                //}else{ 
                  //  sql =  "UPDATE players SET whole_name = UC_Words('".$nome_completo."'), players_team_id = (select id_teams from teams where teams_name  = '".$team_name."'), shirt = '".$shirt."', birthdate = '".$date."', name_responsible = '".$name_responsable."', phone = '".$phone."', email = '".$email."', nickname = UC_Words('".$nickname."'), players_name = UC_Words(CONCAT_WS(' ', substring_index('".$nome_completo."', ' ', 1), substring_index('".$nome_completo."', ' ', -1))) where cup_player_id = ".$id." and cup_id =".$copa;  
                    //mysqli_query($mysqli, $sql);     
                } 
            }
        }  
    }
   
    if ($objPHPExcel->sheetNameExists("Partidas")){
        $partidas = $objPHPExcel->getSheetByName("Partidas"); 
        $highestRow = $partidas->getHighestRow();  
        for ($row=2; $row<=$highestRow; $row++)  
        {    
            $datetime = mysqli_real_escape_string($mysqli, $partidas->getCellByColumnAndRow(2, $row)->getValue());
            if ($datetime <> null ){
                $id = mysqli_real_escape_string($mysqli, $partidas->getCellByColumnAndRow(0, $row)->getValue()); 
                $field = mysqli_real_escape_string($mysqli, $partidas->getCellByColumnAndRow(1, $row)->getValue());  
                $team1 = mysqli_real_escape_string($mysqli, $partidas->getCellByColumnAndRow(3, $row)->getValue());  
                $team2 = mysqli_real_escape_string($mysqli, $partidas->getCellByColumnAndRow(4, $row)->getValue());  

                $sql = "INSERT IGNORE INTO fields (fields_name) VALUES ('".$field."')";
                mysqli_query($mysqli, $sql);

                if ($id > $max_partidas){
                    $sql = "INSERT INTO matches (cup_id, match_cup_id, datetime, field_id, team1, team2) VALUES (".$copa.", ".$id.", '".$datetime."', (select id_fields from fields where fields_name  = '".$field."'), (select id_teams from teams where teams_name  = '".$team1."' and cup_id = ".$copa."), (select id_teams from teams where teams_name  = '".$team2."'  and cup_id = ".$copa."))";
                    echo $sql;
                    mysqli_query($mysqli, $sql);  
                }else{ 
                    $sql = "UPDATE matches SET datetime = '".$datetime."', field_id = (select id_fields from fields where fields_name  = '".$field."'), team1 = (select id_teams from teams where teams_name  = '".$team1."' and cup_id = ".$copa."), team2 = (select id_teams from teams where teams_name  = '".$team2."' and cup_id = ".$copa.") where match_cup_id = ".$id." and cup_id=".$copa;  
                    mysqli_query($mysqli, $sql);  
                }           
            }
        } 
    }

    //Gambi pro futuro não ficar zerado 
    $futuro = "update matches m set m.score1 = null, m.score2 = null where datetime > now();";
    mysqli_query($mysqli, $futuro);

    $redirect = "http://www.esportes.co/times/copa.php?id=$copa";
    #abaixo, chamamos a função header() com o atributo location: apontando para a variavel $redirect, que por 
    #sua vez aponta para o endereço de onde ocorrerá o redirecionamento
    header("location:$redirect");
?>