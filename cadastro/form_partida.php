<?php
    header('Content-Type: text/html; charset=utf-8');
    session_start();

    ob_start();
    include('../admin/dbcon/dbcon.php');

    if (isset($_SESSION["logname"])) {
        $_SESSION["error1"] = "Please Sign in";
        header("Location: index.php");
    }
    
		//Getting data from request
		$cup_id = mysqli_real_escape_string($mysqli,$_POST['cup_id']);
		$team1 = mysqli_real_escape_string($mysqli,$_POST['team1']);
		$team2 = mysqli_real_escape_string($mysqli,$_POST['team2']);
		$datetime = mysqli_real_escape_string($mysqli,$_POST['datetime']);
        //$birthdate =  mysqli_real_escape_string($mysqli,date('Y-m-d', strtotime($date)));

		$field = mysqli_real_escape_string($mysqli,$_POST['field']);
        $sql_field = mysqli_query($mysqli,"INSERT IGNORE INTO fields (fields_name) VALUES ('$field')");
        mysqli_query($mysqli, $sql_field);

        //Buscando ID do campo
        $sql = mysqli_query($mysqli,"select id_fields from fields where fields_name = '$field';");
        $field = mysqli_fetch_assoc($sql)['id_fields'];

		//SQL
        $sql = "INSERT INTO `matches` (team1, team2, cup_id, field_id, datetime) VALUES ('".$team1."', '".$team2."', '".$cup_id."', '".$field."', '".$datetime."');";
        mysqli_query($mysqli, $sql);
		$mysqli->close();
?>