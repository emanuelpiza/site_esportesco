<?php
    header('Content-Type: text/html; charset=utf-8');
    session_start();

    ob_start();
    include('../admin/dbcon/dbcon.php');

    $key = mysqli_real_escape_string($mysqli,$_GET['key']);
    $sqlgeral = mysqli_query($mysqli,"SELECT * FROM teams where admin_key='$key'");
    $dados_team = mysqli_fetch_assoc($sqlgeral);
    $id = $dados_team['id_teams'];
    $name = $dados_team['teams_name'];
    $team_picture = $dados_team['teams_picture'];
    $short_name = $dados_team['short_name'];
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

    <title>Partidas - <?php echo $name; ?> - Esportes.Co</title>

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
    
   <script src="../js/jquery.js"></script>
    <script src="../js/moment/min/moment.min.js"></script>
    <script type="text/javascript" src="../js/moment/locale/pt-br.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
    <link href='https://fonts.googleapis.com/css?family=Poiret+One' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Oleo+Script:400,700" rel="stylesheet">
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
            background: #3a6186; /* fallback for old browsers */
            background: -webkit-linear-gradient(to left, #3a6186 , #89253e); /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to left, #e74c3c , #e74c3c); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
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
        /*Contact sectiom*/
        .content-header{
          font-family: 'Oleo Script', cursive;
          color:#73bfc1;
          font-size: 45px;
        }
        
     /*!
     * Datetimepicker for Bootstrap 3
     * version : 4.17.47
     * https://github.com/Eonasdan/bootstrap-datetimepicker/
     */
    .bootstrap-datetimepicker-widget {
      list-style: none;
    }
    .bootstrap-datetimepicker-widget.dropdown-menu {
      display: block;
      margin: 2px 0;
      padding: 4px;
      width: 19em;
    }
    @media (min-width: 768px) {
      .bootstrap-datetimepicker-widget.dropdown-menu.timepicker-sbs {
        width: 38em;
      }
    }
    @media (min-width: 992px) {
      .bootstrap-datetimepicker-widget.dropdown-menu.timepicker-sbs {
        width: 38em;
      }
    }
    @media (min-width: 1200px) {
      .bootstrap-datetimepicker-widget.dropdown-menu.timepicker-sbs {
        width: 38em;
      }
    }
    .bootstrap-datetimepicker-widget.dropdown-menu:before,
    .bootstrap-datetimepicker-widget.dropdown-menu:after {
      content: '';
      display: inline-block;
      position: absolute;
    }
    .bootstrap-datetimepicker-widget.dropdown-menu.bottom:before {
      border-left: 7px solid transparent;
      border-right: 7px solid transparent;
      border-bottom: 7px solid #ccc;
      border-bottom-color: rgba(0, 0, 0, 0.2);
      top: -7px;
      left: 7px;
    }
    .bootstrap-datetimepicker-widget.dropdown-menu.bottom:after {
      border-left: 6px solid transparent;
      border-right: 6px solid transparent;
      border-bottom: 6px solid white;
      top: -6px;
      left: 8px;
    }
    .bootstrap-datetimepicker-widget.dropdown-menu.top:before {
      border-left: 7px solid transparent;
      border-right: 7px solid transparent;
      border-top: 7px solid #ccc;
      border-top-color: rgba(0, 0, 0, 0.2);
      bottom: -7px;
      left: 6px;
    }
    .bootstrap-datetimepicker-widget.dropdown-menu.top:after {
      border-left: 6px solid transparent;
      border-right: 6px solid transparent;
      border-top: 6px solid white;
      bottom: -6px;
      left: 7px;
    }
    .bootstrap-datetimepicker-widget.dropdown-menu.pull-right:before {
      left: auto;
      right: 6px;
    }
    .bootstrap-datetimepicker-widget.dropdown-menu.pull-right:after {
      left: auto;
      right: 7px;
    }
    .bootstrap-datetimepicker-widget .list-unstyled {
      margin: 0;
    }
    .bootstrap-datetimepicker-widget a[data-action] {
      padding: 6px 0;
    }
    .bootstrap-datetimepicker-widget a[data-action]:active {
      box-shadow: none;
    }
    .bootstrap-datetimepicker-widget .timepicker-hour,
    .bootstrap-datetimepicker-widget .timepicker-minute,
    .bootstrap-datetimepicker-widget .timepicker-second {
      width: 54px;
      font-weight: bold;
      font-size: 1.2em;
      margin: 0;
    }
    .bootstrap-datetimepicker-widget button[data-action] {
      padding: 6px;
    }
    .bootstrap-datetimepicker-widget .btn[data-action="incrementHours"]::after {
      position: absolute;
      width: 1px;
      height: 1px;
      margin: -1px;
      padding: 0;
      overflow: hidden;
      clip: rect(0, 0, 0, 0);
      border: 0;
      content: "Increment Hours";
    }
    .bootstrap-datetimepicker-widget .btn[data-action="incrementMinutes"]::after {
      position: absolute;
      width: 1px;
      height: 1px;
      margin: -1px;
      padding: 0;
      overflow: hidden;
      clip: rect(0, 0, 0, 0);
      border: 0;
      content: "Increment Minutes";
    }
    .bootstrap-datetimepicker-widget .btn[data-action="decrementHours"]::after {
      position: absolute;
      width: 1px;
      height: 1px;
      margin: -1px;
      padding: 0;
      overflow: hidden;
      clip: rect(0, 0, 0, 0);
      border: 0;
      content: "Decrement Hours";
    }
    .bootstrap-datetimepicker-widget .btn[data-action="decrementMinutes"]::after {
      position: absolute;
      width: 1px;
      height: 1px;
      margin: -1px;
      padding: 0;
      overflow: hidden;
      clip: rect(0, 0, 0, 0);
      border: 0;
      content: "Decrement Minutes";
    }
    .bootstrap-datetimepicker-widget .btn[data-action="showHours"]::after {
      position: absolute;
      width: 1px;
      height: 1px;
      margin: -1px;
      padding: 0;
      overflow: hidden;
      clip: rect(0, 0, 0, 0);
      border: 0;
      content: "Show Hours";
    }
    .bootstrap-datetimepicker-widget .btn[data-action="showMinutes"]::after {
      position: absolute;
      width: 1px;
      height: 1px;
      margin: -1px;
      padding: 0;
      overflow: hidden;
      clip: rect(0, 0, 0, 0);
      border: 0;
      content: "Show Minutes";
    }
    .bootstrap-datetimepicker-widget .btn[data-action="togglePeriod"]::after {
      position: absolute;
      width: 1px;
      height: 1px;
      margin: -1px;
      padding: 0;
      overflow: hidden;
      clip: rect(0, 0, 0, 0);
      border: 0;
      content: "Toggle AM/PM";
    }
    .bootstrap-datetimepicker-widget .btn[data-action="clear"]::after {
      position: absolute;
      width: 1px;
      height: 1px;
      margin: -1px;
      padding: 0;
      overflow: hidden;
      clip: rect(0, 0, 0, 0);
      border: 0;
      content: "Clear the picker";
    }
    .bootstrap-datetimepicker-widget .btn[data-action="today"]::after {
      position: absolute;
      width: 1px;
      height: 1px;
      margin: -1px;
      padding: 0;
      overflow: hidden;
      clip: rect(0, 0, 0, 0);
      border: 0;
      content: "Set the date to today";
    }
    .bootstrap-datetimepicker-widget .picker-switch {
      text-align: center;
    }
    .bootstrap-datetimepicker-widget .picker-switch::after {
      position: absolute;
      width: 1px;
      height: 1px;
      margin: -1px;
      padding: 0;
      overflow: hidden;
      clip: rect(0, 0, 0, 0);
      border: 0;
      content: "Toggle Date and Time Screens";
    }
    .bootstrap-datetimepicker-widget .picker-switch td {
      padding: 0;
      margin: 0;
      height: auto;
      width: auto;
      line-height: inherit;
    }
    .bootstrap-datetimepicker-widget .picker-switch td span {
      line-height: 2.5;
      height: 2.5em;
      width: 100%;
    }
    .bootstrap-datetimepicker-widget table {
      width: 100%;
      margin: 0;
    }
    .bootstrap-datetimepicker-widget table td,
    .bootstrap-datetimepicker-widget table th {
      text-align: center;
      border-radius: 4px;
    }
    .bootstrap-datetimepicker-widget table th {
      height: 20px;
      line-height: 20px;
      width: 20px;
    }
    .bootstrap-datetimepicker-widget table th.picker-switch {
      width: 145px;
    }
    .bootstrap-datetimepicker-widget table th.disabled,
    .bootstrap-datetimepicker-widget table th.disabled:hover {
      background: none;
      color: #777777;
      cursor: not-allowed;
    }
    .bootstrap-datetimepicker-widget table th.prev::after {
      position: absolute;
      width: 1px;
      height: 1px;
      margin: -1px;
      padding: 0;
      overflow: hidden;
      clip: rect(0, 0, 0, 0);
      border: 0;
      content: "Previous Month";
    }
    .bootstrap-datetimepicker-widget table th.next::after {
      position: absolute;
      width: 1px;
      height: 1px;
      margin: -1px;
      padding: 0;
      overflow: hidden;
      clip: rect(0, 0, 0, 0);
      border: 0;
      content: "Next Month";
    }
    .bootstrap-datetimepicker-widget table thead tr:first-child th {
      cursor: pointer;
    }
    .bootstrap-datetimepicker-widget table thead tr:first-child th:hover {
      background: #eeeeee;
    }
    .bootstrap-datetimepicker-widget table td {
      height: 54px;
      line-height: 54px;
      width: 54px;
    }
    .bootstrap-datetimepicker-widget table td.cw {
      font-size: .8em;
      height: 20px;
      line-height: 20px;
      color: #777777;
    }
    .bootstrap-datetimepicker-widget table td.day {
      height: 20px;
      line-height: 20px;
      width: 20px;
    }
    .bootstrap-datetimepicker-widget table td.day:hover,
    .bootstrap-datetimepicker-widget table td.hour:hover,
    .bootstrap-datetimepicker-widget table td.minute:hover,
    .bootstrap-datetimepicker-widget table td.second:hover {
      background: #eeeeee;
      cursor: pointer;
    }
    .bootstrap-datetimepicker-widget table td.old,
    .bootstrap-datetimepicker-widget table td.new {
      color: #777777;
    }
    .bootstrap-datetimepicker-widget table td.today {
      position: relative;
    }
    .bootstrap-datetimepicker-widget table td.today:before {
      content: '';
      display: inline-block;
      border: solid transparent;
      border-width: 0 0 7px 7px;
      border-bottom-color: #337ab7;
      border-top-color: rgba(0, 0, 0, 0.2);
      position: absolute;
      bottom: 4px;
      right: 4px;
    }
    .bootstrap-datetimepicker-widget table td.active,
    .bootstrap-datetimepicker-widget table td.active:hover {
      background-color: #337ab7;
      color: #fff;
      text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
    }
    .bootstrap-datetimepicker-widget table td.active.today:before {
      border-bottom-color: #fff;
    }
    .bootstrap-datetimepicker-widget table td.disabled,
    .bootstrap-datetimepicker-widget table td.disabled:hover {
      background: none;
      color: #777777;
      cursor: not-allowed;
    }
    .bootstrap-datetimepicker-widget table td span {
      display: inline-block;
      width: 54px;
      height: 54px;
      line-height: 54px;
      margin: 2px 1.5px;
      cursor: pointer;
      border-radius: 4px;
    }
    .bootstrap-datetimepicker-widget table td span:hover {
      background: #eeeeee;
    }
    .bootstrap-datetimepicker-widget table td span.active {
      background-color: #337ab7;
      color: #fff;
      text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
    }
    .bootstrap-datetimepicker-widget table td span.old {
      color: #777777;
    }
    .bootstrap-datetimepicker-widget table td span.disabled,
    .bootstrap-datetimepicker-widget table td span.disabled:hover {
      background: none;
      color: #777777;
      cursor: not-allowed;
    }
    .bootstrap-datetimepicker-widget.usetwentyfour td.hour {
      height: 27px;
      line-height: 27px;
    }
    .bootstrap-datetimepicker-widget.wider {
      width: 21em;
    }
    .bootstrap-datetimepicker-widget .datepicker-decades .decade {
      line-height: 1.8em !important;
    }
    .input-group.date .input-group-addon {
      cursor: pointer;
    }
    .sr-only {
      position: absolute;
      width: 1px;
      height: 1px;
      margin: -1px;
      padding: 0;
      overflow: hidden;
      clip: rect(0, 0, 0, 0);
      border: 0;
    }

    </style>
    <script type="text/javascript" src="../js/bootstrap-datetimepicker.min.js"></script>
</head>

<body style="background-color: #ecf0f5;">
    <div class="container" >
        <div class="row">
            <?php 
                    echo '
                    <div id="estrela_content">
                        <a href="../times/admintime.php?key='.$key.'">
                            <img src="../cadastro/uploads/'.$team_picture.'" class="estrela" style="width:100px;margin-left:30px; margin-right:30px; margin-bottom:0px;margin-top:-30px;">
                             <span style="font-family: \'Poiret One\', Arial, serif; font-size:25px; color:white;"><br>'.$short_name.'</span>
                        </a>
                    </div>';
            ?>
        </div>
    </div>  
    <section id="contact">
        <div class="section-content" style="text-align:center; margin-bottom:-30px;">
            <h1 class="section-header">Novo Treino / Amistoso</h1>
        </div>
    </section>
    <div class="container">
        
			<div class="row">
				<div class="col-lg-offset-1 col-lg-10" > 
					
					<div class="box box-primary">
						<div class="box-header with-border">
						  <h1 class="box-title"></h1>
						</div>
                        <div class="box-body">
                            <div class="row" style="margin-top:20px;">
                                <div style="overflow:hidden; text-align:center;">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-6 col-xs-offset-3">
                                                <h3 id="view-mode">Data e Hora</h3>
                                                <div id="datetimepicker12"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button class="btn btn-default" onclick="window.location.replace('../times/admincopa.php?key=<?php echo $key; ?>')" style="float:left;">Voltar</button>
                            <button class="btn btn-success" type="submit" style="float:right;" onclick="criar()">Salvar</button>
                        </div>
					</div>
				</div>
			</div>
    </div>
	
	 <script type="text/javascript">
        $(function () {
            $('#datetimepicker12').datetimepicker({
                inline: true,
                sideBySide: true,
                locale: 'pt-Br'
            });
        });
        function criar() {
            var select_fase = document.getElementById("fase");
            var fase = select_fase.options[select_fase.selectedIndex].value;
            
            var select_team1 = document.getElementById("team1");
            var team1 = select_team1.options[select_team1.selectedIndex].value;
            
            var select_team2 = document.getElementById("team2");
            var team2 = select_team2.options[select_team2.selectedIndex].value;
            
            var field = document.getElementById('novo_campo').value;
            if (field == ""){
                var select_field = document.getElementById("field");
                var field = select_field.options[select_field.selectedIndex].value;    
            }
            
            var datetime = moment($("#datetimepicker12").data("DateTimePicker").date()).format("YYYY-MM-DD HH:mm:00");
            
            if ((team1 == "")||(team2 == "")||(team1 == team2)){
                swal("Times indefinidos.", "Ambos os times tem de estar definidos e serem diferentes entre si.", "warning");
            } else{
                $.post("form_partida.php",{fase: fase, team1: team1, team2: team2, field: field, datetime:datetime, cup_id: <?php echo $id;?>},function(data){});    
                swal({
                      title: "Partida Criada!",
                      text: "Partida disponível para o público geral.",
                      type: "success",
                      closeOnConfirm: true
                    },
                    function(isConfirm) {
                      if (isConfirm) {window.location.replace("../times/admincopa.php?key=<?php echo $key; ?>");
                      };
                });  
            };
        };
    </script>
	
</body>

</html>