
    <?php
 
    header('Content-Type: text/html; charset=utf-8');
    session_start();

    ob_start();
    include('../admin/dbcon/dbcon.php');

    $match = mysqli_real_escape_string($mysqli,$_GET['match']);
    $sqlgeral = mysqli_query($mysqli,"SELECT c.* FROM cups c join matches m on c.id = m.cup_id where m.id='$match'");
    $dados_cup = mysqli_fetch_assoc($sqlgeral);
    $id = $dados_cup['id'];
    $name = $dados_cup['name'];

    $sqlcount_plays = mysqli_query($mysqli,"SELECT count(*) as total FROM plays where available in (1,2) and teams_name LIKE '%".$nome."%' ");
    $count_plays = mysqli_fetch_assoc($sqlcount_plays);
    $sql_anos = mysqli_query($mysqli,"SELECT YEAR(teams_schedule_date) as year FROM teams WHERE id_teams='$id'");
    $anos = mysqli_fetch_assoc($sql_anos);
    $sql_times = mysqli_query($mysqli,"SELECT * FROM teams where cup_id = '$id' order by teams_name");
    while ($data4 = mysqli_fetch_assoc($sql_times)) {
        $selecoes .= "<option value=".$data4['id_teams'].">".$data4['teams_name']."</option>" ;
    }
    $sql_campos = mysqli_query($mysqli,"SELECT * FROM fields where cup_id = '$id' order by fields_name");
    while ($data4 = mysqli_fetch_assoc($sql_campos)) {
        $selecoes_campos .= "<option value='".$data4['fields_name']."'>".$data4['fields_name']."</option>" ;
    }
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

    <title>Informações da Partidas - <?php echo $name; ?> - Esportes.Co</title>

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
    <section id="contact">
        <div class="section-content" style="text-align:center; margin-bottom:-30px; margin-top:-30px;">
            <h1><span class="content-header wow fadeIn " data-wow-delay="0.2s" data-wow-duration="2s" style="margin-left:-10px;"><?php echo $name; ?></span></h1>
            <h1 class="section-header">Informações da Partida</h1>
        </div>
    </section>
    <div class="container">
        <form action="../upload_video.php" method="post" enctype="multipart/form-data">
			<div class="row">
				<div class="col-lg-offset-1 col-lg-10" > 
					
					<div class="box box-primary">
						<div class="box-header with-border">
						  <h1 class="box-title"></h1>
						</div>

                        <div class="box-body">
                            <div class="row">
                                    <div class="form-group col-md-6" style="text-align:center;">
                                        <label for="title">Título</label>
                                        <input maxlength="80"  class="form-control" type="text" placeholder="Como você resumiria a partida?" id="title" name="title">
                                        <label for="subtitle"><br>Subtítulo</label>
                                        <input maxlength="130"  class="form-control" type="text" placeholder="Uma descrição mais completa, abaixo do título." id="subtitle" name="subtitle">
                                        <label for="live"><br>Link da transmissão (ao vivo)</label>
                                        <input maxlength="50"  class="form-control" type="text" placeholder="Coloque aqui o link da rádio/TV." id="live_link" name="live_link">
                                        <label for="author_name"><br>Autor</label>
                                        <input maxlength="20"  class="form-control" type="text" placeholder="Quem fez estas atualizações? Coloque sua marca aqui." id="author_name" name="author_name">
                                        <label for="author_link"><br>Link do Autor</label>
                                        <input maxlength="50"  class="form-control" type="text" placeholder="Quem fez estas atualizações? Coloque seu link aqui." id="author_link" name="author_link">
                                    </div>
                                    <div class="form-group col-md-6" style="text-align:center;">
                                         <?php 
                                            for ($x = 1; $x <= 5; $x++) {
                                                echo ' <div class="row">
                                                 <div class="col-sm-10">
                                                     <span class="fa-stack fa-3x">
                                                      <i class="fa fa-circle-thin fa-stack-2x"></i>
                                                      <strong class="fa-stack-1x calendar-text" style="margin-top:0px;">'.$x.'</strong>
                                                     </span>
                                                   </div>
                                                   <div class="col-sm-10">
                                                       <span>'.$x.'º Arquivo.<br></span>
                                                       <div class="form-group fileUpload">
                                                           <input id="files'.$x.'" type="file" accept="video/*" name="fileToUpload'.$x.'" id="fileToUpload'.$x.'"><br>
                                                       </div>
                                                   </div>
                                                 </div>';
                                            } 
                                        ?>
                                    </div>
                            </div>
                        </div>
                         <input type="hidden" name="match" value="<?php echo $match;?>"> 
                        <div class="box-footer">
                            <a class="btn btn-default" onclick="window.location.replace('../times/partida.php?id=<?php echo $match; ?>')" style="float:left;">Voltar</a>
                            <button class="btn btn-success" type="submit" style="float:right;">Salvar</button>
                        </div>
					</div>
				</div>
			</div>
        </form>
    </div>
	
</body>

</html>