<?php include("../db.php"); ?> 
<?php $mes = "20" .date ('y-m', strtotime('-0 month'));?>
 <?php 
  $query = "SELECT COUNT(ot) as 'bajasin' FROM bajas  WHERE tkl = '' and calendario like '%$mes%' ORDER BY calendario desc";
  $result_tasks = mysqli_query($conn, $query);
  while($row = mysqli_fetch_assoc($result_tasks))
  { $bajasin= $row['bajasin'];} ?>
<?php
  $query1 = "SELECT COUNT(ot) as 'reclamosin' FROM reclamos WHERE solucion='Ninguna aun'";
  $result_tasks = mysqli_query($conn, $query1);
  while($row = mysqli_fetch_assoc($result_tasks))
  { $reclamosin = $row['reclamosin']; }
?>
<?php $notitotal = $bajasin + $reclamosin; ?>
<!DOCTYPE html>
<html lang="es_ES">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Argentseal</title><!--titulo de pestaña-->

  <link rel="stylesheet" type="text/css" href="../jquery-ui-1.12.1.custom/jquery-ui.css">
  <link rel="stylesheet" href="jquery-ui-1.12.1.custom/style.css">
  <script src="../jquery-3.3.1.min.js"></script>
  <script src="../jquery-ui-1.12.1.custom/jquery-ui.js"></script>
  <!--Bootstrap 4-->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <!----Timepicker---->
  <link rel="stylesheet" type="text/css" href="../clockpicker.css">
  <!--- Font Awesome 5----->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"
  integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/"
  crossorigin="anonymous">  
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">  
  <!--    Datatables  -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.css"/>  
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
  <link rel="" href="https://cdn.datatables.net/fixedheader/3.1.6/css/fixedHeader.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.dataTables.min.css">
  
  
  <title>Argentseal</title>                    <!--titulo de pestaña-->
  <link rel="shortcut icon" type="image/png" href=”../Image/argent.ico” >
</head>
<body>
  <nav class="navbar sticky-top navbar-expand-md navbar-dark bg-dark">
    <img src="/Image/argent.png" width="30" height="37" class="d-inline-block align-top" alt="" loading="lazy">
    <a class="navbar-brand pl-3" href="../index.php">Argentseal</a>  
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        
        <li class="nav-item dropdown active">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Deposito
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="../Basico/cargam.php">Herramientas</a>
            <a class="dropdown-item" href="../Basico/indumentaria.php">Indumentaria</a>
            
            <a class="dropdown-item" href="../Basico/descarga.php">Asignacion</a>
            <a class="dropdown-item" href="../Basico/asignacion.php">Devolucion</a>           
          </div>
        </li>
        <li class="nav-item dropdown active">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Control
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="../Basico/altas.php">Altas</a>
            <a class="dropdown-item" href="../Basico/cambiotec.php">Cambio de tecnologia</a>
            <a class="dropdown-item" href="../Basico/mtto.php">Mantenimientos</a>
            <a class="dropdown-item" href="../Basico/bajas.php">Bajas</a>
            <a class="dropdown-item" href="../Basico/garantias.php">Garantias</a>
            <a class="dropdown-item" href="../Basico/reclamos.php">Reclamos</a>
          </div>
        </li>
        <li class="nav-item dropdown active">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Tecnicos
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="../Basico/datos.php">Datos</a>
            <a class="dropdown-item" href="../Basico/inventario.php">Inventario</a>
            <a class="dropdown-item" href="../Basico/descuentos.php">Penalizaciones</a>
            <a class="dropdown-item" href="../Basico/produccion.php">Produccion</a>
            <a class="dropdown-item" href="../Basico/analisis.php">Analisis</a>
            <a class="dropdown-item" href="../Basico/liquidacion.php">Liquidacion</a>
          </div>
        </li>
         <li class="nav-item <?php if ($notitotal>=1){echo "dropdown";}else{echo "";} ?> active ">
          <a class="nav-link <?php if ($notitotal>=1){echo "dropdown-toggle";}else{echo "";} ?>  justify-content-between" href="#" id="noti" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-bell"></i>
            <span class="badge badge-danger"><?php echo $notitotal; ?></span>
          </a>
          <div class="dropdown-menu" aria-labelledby="noti">            
            <?php if ($bajasin == 0){ echo "";} else {?>        
            <a class="dropdown-item" href="../Basico/bajas.php">Bajas <span class="badge badge-danger"><?php echo $bajasin; ?></span></a><?php ;}?>
            <?php if ($reclamosin == 0){ echo "";} else {?>        
            <a class="dropdown-item" href="../Basico/reclamos.php">Reclamos <span class="badge badge-danger"><?php echo $reclamosin; ?></span></a><?php ;}?>
        </div>
      </li>
      
        </ul>
    </div>




     
<div class="nav-link align-content-center text-light" aria-disabled="true">
	<ul class="navbar-nav justify-content-end">
   		 <li class="nav-item dropleft dropdown active">
          <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Notas
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="../Basico/datos.php">Datos</a>
            <a class="dropdown-item" href="#">

         <?php
            $query = "SELECT * FROM bajas  WHERE calendario like '%$mes%' ORDER BY calendario desc LIMIT 5";
            $result_tasks = mysqli_query($conn, $query);
            while($row = mysqli_fetch_assoc($result_tasks)) {     
                 echo $row['tecnico']; ?>
                 </a>             
            <?php } ?>
           
				

        </li>
	</ul>
</div>
   
      
    
    <span class="nav-link disabled align-content-xl-center text-light d-none d-sm-none d-md-none d-lg-block" aria-disabled="true"><?php
    $miFecha= gmmktime($today);
    setlocale(LC_TIME,"es_ES");
    echo strftime("%d de %B %Y", $miFecha);?>
  </span>
</nav>



	<form action="upload.php" method="POST" enctype="multipart/form-data">
		<input type="file" name="file" id="file">
		<br>
		<input type="submit" name="btenviar" id="btenviar">
	</form>
</body>




<!-- PIE DE PAGINA -->

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<!-- then Popper -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<!-- Bootstrap -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<!-- Datatable -->
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<!-- Filtro por columnas -->
<script src="https://cdn.datatables.net/fixedheader/3.1.6/js/dataTables.fixedHeader.min.js"></script> 
</body>
</html>