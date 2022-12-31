<?php
  include("db.php");
  ///// Datos de usuarios//////////////
    if(!$_SESSION['nombre'])
    {
    session_destroy();
    header("location: ../index.php");
    }
    else
    {
    $nombre = $_SESSION['nombre'];
    $apellido = $_SESSION['apellido'];
    $tipo_us = $_SESSION['tipo_us'];
    $zona_us = $_SESSION['zona'];
    $tema_us = $_SESSION['tema'];
    $fuente_us = $_SESSION['fuente'];
    $icono_us = $_SESSION['icono'];
    }

    if( $_SESSION['recordar'] == 'SI' )
    {
      if( isset($_COOKIE['U']) && isset($_COOKIE['P']) )
      { }
      else
      {
        $encriptado_user = sha1($_SESSION['user']);
        $encriptado_pass = sha1($_SESSION['password']);
        setcookie("U", $encriptado_user, time()+3600*24*365);
        setcookie("P", $encriptado_pass, time()+3600*24*365);
      }
    }
    else
    { }
  ///// Datos de usuarios//////////////
  ///FECHA////
    $mes_header = date ('Y-m', strtotime('-0 month'));
  ///FECHA////
  ////RECLAMOS Y BAJAS////
    $query = "SELECT COUNT(ot) as 'bajasin' FROM bajas  WHERE tkl = '' and calendario like '$mes_header%' ORDER BY calendario desc";
    $result_tasks = mysqli_query($conn, $query);
    while($row = mysqli_fetch_assoc($result_tasks))
    { $bajasin= $row['bajasin'];} 

    $query1 = "SELECT COUNT(ot) as 'reclamosin' FROM reclamos WHERE solucion='Ninguna aun'";
    $result_tasks = mysqli_query($conn, $query1);
    while($row = mysqli_fetch_assoc($result_tasks))
    { $reclamosin = $row['reclamosin']; }
    $notitotal = $bajasin + $reclamosin; 
  ////RECLAMOS Y BAJAS////
  ////VEHICULO/////
    $query = "SELECT * FROM vehiculos ORDER BY patente desc";
    $result_tasks = mysqli_query($conn, $query);
    while($row = mysqli_fetch_assoc($result_tasks)) 
    { 
      $fecha_ultima = "20" .date ('y-m-d', strtotime('-0 days'));
      $fecha_media = "20" .date ('y-m-d', strtotime('+15 days'));
      /////VTV/////////
      $fecha_ven_vtv = $row['vtv'];
      if ($fecha_ven_vtv <= $fecha_media)
      {
        if($fecha_ven_vtv > $fecha_ultima)
        {                            
          $id = $row['id'];
          $query = "SELECT * FROM vehiculos WHERE id=$id";
          $result = mysqli_query($conn, $query);
          if (mysqli_num_rows($result) == 1)
          {
            $row = mysqli_fetch_array($result);                              
          }  
          $query = "UPDATE vehiculos set vigente = 'PROXIMO' WHERE id=$id";
          mysqli_query($conn, $query);         
        }
        else
        {
          $id = $row['id'];
          $query = "SELECT * FROM vehiculos WHERE id=$id";
          $result = mysqli_query($conn, $query);
          if (mysqli_num_rows($result) == 1)
          {
            $row = mysqli_fetch_array($result);                              
          } 
          $query = "UPDATE vehiculos set vigente = 'NO' WHERE id=$id";
          mysqli_query($conn, $query);
        }
      }
      /////SEGURO/////////
      $fecha_ven_seg = $row['seguro'];
      if ($fecha_ven_seg <= $fecha_media)
      {
        if($fecha_ven_seg > $fecha_ultima)
        {                            
          $id = $row['id'];
          $query = "SELECT * FROM vehiculos WHERE id=$id";
          $result = mysqli_query($conn, $query);
          if (mysqli_num_rows($result) == 1)
          {
            $row = mysqli_fetch_array($result);                              
          }
          $query = "UPDATE vehiculos set vigenteseg = 'PROXIMO' WHERE id=$id";
          mysqli_query($conn, $query);         
        }
        else
        {
          $id = $row['id'];
          $query = "SELECT * FROM vehiculos WHERE id=$id";
          $result = mysqli_query($conn, $query);
          if (mysqli_num_rows($result) == 1)
          {
            $row = mysqli_fetch_array($result);                              
          }
          $query = "UPDATE vehiculos set vigenteseg = 'NO' WHERE id=$id";
          mysqli_query($conn, $query);
        }
      }
    }
    $query1 = "SELECT COUNT(vigente) as 'novigente' FROM vehiculos WHERE vigente='NO'";
    $result_tasks = mysqli_query($conn, $query1);
    while($row = mysqli_fetch_assoc($result_tasks))
    { $novigente = $row['novigente']; }

    $query1 = "SELECT COUNT(vigente) as 'proximovigente' FROM vehiculos WHERE vigente='PROXIMO'";
    $result_tasks = mysqli_query($conn, $query1);
    while($row = mysqli_fetch_assoc($result_tasks))
    { $proximovigente = $row['proximovigente']; }

    $query1 = "SELECT COUNT(vigenteseg) as 'novigenteseg' FROM vehiculos WHERE vigenteseg='NO'";
    $result_tasks = mysqli_query($conn, $query1);
    while($row = mysqli_fetch_assoc($result_tasks))
    { $novigenteseg = $row['novigenteseg']; }

    $query1 = "SELECT COUNT(vigenteseg) as 'proximovigenteseg' FROM vehiculos WHERE vigenteseg='PROXIMO'";
    $result_tasks = mysqli_query($conn, $query1);
    while($row = mysqli_fetch_assoc($result_tasks))
    { $proximovigenteseg = $row['proximovigenteseg']; }
    $notivehiculototal = $novigente + $proximovigente + $novigenteseg + $proximovigenteseg;
  ////VEHICULO/////
?>
<!DOCTYPE html>
<html lang="es_ES">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-type" content="text/html;charset=UTF-8">
    <meta name="description" content="PGA, Portal de Gestion Argentseal, para el control y desarrollo especializado en tecnologia FTTH.">
    <meta name="keywords" content="argentseal, argent, PGA, FTTH, fibra optica, instalacion, relevamiento, gestion de materiales, control de stock, febra hasta el hogar, modem, access point, stb, claro, tecnico instalador, capacitacion FTTH, FO">
    <title>Argentseal</title>
    <link rel="stylesheet" type="text/css" href="/jquery-ui-1.12.1.custom/jquery-ui.css">
    <script src="/jquery-3.3.1.min.js"></script>
    <script src="/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
    <!-- <link rel="stylesheet" href="/jquery-ui-1.12.1.custom/style.css"> -->
    <meta name="MobileOptimized" content="width">
    <meta name="HandheldFriendly" content="true">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link rel="shortcut icon" type="image/png" href="/images/icon_1024.png">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link rel="apple-touch-icon" sizes="120x120" href="/images/icon_144.png" />
    <link rel="apple-touch-icon" sizes="152x152" href="/images/icon_512.png" />
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#343a40">
    <!--Bootstrap 4-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <!----Timepicker---->
    <link rel="stylesheet" type="text/css" href="/clockpicker.css">
    <!--- Font Awesome 5----->
    <link href="/fontawesome/css/all.css" rel="stylesheet">  
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">  
    <!--    Datatables  -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.css"/>  
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.6/css/fixedHeader.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.dataTables.min.css">
    <link rel="shortcut icon" href="https://www.argentseal.com.ar//vistas/images/favicon/favicon.ico" type="image/x-icon">
    <link href='/lib/fullcalendar/lib/main.css' rel='stylesheet'/>
    <script src='/lib/fullcalendar/lib/main.js'></script>
    <script src='/lib/fullcalendar/lib/locales/es.js'></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@400&family=Cormorant:wght@400&family=Fjalla+One&family=Vidaloka&family=Roboto:wght@400&display=swap" rel="stylesheet">
  </head>
  <script src="https://www.gstatic.com/firebasejs/8.4.1/firebase-app.js"></script>
  <script src="https://www.gstatic.com/firebasejs/8.4.1/firebase-analytics.js"></script>
  <script src="https://www.gstatic.com/firebasejs/8.4.1/firebase-messaging.js"></script>
  <script type="text/javascript" src="/firebase.js"></script>
  <script>
    if ('serviceWorker' in navigator)
    {
      navigator.serviceWorker.register('/firebase-messaging-sw.js')
      .then(reg => {
      console.log('Registro de SW exitoso', reg)
    })
      .catch(err => console.warn('Error al tratar de registrar el sw', err))
    }
  </script>
  
  <body id="body">
    <style>
      <?php
        switch ($fuente_us)
        {
            case 'Roboto':
                $fuente_bd = "'Roboto', sans-serif";
            break;
            case 'Josefin':
                $fuente_bd = "'Josefin Sans', sans-serif";
            break;
            case 'Fjalla':
                $fuente_bd = "'Fjalla One', sans-serif";
            break;
            case 'Vidaloka':
                $fuente_bd = "'Vidaloka', serif;";
            break;
        } ?>
        body{
            
            font-family: <?php echo $fuente_bd; ?> !important;
        }
    </style>
    <style type="text/css"> 
      thead tr th { 
        position: sticky;
        top: -2px;
        z-index: 10;
        border: #343a40 !important;
      }
      .table-responsive {
        overflow:scroll;
      }
      *::-webkit-scrollbar {
        width: 6px;
        height: 6px;
        background-color: #343a401f !important;
      }
      *::-webkit-scrollbar-track {
          -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
                  box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
          background-color: #343a401f !important;
      }
      *::-webkit-scrollbar-thumb {
          -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
                  box-shadow: inset 0 0 6px rgba(0,0,0,.3);
          background-color: #343a40 !important;
      }
      .navbarr{
        display: block !important;
        position: inherit !important;
        height: 5rem !important;
        margin-bottom: -6rem !important;
      }
      .border-left {
        border-width: 0.4rem !important;;
      }
      @media(max-width: 767px) {
        .fc-toolbar.fc-header-toolbar {
          display: flex;
          flex-direction: column;
        }
        .fc-toolbar.fc-header-toolbar .fc-left {
          order: 3;
        }
        .fc-toolbar.fc-header-toolbar .fc-center {
          order: 1;
        }
        .fc-toolbar.fc-header-toolbar .fc-right {
          order: 2;
        }
        .fc .fc-toolbar-title {
          font-size: 1.5em;
          margin: 0.6em;
        }
        .fc .fc-view-harness{
          height: 400px !important;
          min-height: 105px;
        }
      }
    </style>
    <nav class="navbar sticky-top navbar-expand-md navbar-dark bg-dark">
      <a class="navbar-brand pl-3" href="/inicio_administrador.php"><img src="/Image/argent.png" width="30" height="37" class="d-inline-block align-top" alt="" loading="lazy"></a>  
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
          <li class="nav-item dropdown active">
            <a class="nav-link dropdown-toggle " href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Deposito
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <!-----VISTA ADMINISTRADOR---->
                <?php if ($tipo_us == 'Administrador'){ ?>
                <a class="dropdown-item" href="../Basico/cargam.php">Herramientas</a>
                <a class="dropdown-item" href="../Basico/indumentaria.php">Indumentaria</a>
                <a class="dropdown-item" href="../Basico/ingresomaterial.php">Ingreso</a>            
                <a class="dropdown-item" href="../Basico/asignacion_materiales.php">Asignacion</a>
                <a class="dropdown-item" href="../Basico/descarga.php">Descarga</a>
                <a class="dropdown-item" href="../Basico/analisis_materiales.php">Materiales</a>
                <a class="dropdown-item" href="../Basico/devolucion.php">Devolucion</a>
                <a class="dropdown-item" href="../Basico/regularizacion.php">La salvacion</a>
                <?php } ?>
              <!-----VISTA ADMINISTRADOR---->  
              <!-----VISTA DESPACHO---->
                <?php if ($tipo_us == 'Despacho'){ ?>
                <a class="dropdown-item" href="../Basico/cargam.php">Herramientas</a>
                <a class="dropdown-item" href="../Basico/indumentaria.php">Indumentaria</a>
                <a class="dropdown-item" href="../Basico/ingresomaterial.php">Ingreso</a>            
                <a class="dropdown-item" href="../Basico/analisis_materiales.php">Materiales</a>
                <a class="dropdown-item" href="../Basico/devolucion.php">Devolucion</a>
                <a class="dropdown-item" href="../Basico/regularizacion.php">La salvacion</a>
                <?php } ?>
              <!-----VISTA DESPACHO---->
              <!-----VISTA SUPERVISOR---->
                <?php if ($tipo_us == 'Supervisor'){ ?>
                <a class="dropdown-item" href="../Basico/cargam.php">Herramientas</a>
                <a class="dropdown-item" href="../Basico/indumentaria.php">Indumentaria</a>            
                <a class="dropdown-item" href="../Basico/materiales.php">Materiales</a>
                <a class="dropdown-item" href="../Basico/devolucion.php">Devolucion</a>
                <?php } ?>
              <!-----VISTA SUPERVISOR---->
              <!-----VISTA DEPOSITO---->
                <?php if ($tipo_us == 'Deposito'){ ?>
                <a class="dropdown-item" href="../Basico/cargam.php">Herramientas</a>
                <a class="dropdown-item" href="../Basico/indumentaria.php">Indumentaria</a>
                <a class="dropdown-item" href="../Basico/ingresomaterial.php">Ingreso de materiales</a>          
                <a class="dropdown-item" href="../Basico/asignacion_materiales.php">Asignacion</a>
                <a class="dropdown-item" href="../Basico/descarga.php">Descarga</a>
                <a class="dropdown-item" href="../Basico/materiales.php">Materiales</a>
                <a class="dropdown-item" href="../Basico/devolucion.php">Devolucion</a>
                <a class="dropdown-item" href="../Basico/regularizacion.php">La salvacion</a>
                <?php } ?>
              <!-----VISTA DEPOSITO---->  
            </div>
          </li>
          <li class="nav-item dropdown active">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Control
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <!-----VISTA ADMINISTRADOR---->
                <?php if ($tipo_us == 'Administrador'){ ?>
                <a class="dropdown-item" href="../Basico/auditorias2.php">Auditorias</a>
                <!-- <a class="dropdown-item" href="../Basico/altas.php">Altas</a> -->
                <a class="dropdown-item" href="../Basico/altas2.php">Altas</a>
                <a class="dropdown-item" href="../Basico/cambiotec.php">Cambio de tecnologia</a>
                <a class="dropdown-item" href="../Basico/mtto.php">Mantenimientos</a>
                <a class="dropdown-item" href="../Basico/mtto2.php">Mantenimientos 2</a>
                <a class="dropdown-item" href="../Basico/bajas.php">Bajas</a>
                <a class="dropdown-item" href="../Basico/garantias.php">Garantias</a>
                <a class="dropdown-item" href="../Basico/reincidencias.php">Reincidencias</a>
                <a class="dropdown-item" href="../Basico/reclamos.php">Reclamos</a>
                <a class="dropdown-item" href="../Basico/vehiculos.php">Vehiculos</a>
                <?php } ?>
              <!-----VISTA ADMINISTRADOR---->
              <!-----VISTA DESPACHO---->
                <?php if ($tipo_us == 'Despacho'){ ?>
                <a class="dropdown-item" href="../Basico/auditorias2.php">Auditorias</a>
                <a class="dropdown-item" href="../Basico/altas2.php">Altas</a>
                <a class="dropdown-item" href="../Basico/cambiotec.php">Cambio de tecnologia</a>
                <a class="dropdown-item" href="../Basico/mtto.php">Mantenimientos</a>
                <a class="dropdown-item" href="../Basico/mtto2.php">Mantenimientos 2</a>
                <a class="dropdown-item" href="../Basico/bajas.php">Bajas</a>
                <a class="dropdown-item" href="../Basico/garantias.php">Garantias</a>
                <a class="dropdown-item" href="../Basico/reincidencias.php">Reincidencias</a>
                <a class="dropdown-item" href="../Basico/reclamos.php">Reclamos</a>
                <a class="dropdown-item" href="../Basico/vehiculos.php">Vehiculos</a>
                <?php } ?>
              <!-----VISTA DESPACHO---->
              <!-----VISTA SUPERVISOR---->
                <?php if ($tipo_us == 'Supervisor'){ ?>
                <a class="dropdown-item" href="../Basico/auditorias2.php">Auditorias</a>
                <a class="dropdown-item" href="../Basico/garantias.php">Garantias</a>
                <a class="dropdown-item" href="../Basico/reclamos.php">Reclamos</a>
                <a class="dropdown-item" href="../Basico/vehiculos.php">Vehiculos</a>
                <?php } ?>
              <!-----VISTA SUPERVISOR---->
              <!-----VISTA DEPOSITO---->
                <?php if ($tipo_us == 'Deposito'){ ?>
                <!-- <a class="dropdown-item" href="../Basico/altas.php">Altas</a> -->
                <a class="dropdown-item" href="../Basico/altas2.php">Altas</a>
                <a class="dropdown-item" href="../Basico/cambiotec.php">Cambio de tecnologia</a>
                <a class="dropdown-item" href="../Basico/mtto.php">Mantenimientos</a>
                <a class="dropdown-item" href="../Basico/mtto2.php">Mantenimientos 2</a>
                <a class="dropdown-item" href="../Basico/bajas.php">Bajas</a>
                <a class="dropdown-item" href="../Basico/garantias.php">Garantias</a>
                <a class="dropdown-item" href="../Basico/vehiculos.php">Vehiculos</a>
                <?php } ?>
              <!-----VISTA DEPOSITO---->
              <!-----VISTA VISOR---->
                <?php if ($tipo_us == 'Visor'){ ?>
                <a class="dropdown-item" href="../Basico/garantiasanalisis.php">Garantias</a>
                <a class="dropdown-item" href="../Basico/vehiculos.php">Vehiculos</a>
                <?php } ?>
              <!-----VISTA VISOR---->
            </div>
          </li>
          <li class="nav-item dropdown active">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Tecnicos
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <!-----VISTA ADMINISTRADOR---->
                <?php if ($tipo_us == 'Administrador'){ ?>
                <a class="dropdown-item" href="../Basico/datos.php">Datos</a>
                <a class="dropdown-item" href="../Basico/ayudantes.php">Ayudantes</a>
                <a class="dropdown-item" href="../Basico/inventario.php">Inventario</a>
                <a class="dropdown-item" href="../Basico/descuentos.php">Penalizaciones</a>
                <a class="dropdown-item" href="../Basico/no_conformidad.php">No conformidades</a>
                <a class="dropdown-item" href="../Basico/analisis.php">Analisis</a>
                <a class="dropdown-item" href="../Basico/liquidacion.php">Liquidacion</a>
                <a class="dropdown-item" href="../Basico/produccion.php">Produccion</a>
                <?php if($nombre == 'Damian' && $apellido == 'Duarte'){ ?>
                <a class="dropdown-item" href="../Basico/produccion2.php">Produccion 2</a>
                <a class="dropdown-item" href="../Basico/produccion3.php">Produccion 3</a>
                <?php } }?>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="../Basico/cierres_tareas.php">Cierre de tareas</a>
                <a class="dropdown-item" href="../Basico/portal_tec.php">Consultas tecnicas</a>
              <!-----VISTA ADMINISTRADOR---->
              <!-----VISTA DESPACHO---->
                <?php if ($tipo_us == 'Despacho'){ ?>
                <a class="dropdown-item" href="../Basico/datos.php">Datos</a>
                <a class="dropdown-item" href="../Basico/ayudantes.php">Ayudantes</a>
                <a class="dropdown-item" href="../Basico/inventario.php">Inventario</a>
                <a class="dropdown-item" href="../Basico/descuentos.php">Penalizaciones</a>
                <a class="dropdown-item" href="../Basico/no_conformidad.php">No conformidades</a>
                <a class="dropdown-item" href="../Basico/produccion.php">Produccion</a>
                <a class="dropdown-item" href="../Basico/analisis.php">Analisis</a>
                <a class="dropdown-item" href="../Basico/liquidacion.php">Liquidacion</a>
                <a class="dropdown-item" href="../Basico/b_calendario.php">Agenda</a><!----cambio Jorge----->
                <?php if($nombre == 'Jose' && $apellido == 'Lopez'){ ?>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="../Basico/cierres_tareas.php">Cierre de tareas</a>
                  <a class="dropdown-item" href="../Basico/portal_tec.php">Consultas tecnicas</a>
                <?php }?>
                <?php } ?>
              <!-----VISTA DESPACHO---->
              <!-----VISTA SUPERVISOR---->
                <?php if ($tipo_us == 'Supervisor'){ ?>
                <a class="dropdown-item" href="../Basico/datos.php">Datos</a>
                <a class="dropdown-item" href="../Basico/inventario.php">Inventario</a>
                <a class="dropdown-item" href="../Basico/descuentos.php">Penalizaciones</a>
                <a class="dropdown-item" href="../Basico/no_conformidad.php">No conformidades</a>
                <a class="dropdown-item" href="../Basico/analisis.php">Analisis</a>
                <?php } ?>
              <!-----VISTA SUPERVISOR---->
              <!-----VISTA DEPOSITO---->
                <?php if ($tipo_us == 'Deposito'){ ?>
                <a class="dropdown-item" href="../Basico/datos.php">Datos</a>
                <a class="dropdown-item" href="../Basico/inventario.php">Inventario</a>
                <a class="dropdown-item" href="../Basico/descuentos.php">Penalizaciones</a>
                <a class="dropdown-item" href="../Basico/analisis.php">Analisis</a>
                <a class="dropdown-item" href="../ATC/Basico/tecnicosatc.php">ATC</a>
                <?php } ?>
              <!-----VISTA DEPOSITO---->
              <!-----VISTA VISOR---->
                <?php if ($tipo_us == 'Visor'){ ?>
                <a class="dropdown-item" href="../Basico/analisis.php">Analisis</a>
                <?php } ?>
              <!-----VISTA VISOR---->
            </div>
          </li>
          <!-----VISTA ADMINISTRADOR---->
            <?php if ($tipo_us == 'Administrador'){ ?>
              <li class="nav-item dropdown active">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  General
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="../Basico/asistenciatotal.php">Asistencia total</a>
                  <a class="dropdown-item" href="../Basico/movimientos_internos.php">Movimientos internos</a>
                  <a class="dropdown-item" href="../Basico/usuarios.php">Usuarios</a>
                  <a class="dropdown-item" href="../Basico/herramientas.php">Herramientas</a>
                  <a class="dropdown-item" href="../Basico/precios.php">Precios</a>
                  <a class="dropdown-item" href="../Basico/desarrollo.php">Desarrollo</a>
                  <a class="dropdown-item" href="../Basico/b_calendario.php">Agenda</a>
                  <?php if($nombre == 'Damian' && $apellido == 'Duarte'){ ?>
                  <a class="dropdown-item" href="../Basico/toa.php">Datos TOA</a>
                  <?php } ?>
                  <a class="dropdown-item d-sm-block d-block d-md-none d-lg-none" href="../inicio_despacho.php">Vista despacho</a>
                  <a class="dropdown-item d-sm-block d-block d-md-none d-lg-none" href="../inicio_supervisor.php">Vista supervisor</a>
                  <a class="dropdown-item d-sm-block d-block d-md-none d-lg-none" href="../inicio_deposito.php">Vista deposito</a>
                </div>
              </li>
            <?php } ?>
          <!-----VISTA ADMINISTRADOR---->
          <!-----VISTA DESPACHO---->
            <?php if ($tipo_us == 'Despacho'){ ?>
              <li class="nav-item dropdown active">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  General
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="../Basico/asistenciatotal.php">Asistencia total</a>             
                  <a class="dropdown-item d-sm-block d-block d-md-none d-lg-none" href="../inicio_supervisor.php">Vista supervisor</a>
                  <a class="dropdown-item d-sm-block d-block d-md-none d-lg-none" href="../inicio_deposito.php">Vista deposito</a>
                </div>
              </li>
            <?php } ?>
          <!-----VISTA DESPACHO---->
          <!-- VISTA SUPERVISOR -->
            <?php if ($tipo_us == 'Supervisor'){ ?>
              <li class="nav-item dropdown active d-sm-block d-block d-md-none d-lg-none">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  General
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                  <?php if ($tipo_us == 'Supervisor' ){ ?>
                    <a class="dropdown-item d-sm-block d-block d-md-none d-lg-none" href="../inicio_deposito.php">Vista deposito</a>
                  <?php } ?>
                </div>
              </li>
            <?php } ?>
          <!-- VISTA SUPERVISOR -->
        </ul>
        <div class="row justify-content-start mt-3 mt-md-0">
          <div class="col-2 col-md-4">
            <!------BAJAS Y RECLAMOS------->
              <div class="<?php if ($notitotal>=1){echo "dropdown";}else{echo "";} ?>">
                <a class="nav-link text-white pr-0 pl-2 ml-2 mr-0 <?php if ($notitotal>=1){echo "dropdown-toggle";}else{echo "";} ?>  justify-content-between" href="#" id="noti" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-bell"></i>
                  <?php if ($notitotal>=1)
                  { ?>
                    <span class="badge badge-danger"><?php echo $notitotal; ?></span>
                  <?php } else { echo ""; } ?>
                </a>
                <div class="dropdown-menu" aria-labelledby="noti">
                  <?php if ($bajasin == 0)
                  { echo "";}
                  else
                  {?>        
                  <a class="dropdown-item" <?php if ($tipo_us == 'Visor'){ echo "";} else { echo ' href="../Basico/bajas.php" ';} ?> >Bajas  
                    <?php if ($bajasin == 0)
                    { echo "";}
                    else
                    {?>
                    <span class="badge badge-danger"><?php echo $bajasin; ?></span>
                    <?php ;}?>
                  </a>            
                  <?php ;}?> 
                  <!----------->
                  <?php if ($reclamosin == 0)
                  { echo "";}
                  else
                  {?>        
                  <a class="dropdown-item" <?php if ($tipo_us == 'Visor'){ echo "";} else { echo ' href="../Basico/reclamos.php" ';} ?> >Reclamos 
                    <?php if ($reclamosin == 0)
                    { echo "";}
                    else
                    {?>
                    <span class="badge badge-danger"><?php echo $reclamosin; ?></span>
                    <?php ;}?></a>             
                  <?php ;}?>          
                </div>
              </div>
            <!------BAJAS Y RECLAMOS------->
          </div>
          <div class="col-2 col-md-4">
            <!------VEHICULOS------->
              <div class="<?php if ($notivehiculototal>=1){echo "dropdown";}else{echo "";} ?>">
                <a class="nav-link text-white pr-0 pl-2 ml-0 mr-0 <?php if ($notivehiculototal>=1){echo "dropdown-toggle";}else{echo "";} ?>  justify-content-between" href="#" id="notivehiculo" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-car"></i>
                  <?php if ($notivehiculototal>=1)
                  { ?>
                    <span class="badge badge-danger"><?php echo $notivehiculototal; ?></span>
                  <?php } else { echo ""; } ?>
                </a>
                <div class="dropdown-menu" aria-labelledby="notivehiculo">
                  <?php if ($novigente == 0 && $proximovigente == 0)
                  { echo "";}
                  else
                  {?>        
                  <a class="dropdown-item" <?php if ($tipo_us == 'Visor'){ echo "";} else { echo ' href="../Basico/vehiculos.php" ';} ?> >VTV 
                    <?php if ($proximovigente == 0)
                    { echo "";}
                    else
                    {?>
                    <span class="badge badge-warning"><?php echo $proximovigente; ?></span>
                    <?php ;}?>             
                    <?php if ($novigente == 0)
                    { echo "";}
                    else
                    {?>
                    <span class="badge badge-danger"><?php echo $novigente; ?></span>
                    <?php ;}?></a>
                  <?php ;}?>
                  <!----------->
                  <?php if ($novigenteseg == 0 && $proximovigenteseg == 0)
                  { echo "";}
                  else
                  {?>        
                  <a class="dropdown-item" <?php if ($tipo_us == 'Visor'){ echo "";} else { echo ' href="../Basico/vehiculos.php" ';} ?> >Seguro 
                    <?php if ($proximovigenteseg == 0)
                    { echo "";}
                    else
                    {?>
                    <span class="badge badge-warning"><?php echo $proximovigenteseg; ?></span>
                    <?php ;}?>             
                    <?php if ($novigenteseg == 0)
                    { echo "";}
                    else
                    {?>
                    <span class="badge badge-danger"><?php echo $novigenteseg; ?></span>
                    <?php ;}?></a>
                  <?php ;}?>
                </div>
              </div>
            <!------VEHICULOS------->
          </div>
          <?php  $quien_msj = $_SESSION['nombre'] .' ' .$_SESSION['apellido']; ?>
            
            <div class="col-2 col-md-4">
              <?php 
                $message = mysqli_query($conn, "SELECT * FROM mensajes_tec WHERE tomado = '$quien_msj' AND estado = 'Abierto' OR estado = 'Abierto' AND tomado = '' GROUP BY tecnico");
                if (mysqli_num_rows($message) >= 1)
                {
                  $count_tec = mysqli_num_rows($message);
                }
              ?>
              <div>
                  <a class="nav-link text-white justify-content-between pr-0 pl-2 ml-0 mr-0" href="../Basico/mensajes.php">
                    <i class="fa-solid fa-comment <?php if($count_tec>=1){echo 'fa-shake';} else {echo '';} ?>"></i>
                    <?php
                      if ($count_tec>=1)
                      {
                    ?>
                      <span class="badge badge-danger"><?php echo $count_tec; ?></span>
                    <?php } else { echo ""; } ?>
                  </a>
              </div>
            </div>

        </div>
        <div class="row justify-content-start d-md-none d-lg-none mt-3">
          
          <div class="col-3">
            <a class="btn text-white" href="/Basico/push.php" aria-haspopup="true" aria-expanded="false">
              <i class="fa-regular fa-paper-plane"></i>
            </a>
          </div>
          <div class="col-3">
            <a class="nav-link justify-content-between text-white" role="button" data-toggle="modal" data-target="#buscador">
              <i class="fa-solid fa-magnifying-glass"></i>
            </a>
          </div>
          <div class="col-3">
            <a class="nav-link justify-content-between text-white" role="button" href="/Basico/tareas.php">
              <i class="fa-solid fa-list-check"></i>
            </a>
          </div>
          <div class="col-3">
            <?php if ($tipo_us == 'Deposito'){ ?>
              <a class="btn text-white" href="/Basico/b_calendario.php" aria-haspopup="true" aria-expanded="false">
                <i class="text-white fa-regular fa-calendar"></i>
              </a>
            <?php } ?>
            <?php if ($tipo_us == 'Supervisor'){ ?>
              <a class="btn text-white" href="/Basico/calendario.php" aria-haspopup="true" aria-expanded="false">
                <i class="text-white fa-regular fa-calendar"></i>
              </a>
            <?php } ?>
            <?php if ($tipo_us == 'Administrador' || $tipo_us == 'Despacho'){ ?>
              <a class="btn text-white" href="/Basico/calendario_despacho.php" aria-haspopup="true" aria-expanded="false">
                <i class="text-white fa-regular fa-calendar"></i>
              </a>
            <?php } ?>
          </div>
        </div>
        <div class="row justify-content-start mt-3 d-md-none d-lg-none">
          <div class="col-2 col-md-4 text-white dropdown">
            <a class="nav-link dropdown-toggle justify-content-between" id="user_mobile" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="<?php echo $icono_us; ?>"></i>
            </a>
            <div class="dropdown-menu" aria-labelledby="user_mobile">
              <div class="row justify-content-center">
                <a class="modal-title font-weight-bold text-center"><?php echo $nombre ." " .$apellido; ?></a>
              </div>
              <span class="dropdown-item font-weight-light text-center" type="button"><small><?php echo $tipo_us; ?></small></span>
              <div class="row justify-content-center">
                <a class="text-center h2">
                  <i class="<?php echo $icono_us; ?>"></i>
                </a>
              </div>
            
              <?php
                $result_tasks = mysqli_query($conn, "SELECT * FROM usuarios WHERE nombre = '$nombre' AND apellido = '$apellido' AND tipo_us = '$tipo_us' ");    
                while($row = mysqli_fetch_assoc($result_tasks))
                { ?>
                <a class="dropdown-item text-center" href="../Editar/edit_user.php?id=<?php echo $row['id']?>" type="button">Editar usuario</a>
                <div class="dropdown-divider"></div> 
                <?php if ($tipo_us == 'Administrador' || $tipo_us == 'Despacho'){ ?>
                  <div class="form-row justify-content-around">
                    <a href="../../corpo/indexcorpo.php" class="h1 text-success p-2"><i class="fas fa-user-tie"></i></a>
                    <a href="../../ATC/indexatc.php" class="h1 text-info p-2"><i class="fas fa-street-view"></i></a>
                  </div>
                  
                  <?php if($tipo_us == 'Administrador' || $nombre == 'Jose' && $apellido == 'Lopez'){ ?>
                    <div class="form-row justify-content-center">
                      <a class="h1 text-warning" data-toggle="modal" data-target="#cambio"><i class="fa-solid fa-people-arrows"></i></a>
                    </div>
                  <?php } ?>
                  <div class="dropdown-divider"></div>
                <?php } ?>
                <?php if ($tipo_us !== 'Administrador'){ ?>
                  <div class="row justify-content-center p-1">
                    <div class="col-auto text-center">
                      <form action="../Guardar/save_asistencia_interna.php" method="POST">
                        <input type="hidden" name="latitud" id="latitud_header_uno">
                        <input type="hidden" name="longitud" id="longitud_header_uno">
                        <button type="submit" name="fin" class="btn btn-success">Fin del dia</button>
                      </form>
                    </div>
                  </div>
                  <div class="dropdown-divider"></div>
                <?php } ?>
                <a class="dropdown-item text-center" href="../salir.php?id=<?php echo $row['id']?>" type="button">Cerrar sesion</a>
              <?php } ?>
            </div>
          </div>
          <div class="col-2 col-md-4 align-self-center">
            <!-- Modo oscuro -->
              <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="darkSwitchaa">
                <label class="custom-control-label" for="darkSwitchaa"></label>
              </div>
          </div>
        </div>

      </div>
      <span class=" d-sm-none d-none d-md-block d-lg-block float-right">
        <div class="btn-group text-white">
            <?php if($nombre == 'Damian' && $apellido == 'Duarte' || $nombre == 'Matias' && $apellido == 'Alancay') { ?>
              <a class="btn text-white" href="/Basico/push.php" aria-haspopup="true" aria-expanded="false">
                <i class="fa-regular fa-paper-plane"></i>
              </a>
            <?php } ?>
            <a class="btn text-white" data-toggle="modal" data-target="#buscador">
              <i class="fa-solid fa-magnifying-glass"></i>
            </a>
            <a class="btn text-white" href="/Basico/tareas.php" aria-haspopup="true" aria-expanded="false">
              <i class="fa-solid fa-list-check"></i>
            </a>
          <?php if ($tipo_us == 'Deposito' ){ ?>
            <a class="btn text-white" href="/Basico/b_calendario.php" aria-haspopup="true" aria-expanded="false">
              <i class="text-white fa-regular fa-calendar"></i>
            </a>
          <?php } ?>
          <?php if ($tipo_us == 'Administrador' || $tipo_us == 'Despacho' ){ ?>
            <a class="btn text-white" href="/Basico/calendario_despacho.php" aria-haspopup="true" aria-expanded="false">
              <i class="text-white fa-regular fa-calendar"></i>
            </a>
          <?php } ?>
          <?php if ($tipo_us == 'Supervisor'){ ?>
            <a class="btn text-white" href="/Basico/calendario.php" aria-haspopup="true" aria-expanded="false">
              <i class="text-white fa-regular fa-calendar"></i>
            </a>
          <?php } ?>
            <!-- Modo oscuro -->
              <div class="form-row align-items-center">
                <div class="col align-self-center">
                  <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="darkSwitch">
                    <label class="custom-control-label" for="darkSwitch"></label>
                  </div>
                </div>
              </div>
              <script>
                var darkSwitch=document.getElementById("darkSwitch");
                var darkSwitchaa=document.getElementById("darkSwitchaa");
                window.addEventListener("load",(function(){if(darkSwitch){
                  initTheme();darkSwitch.addEventListener("change",(function(){resetTheme()}))}}));
                window.addEventListener("load",(function(){if(darkSwitchaa){
                  initTheme();darkSwitchaa.addEventListener("change",(function(){resetThemee()}))}}));
                  function initTheme(){
                    var darkThemeSelected=localStorage.getItem("darkSwitch")!==null&&localStorage.getItem("darkSwitch")==="dark";
                    darkSwitch.checked=darkThemeSelected;darkThemeSelected?document.body.setAttribute("data-theme","dark"):document.body.removeAttribute("data-theme");
                    var darkThemeSelected=localStorage.getItem("darkSwitch")!==null&&localStorage.getItem("darkSwitch")==="dark";
                    darkSwitchaa.checked=darkThemeSelected;darkThemeSelected?document.body.setAttribute("data-theme","dark"):document.body.removeAttribute("data-theme")}
                  function resetTheme(){
                    if(darkSwitch.checked)
                    {document.body.setAttribute("data-theme","dark");
                    localStorage.setItem("darkSwitch","dark");
                    getElementById("darkSwitchaa").setAttribute("checked")}
                    else{document.body.removeAttribute("data-theme");localStorage.removeItem("darkSwitch")
                    getElementById("darkSwitchaa").removeAttribute("checked")}}

                  function resetThemee(){
                    if(darkSwitchaa.checked)
                    {document.body.setAttribute("data-theme","dark");
                    localStorage.setItem("darkSwitch","dark");
                    getElementById("darkSwitch").setAttribute("checked")}
                    else{document.body.removeAttribute("data-theme");localStorage.removeItem("darkSwitch")
                    getElementById("darkSwitch").removeAttribute("checked")}}
              </script>
            <!-- Modo oscuro -->
          <a class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="<?php echo $icono_us; ?>"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-right">
            <div class="form-row justify-content-center">
              <a class="modal-title font-weight-bold text-center"><?php echo $nombre ." " .$apellido; ?></a>
            </div>
            <a class="dropdown-item font-weight-light text-center" type="button"><small><?php echo $tipo_us; ?></small></a>
            <div class="form-row justify-content-center">
              <a class="text-center h2"><i class="<?php echo $icono_us; ?>"></i>
              </a>
            </div>
            <?php
              $result_tasks = mysqli_query($conn, "SELECT * FROM usuarios WHERE nombre = '$nombre' AND apellido = '$apellido' AND tipo_us = '$tipo_us' ");    
              while($row = mysqli_fetch_assoc($result_tasks))
              {
              ?>
              <a class="dropdown-item text-center" href="../Editar/edit_user.php?id=<?php echo $row['id']?>" type="button">Editar usuario</a>
              <div class="dropdown-divider"></div> 
              <?php if ($tipo_us == 'Administrador' || $tipo_us == 'Despacho'){ ?>
                <div class="form-row justify-content-around">
                  <a href="../../corpo/indexcorpo.php" class="h1 text-success p-2"><i class="fas fa-user-tie"></i></a>
                  <a href="../../ATC/indexatc.php" class="h1 text-info p-2"><i class="fas fa-street-view"></i></a>
                </div>
                <?php if($tipo_us == 'Administrador' || $nombre == 'Jose' && $apellido == 'Lopez'){ ?>
                  <div class="form-row justify-content-center">
                    <a class="h1 text-warning" type="button" data-toggle="modal" data-target="#cambio"><i class="fa-solid fa-people-arrows"></i></a>
                  </div>
                    
                <?php } ?>
                <div class="dropdown-divider"></div>
              <?php } ?>
              <?php if($tipo_us == 'Administrador'){ ?>
                <a class="dropdown-item text-center" href="../inicio_despacho.php" type="button">Vista despacho</a>
                <a class="dropdown-item text-center" href="../inicio_supervisor.php" type="button">Vista supervisor</a>
                <a class="dropdown-item text-center" href="../inicio_deposito.php" type="button">Vista deposito</a>
                <div class="dropdown-divider"></div>
              <?php } ?>
              <?php if($tipo_us == 'Despacho'){ ?>
                <a class="dropdown-item text-center" href="../inicio_supervisor.php" type="button">Vista supervisor</a>
                <a class="dropdown-item text-center" href="../inicio_deposito.php" type="button">Vista deposito</a>
                <div class="dropdown-divider"></div>
              <?php } ?>
              <?php if($tipo_us == 'Supervisor'){ ?>
                <a class="dropdown-item text-center" href="../inicio_deposito.php" type="button">Vista deposito</a>
                <div class="dropdown-divider"></div>
              <?php } ?>
              <?php if ($tipo_us !== 'Administrador'){ ?>
                <div class="row justify-content-center p-1">
                  <div class="col-auto text-center">
                    <form action="../Guardar/save_asistencia_interna.php" method="POST">
                      <input type="hidden" name="latitud" id="latitud_header_dos">
                      <input type="hidden" name="longitud" id="longitud_header_dos">
                      <button type="submit" name="fin" class="btn btn-success">Fin del dia</button>
                    </form>
                  </div>
                </div>
                <div class="dropdown-divider"></div>
              <?php } ?>
              <a class="dropdown-item text-center" href="../salir.php?id=<?php echo $row['id']?>" type="button">Cerrar sesion</a>
            <?php } ?>
          </div>
        </div>
      </span>
    </nav>
    <nav class="navbar navbarr navbar-expand-md navbar-dark bg-dark">
    </nav>
    <script>
      $(document).ready(function () {
        $('#buscador_find').on('keyup', function() /* CUANDO EN LA CLASE "buscador_find" */
        {
          var key = $(this).val(); /* GAURDAR EN LA VARIABLE "key" EL VALOR DE "buscador_find" */
          var dataString = 'key='+key;
          if(key == "")
          {
            //Hacemos desaparecer el resto de sugerencias cuando no halla nada escrito
            $('.resultados_find').fadeOut(500);
          }
          else
          {
            $.ajax({
              type: "POST",
              url: "../Ajax/a_buscador.php",
              data: dataString,
              success: function(data)
              {
                $('.resultados_find').fadeIn(500).html(data);
              }
            });
          };
        });
      });
    </script>
    <!-- Modal Search -->
      <div class="modal fade" id="buscador" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
          <div class="modal-content">
            <div class="modal-header text-center">
              <input class="form-control mr-sm-2" id="buscador_find" type="search" placeholder="Buscar...">
            </div>
            <div class="modal-body" style="max-height: 40rem;">
              <div class="row justify-content-center">
                <div class="col-auto p-1">
                  <div class="resultados_find"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <!-- Modal Search -->
    <style>
      [data-theme="dark"] {
        background-color: #191a1f !important;
        color: #eee;
      }
      [data-theme="dark"] .bg-light {
        background-color: #18191e !important;
      }
      [data-theme="dark"] .bg-white {
        background-color: #1e1f26 !important;
      }
      [data-theme="dark"] .bg-dark {
        background-color: #1b1b20  !important;
      }
      [data-theme="dark"] .navbar-dark {
        background-color: #14151a !important;
      }
      [data-theme="dark"] .text-muted {
        color: #c9c9c9 !important;
      }
      [data-theme="dark"] a {
        color: #ffffff !important;
      }
      [data-theme="dark"] .nav-tabs .nav-link.active {
        background-color: #0d0e11 !important;
        color: #dee2e6;
      }
      [data-theme="dark"] .dropdown-menu {
        background-color: #191a1f !important;
        border-color: #141414 !important;
      }
      [data-theme="dark"] .modal-content {
        background-color: #14151a !important;
      }
      [data-theme="dark"] .form-control {
        background-color: #101014 !important;
        color: #d7d7d7 !important;
        border-color: #16171d !important;
      }
      [data-theme="dark"] .card {
        background-color: #1b1c22 !important;
      }
      [data-theme="dark"] .dropdown-item:hover {
        background-color: #121317 !important;
      }
      [data-theme="dark"] .fc-theme-standard .fc-list-day-cushion {
        background-color: #14151a !important;
      }
      [data-theme="dark"] .table .thead-dark th {
        background-color: #14151a !important;
      }
      [data-theme="dark"] .table {
        color: #b3b3b3 !important;
      }
      [data-theme="dark"] .alert-success {
        background-color: #23903c !important;
        color: #eeeeee !important;
      }
      [data-theme="dark"] .alert-warning {
        background-color: #fff3cd !important;
        color: #856404 !important;
      }
      [data-theme="dark"] .table-striped tbody tr:nth-of-type(even) {
        background-color: #1e1f26 !important;
        color: #d9d9d9;
      }
      [data-theme="dark"] .table-striped tbody tr:nth-of-type(odd) {
        background-color: #14151a !important;
        color: #d9d9d9;
      }
      [data-theme="dark"] .table tbody tr .sticky {
        background: #1e1f26 !important;
      }
      [data-theme="dark"] .nav-link {
        background-color: #14151a ;
        color: #d7d7d7 !important;
      }
      [data-theme="dark"] .border-primary {
        border-color: #00346b !important;
      }
      [data-theme="dark"] .text-primary {
        color: #0056b3 !important;
      }
      [data-theme="dark"] .text-dark {
        color: #ffffff !important;
      }
      [data-theme="dark"] input:-webkit-autofill, input:-webkit-autofill:hover, input:-webkit-autofill:focus, input:-webkit-autofill:active {
        background-color: #18191e !important;
      }
      [data-theme="dark"] .toast {
        background-color: #18191e !important;
        color: #d7d7d7 ;
      }
      [data-theme="dark"] .toast-header {
        background-color: #18191e !important;
        color: #eeeeee !important;
      }
      [data-theme="dark"] .close {
        color: #eeeeee !important;
      }
      [data-theme="dark"] .table-bordered {
        border: 1px solid #1e1f26 !important;
      }
      [data-theme="dark"] .table-bordered td {
        border: 1px solid #525356 !important;
      }
      [data-theme="dark"] .table .thead-dark th {
        border: 1px solid #0c0c0c  !important;
      }
      [data-theme="dark"] .progress {
        background-color: #18191e !important;
      }
      [data-theme="dark"] .highcharts-background {
        fill: #1e1f26 !important;
      }
      [data-theme="dark"] tspan {
        fill: #eeeeee !important;
      }
      [data-theme="dark"] text {
        fill: #eeeeee !important;
      }
      [data-theme="dark"] .form-control[type="date"]::-webkit-calendar-picker-indicator {
        filter: invert(1);
      }
      [data-theme="dark"] table.dataTable.display tbody tr.even>.sorting_1, table.dataTable.order-column.stripe tbody tr.even>.sorting_1 {
        background-color: #1e1f26 !important;
        color: #d9d9d9 !important;
      }
      [data-theme="dark"] table.dataTable.display tbody tr.odd>.sorting_1, table.dataTable.order-column.stripe tbody tr.odd>.sorting_1 {
        background-color: #14151a !important;
        color: #d9d9d9 !important;
      }
      [data-theme="dark"] .dataTables_length, .dataTables_info, .dataTables_processing, .dataTables_paginate {
        color: #eeeeee !important;
      }
      [data-theme="dark"] .page-item.disabled .page-link {
        background-color: #18191e !important;
        color: #eeeeee !important;
        border-color: #4e555b;
      }
      [data-theme="dark"] .page-link {
        background-color: #18191e !important;
        color: #eeeeee !important;
        border-color: #4e555b;
      }
      [data-theme="dark"] .btn-secondary:not(:disabled):not(.disabled).active, .btn-secondary:not(:disabled):not(.disabled):active, .show>.btn-secondary.dropdown-toggle {
        background-color: #14151a !important;
        color: #eeeeee !important;
        border-color: #1e1f26;
      }
    </style>
    <script type="text/javascript">
      const funcionInit = () => {
        
      if (!"geolocation" in navigator) {
        return alert("Tu navegador no soporta el acceso a la ubicación. Intenta con otro");
      }

      const $latitud_header_uno = document.querySelector("#latitud_header_uno"),
        $longitud_header_uno = document.querySelector("#longitud_header_uno"),
        $latitud_header_dos = document.querySelector("#latitud_header_dos"),
        $longitud_header_dos = document.querySelector("#longitud_header_dos");

      const onUbicacionConcedida = ubicacion => {
        const coordenadas = ubicacion.coords;
        $ilatitud = coordenadas.latitude;
        $ilongitud = coordenadas.longitude;
        $("#latitud_header_uno").val($ilatitud);
        $("#longitud_header_uno").val($ilongitud);
        $("#latitud_header_dos").val($ilatitud);
        $("#longitud_header_dos").val($ilongitud);
      }

      const onErrorDeUbicacion = err => {
        $("#latitud_header_uno").val("No se obtuvo la coordenada");
        $("#longitud_header_uno").val("No se obtuvo la coordenada");
        $("#latitud_header_dos").val("No se obtuvo la coordenada");
        $("#longitud_header_dos").val("No se obtuvo la coordenada");
      }

      const opcionesDeSolicitud = {
        enableHighAccuracy: true, // Alta precisión
        maximumAge: 0, // No queremos caché
        timeout: 5000 // Esperar solo 5 segundos
      };

      navigator.geolocation.getCurrentPosition(onUbicacionConcedida, onErrorDeUbicacion, opcionesDeSolicitud);

      };
      document.addEventListener("DOMContentLoaded", funcionInit);
    </script>
    <!-- VISTA TECNICO -->
      <div class="modal fade" id="cambio" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Cambio de vista</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="/tecnico/index.php" method="POST">
                <div class="row">
                  <div class="col-12">
                    <label>Tecnico</label>
                    <select type="text" name="cambio_tecnico" class="form-control" required>
                      <option selected value="" disabled>Tecnicos...</option>
                      <?php
                        $ejj=mysqli_query($conn,"SELECT * FROM tecnicos WHERE tipo = 'Tecnico' AND activo ='SI' ORDER BY tecnico asc");
                        foreach ($ejj as $opp):
                      ?>   
                        <option value="<?php echo $opp['tecnico'] ?>"><?php echo $opp['tecnico'] ?></option>                                      
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                  <input type="submit" name="cambio" class="btn btn-success" value="Cambiar">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    <!-- VISTA TECNICO -->
<script src="/pwa.js"></script>