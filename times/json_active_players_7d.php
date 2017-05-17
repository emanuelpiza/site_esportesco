<?php
    header('Content-Type: application/json');
    session_start();

    ob_start();
    include('../admin/dbcon/dbcon.php');

    $sqlgeral = mysqli_query($mysqli,"SELECT * FROM (
    select WEEK(log_date) as week , total from active_players_7d order by log_date DESC limit 12
    ) sub ORDER BY week ASC;");
    $array = array();
    while ( $row = mysqli_fetch_assoc( $sqlgeral ) ) 
    {
        array_push(
            $array,
            array(
                 'week' => $row['week'],
                 'total' => $row['total']
            )
        );
    }
    echo json_encode($array);

?>