<?php
header('Cache-Control: no-cache, no-store, must-revalidate'); // HTTP 1.1.
header('Pragma: no-cache'); // HTTP 1.0.
header('Expires: 0'); // Proxies.
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $title; ?></title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link rel="shortcut icon" href="<?php echo base_url(); ?>dist/img/pin_publicidad.png" />
        <!-- Bootstrap 3.3.2 -->
        <link href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>bootstrap/css/bootstrap-slider.css" rel="stylesheet" type="text/css" />
        <!-- Font Awesome Icons -->
        <link href="<?php echo base_url(); ?>dist/css/font-awesome-4.3.0.css" rel="stylesheet" type="text/css" />
        <!-- fullCalendar 2.2.5-->
        <link href="<?php echo base_url(); ?>plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>plugins/fullcalendar/fullcalendar.print.css" rel="stylesheet" type="text/css" media='print' />
        <!-- Theme style -->
        <link href="<?php echo base_url(); ?>dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
        <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
        <link href="<?php echo base_url(); ?>dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
        <!-- Main.css -->
        <link href="<?php echo base_url(); ?>dist/css/Main.css" rel="stylesheet" type="text/css" />
        <!-- DataTables -->
        <script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>plugins/jQuery/jQuery-3.3.1.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>plugins/datatables/jquery.dataTables.min.js"></script>
        <link href="<?php echo base_url(); ?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
    </head>

<style>
		.fijo {
		position:fixed;
		z-index:1;
		}
		.rellenar {
			background: #333333;
			height: 107.5px;			
			width: 100%;
			float: left;
			top: 0;
		}
   </style>
	
<body style="background: #333333;" class="hold-transition skin-blue layout-top-nav">
<div class="rellenar fijo">
	<div class="container">
		<div class="row">
            <div class="col-xs-3 col-md-4">
				<a href="http://inicio.inai.org.mx" target="_blank">
					<img src="<?php echo base_url(); ?>data/logo/logotop.png" style="max-width: 100%; height: auto; margin-top:30.25px;" />
				</a>
            </div>
            <div class="col-xs-3 col-md-4">
				<a href="http://publicidadabierta.inai.org.mx/index.php/tpov1" target="_blank">
					<img src="<?php echo base_url() . 'dist/img/Publicidad.png' ?>" style="position: absolute; left: 0; right: 0; margin: auto; margin-top:23.75px; max-width: 100%; height: auto;"/>
				</a>
			</div>
        </div>
	</div>
        <header style="top:31.5px;" class="main-header">
            <nav class="navbar">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                            <i class="fa fa-bars"></i>
                        </button>
                    </div>
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                        <ul class="nav navbar-nav" style="text-align:center";>
							<li style="min-width:110px;" class="<?php if(@$active == 'inicio') { echo ' tpo_active'; } ?>"><a href="<?php echo base_url(); ?>index.php/tpov1/inicio">Inicio</a></li>
                            <li style="min-width:120px;" class="<?php if(@$active == 'presupuesto') { echo ' tpo_active'; } ?>"><a href="<?php echo base_url() . 'index.php/tpov1/presupuesto' ?>">Presupuesto</a></li>
                            <li style="min-width:140px;" class="<?php if(@$active == 'proveedores') { echo ' tpo_active'; } ?>"><a href="<?php echo base_url() . 'index.php/tpov1/proveedores' ?>">Gasto por proveedor</a></li>
							<li style="max-width:140px;" class="<?php if(@$active == 'gasto_tipo_servicio') { echo ' tpo_active'; } ?>"><a style="padding:6px;"  href="<?php echo base_url() . 'index.php/tpov1/gasto_tipo_servicio' ?>">Gasto por tipo de servicio</a></li>
                            <li style="max-width:150px;" class="<?php if(@$active == 'contratos_ordenes') { echo ' tpo_active'; } ?>"><a style="padding:6px;" href="<?php echo base_url() . 'index.php/tpov1/contratos_ordenes' ?>">Contratos y &oacute;rdenes de compra </a></li>
                            <li style="max-width:150px;" class="<?php if(@$active == 'campana_aviso') { echo ' tpo_active'; } ?>"><a style="padding:6px;" href="<?php echo base_url() . 'index.php/tpov1/campana_aviso' ?>"> Campa&ntilde;as y avisos institucionales</a></li>
                            <li style="min-width:145px;" class="<?php if(@$active == 'sujetos_obligados') { echo ' tpo_active'; } ?>"><a href="<?php echo base_url() . 'index.php/tpov1/sujetos_obligados' ?>">Sujetos obligados</a></li>
                            <li style="min-width:145px;" class="<?php if(@$active == 'erogaciones') { echo ' tpo_active'; } ?>"><a href="<?php echo base_url() . 'index.php/tpov1/erogaciones' ?>">Erogaciones</a></li>
						</ul>
                    </div>
                    <!-- /.navbar-collapse -->
                    <!-- Navbar Right Menu -->
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">             
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
</div>
</body>
<br><br><br><br><br><br><br>
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Full Width Column -->
        <div class="content-wrapper">
            <div class="container">
			<br>
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h6>
                        <?php echo $heading; ?>
                        <span><?php echo $heading_s; ?></span>
                    </h6>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url(); ?>index.php/tpov1/inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
                        <?php
                        
                            $bread = explode("|", $breadcrum);
                            $bread_l = explode("|", $breadcrum_l);
                            for($z = 0; $z < sizeof($bread); $z++)
                            {
                                echo '<li><a href="' . base_url() . 'index.php/tpov1/' . $bread_l[$z] . '">' . $bread[$z] . '</a></li>';
                            }
                        ?>
                            
                    </ol>
                </section>
        
                <!-- Main content -->
                <section class="content">