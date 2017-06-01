<?php
    header('Content-Type: application/json');
    session_start();

    ob_start();
    include('../admin/dbcon/dbcon.php');

    if (isset($_SESSION["logname"])) {
        $_SESSION["error1"] = "Please Sign in";
        header("Location: index.php");
    }

    $id = $_GET['id'];
    $sqlgeral = mysqli_query($mysqli,"   select score1 as goals, date_format(datetime, '%d/%m') as day, datetime from matches where team1 = '$id' and score2 is not null 
   	UNION ALL
   select score2 as goals, date_format(datetime, '%d/%m') as day, datetime from matches where team2 = '$id' and score2 is not null order by datetime;");
    $array = array();
    while ( $row = mysqli_fetch_assoc( $sqlgeral ) ) 
    {
        array_push(
            $array,
            array(
                 'day' => $row['day'],
                 'goals' => $row['goals']
            )
        );
    }
    echo json_encode($array);

?>