<?php
    header('Content-Type: text/html; charset=utf-8');
    session_start();

    ob_start();
    include('./admin/dbcon/dbcon.php');

    if (isset($_SESSION["logname"])) {
        $_SESSION["error1"] = "Please Sign in";
        header("Location: index.php");
    }
    $copa = $_GET['id'];

    $sqlgeral = mysqli_query($mysqli,"SELECT * FROM cups where id='$copa'");
    $dados = mysqli_fetch_assoc($sqlgeral);
    $name = $dados['name'];
    $mysqldate =  strtotime( $dados['date_limit'] );
    $date = date( 'Y/m/d', $mysqldate );

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $name ?> - Inscrições Esportes.Co</title>
        <?php 
        include_once("./head.html");
        ?>
        
        <style>
        .image-cropper {
            width: 32px;
            height: 32px;
            position: relative;
            overflow: hidden;
            -webkit-border-radius: 50%;
            -moz-border-radius: 50%;
            -ms-border-radius: 50%;
            -o-border-radius: 50%;
            border-radius: 50%;
            margin-top:-5px;
        }
        .img_perfil {
            display: inline;
            margin: 0 auto;
            height: 100%;
            width: auto;
            border-radius: 32px;
            border: 2px solid #FFFFFF;
            width: 32px;
            height: 32px; 
        }
        </style>
    </head>
    <body class="pace-on pace-dot">
        <?php 
        include_once("./admin/analyticstracking.php");
        include_once("./navbar2.php");
        ?>
       
        <div id="content" role="main">
            <section class="section swatch-white-red has-top">
                <div class="decor-top">
                    <svg class="decor" height="100%" preserveaspectratio="none" version="1.1" viewbox="0 0 100 100" width="100%" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 100 L50 0 L100 100" stroke-width="0"></path>
                    </svg>
                </div>
                
                <div class="container">
                    <header class="section-header ">
                        <h1 class="headline super hairline"><?php echo $name ?></h1>
                    </header>
                    <div class="row">
                        <h1 class="countdown hyper hairline" data-date="<?php echo $date; ?>  00:00">
                          <div class="counter-element">
                            <span class="counter-days odometer"></span>
                            <b>
                              dias
                            </b>
                          </div>
                          <div class="counter-element">
                            <span class="counter-hours odometer"></span>
                            <b>
                              horas
                            </b>
                          </div>
                          <div class="counter-element">
                            <span class="counter-minutes odometer"></span>
                            <b>
                              minutos
                            </b>
                          </div>
                          <div class="counter-element">
                            <span class="counter-seconds odometer"></span>
                            <b>
                              segundos
                            </b>
                          </div>
                        </h1>
                        <div class="col-md-12  text-default">
                            <div class="text-center">
                                <a href="../cadastro/time.php?id=<?php echo $copa;?>" class="btn btn-danger btn-lg text-center btn-icon-right" target="_self">Inscrever meu time
                                    <span class="hex-alt">
                                        <i class="fa fa-group" data-animation="tada"></i>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
            <footer id="footer" role="contentinfo">
                <section class="section swatch-red-white has-top">
                    <div class="decor-top">
                        <svg class="decor" height="100%" preserveaspectratio="none" version="1.1" viewbox="0 0 100 100" width="100%" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 0 L50 100 L100 0 L100 100 L0 100" stroke-width="0"></path>
                        </svg>
                    </div>
                    <div class="container" style="text-align:center;">
                        <header class="section-header ">
                            <h1 class="headline super hairline">Compartilhe</h1>
                        </header>
                        <div class="addthis_inline_share_toolbox" style="margin-top:100px;"></div>
                    </div>
                </section>
            </footer>
            <a class="go-top hex-alt" href="javascript:void(0)">
                <i class="fa fa-angle-up"></i>
            </a>
            <script src="novo/assets/js/packages.min.js"></script>
            <script src="novo/assets/js/theme.min.js"></script>
            
        </div> 
        <!-- Go to www.addthis.com/dashboard to customize your tools --> <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5203771652a333c5"></script> 
    </body>
</html>
