<?php
    header('Content-Type: application/json');
    session_start();

    ob_start();
    include('../admin/dbcon/dbcon.php');

    $sqlgeral = mysqli_query($mysqli," 	 select count(distinct(n.`player`)) as value, c.`contact_name` as label from notes n left join players p on n.`player` = p.`id_players` left join teams t on p.`players_team_id` = t.`id_teams` left join cups c on t.`cup_id` = c.id where n.datetime BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) and NOW() group by c.`contact_name` order by value desc;");
    $array = array();
    while ( $row = mysqli_fetch_assoc( $sqlgeral ) ) 
    {
        array_push(
            $array,
            array(
                 'label' => $row['label'],
                 'value' => $row['value']
            )
        );
    }
    echo json_encode($array);

?>