<?php
    session_start(); 
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
<div class="pace-overlay"></div>
<header id="masthead" class="navbar navbar-sticky swatch-red-white" role="banner">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".main-navbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="http://www.esportes.co/index.php" class="navbar-brand">
                <img src="http://www.esportes.co/img/logo_transp.png" style="width:50px;">Esportes.Co
            </a>
        </div>
        <nav class="collapse navbar-collapse main-navbar" role="navigation">
            <div class="sidebar-widget widget_search pull-right">
            </div>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="organizadores.php">Adicione sua Liga</a> 
                </li>
                <li><a href="http://www.esportes.co/blog.php">Blog</a> 
                </li>
                <li>
                    <?php if ($_SESSION['FBID']): ?>      <!--  After user login  -->
                    <a href="http://www.esportes.co/1353/logout.php">
                        <div class="image-cropper">
                            <img src="https://graph.facebook.com/<?php echo $_SESSION['FBID']; ?>/picture" class="img_perfil"/>
                        </div>
                    </a>
                    <?php else: ?>     <!-- Before login --> 
                       <a href="http://www.esportes.co/1353/fbconfig.php">Entrar</a>
                    <?php endif ?>
                </li>
            </ul>
        </nav>
    </div>
</header>