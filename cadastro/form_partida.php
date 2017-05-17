<?php
    header('Content-Type: text/html; charset=utf-8');
    session_start();

    ob_start();
    include('../admin/dbcon/dbcon.php');

    if (isset($_SESSION["logname"])) {
        $_SESSION["error1"] = "Please Sign in";
        header("Location: index.php");
    }
    
		$cup_id = mysqli_real_escape_string($mysqli,$_POST['cup_id']);
		$fase = mysqli_real_escape_string($mysqli,$_POST['fase']);
		$team1 = mysqli_real_escape_string($mysqli,$_POST['team1']);
		$team2 = mysqli_real_escape_string($mysqli,$_POST['team2']);
		$datetime = mysqli_real_escape_string($mysqli,$_POST['datetime']);
		$field = mysqli_real_escape_string($mysqli,$_POST['field']);

        $sql_field = mysqli_query($mysqli,"INSERT IGNORE INTO fields (fields_name, cup_id) VALUES ('$field', '$cup_id')");
        mysqli_query($mysqli, $sql_field);

        //Buscando ID do campo
        $sql = mysqli_query($mysqli,"select id_fields from fields where fields_name = '$field' and  cup_id = '$cup_id';");
        $field = mysqli_fetch_assoc($sql)['id_fields'];

		//SQL
        $sql = "INSERT INTO `matches` (team1, team2, cup_id, field_id, datetime, phase) VALUES ('".$team1."', '".$team2."', '".$cup_id."', '".$field."', '".$datetime."', '".$fase."');";
        mysqli_query($mysqli, $sql);
		$mysqli->close();
?>