<header id="masthead" class="navbar navbar-sticky navbar-stuck swatch-red-white" role="banner"
        <?php if (isset($copa)){ echo 'style="margin-left:-13px; margin-right:-13px;"';}?>>
    <div class="container">
        <div class="navbar-header">
            <?php if (isset($nome_copa)) {
                echo '
                <a href="./copa.php?id='.$copa.'">       
                    <span style="font-size:18px; margin-top:13px; margin-left:10px; position:absolute; font-family:\'Oleo Script\', cursive;">'.$nome_copa.'</span> 
                </a>';
            }?>
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".main-navbar"><span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span>
            </button>
        </div>
        <nav class="navbar-collapse main-navbar collapse" role="navigation" aria-expanded="false" style="height: 1px;">
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="http://www.esportes.co/index.php" class="dropdown-toggle"><i class="fa fa-newspaper-o" aria-hidden="true"></i> Notícias
                    </a>
                </li>
                <li class="dropdown menu-item-object-oxy_mega_menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                         <i class="fa fa-trophy" aria-hidden="true"></i> Campeonatos
                    </a>
                    <ul class="dropdown-menu row">
                        <li class="dropdown col-md-4 menu-item-object-oxy_mega_columns">
                            <strong>Futebol de Campo</strong>
                            <ul role="menu">
                                <li>
                                    <a href="http://www.esportes.co/times/copa.php?id=17">Série A - LBF</a>
                                </li>
                                <li>
                                    <a href="http://www.esportes.co/times/copa.php?id=86">Série Ouro - Vinhedo</a>
                                </li>
                                <li>
                                    <a href="http://www.esportes.co/times/copa.php?id=103">Série Prata - Vinhedo</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown col-md-4 menu-item-object-oxy_mega_columns"><strong>Futebol Society</strong>
                            <ul role="menu">
                                <li>
                                    <a href="http://www.esportes.co/times/copa.php?id=1">15º Copa Benteler</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown col-md-4 menu-item-object-oxy_mega_columns">
                            <strong>Futsal</strong>
                            <ul role="menu">
                                <li>
                                    <a href="http://www.esportes.co/times/copa.php?id=116">Copa Vinhedo de Futsal Feminino</a>
                                </li>
                                <li>
                                    <a href="http://www.esportes.co/times/copa.php?id=23">Liga Futsal Rioclarense Masculino</a>
                                </li>
                                <li>
                                    <a href="http://www.esportes.co/times/copa.php?id=24">Liga Futsal Rioclarense Feminino</a>
                                </li>
                               
                                <li style="">
                                    <a href="http://www.esportes.co/cadastro/campeonato.php" class="btn btn-primary btn-lg  btn-icon-right" target="_self" style="float:right; text-align:left; margin-bottom:5px; width:150px; height:48px; margin-left:-25px;line-height:30px;">Lançar Novo
                                        <span class="hex-alt">
                                            <i class="fa fa-plus" data-animation="swing"></i>
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                 <li class="dropdown">
                    <a href="http://www.esportes.co/sobre.php" class="dropdown-toggle">
                        <i class="fa fa-heartbeat" aria-hidden="true"></i> Sobre
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</header>