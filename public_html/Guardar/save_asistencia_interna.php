<?php
  include('../db.php');
  session_start();
  if(!$_SESSION['nombre'])
  {
  session_destroy();
  header("location: ../index.php");
  exit();
  }
  $nombre_us = $_SESSION['nombre'];
  $apellido_us = $_SESSION['apellido'];
  $tipo_us = $_SESSION['tipo_us'];
  $zona_us = $_SESSION['zona'];
  $quien_notas = $nombre_us .' ' .$apellido_us;
  if($tipo_us == "Administrador") { $usu = 1; }
  if($tipo_us == "Despacho") { $usu = 1; }
  if($tipo_us == "Supervisor") { $usu = 1; }
  if($tipo_us == "Deposito") { $usu = 1; }
  if($usu != 1)
  {
    header("location: ../index.php");
  }

  if (isset($_POST['inicio']))
  {
    $token = uniqid();
    $hoy_es = date("Y-m-j");
    $hoy = date("Y-m-j");

    $latitud = $_POST['latitud'];
    $longitud = $_POST['longitud'];

    $a = date("l j m", strtotime($hoy));
    $b = explode(" ", $a);
    $c = $b[0];
    if($c == 'Saturday')
    {
      $tipo_dia = "Sabado";
    }
    else
    {
      $tipo_dia = "Normal";
    }

    $asis = mysqli_query($conn, "SELECT * FROM movimiento_interno WHERE quien = '$quien_notas' AND movimiento = 'Inicio' AND pag = '' AND inicio LIKE '$hoy_es%' ");
    if(mysqli_num_rows($asis) > 0)
    {
      $_SESSION['card'] = 1;
      $_SESSION['titulo_toast'] = 'Guardado';
      $_SESSION['mensaje_toast'] = 'El inicio del dia ya habia sido registrado';
      $_SESSION['color_toast'] = 'warning';

      switch ($tipo_us)
      {
        case 'Administrador': header('Location: ../inicio_administrador.php');
        break;
        case 'Despacho': header('Location: ../inicio_despacho.php');
        break;
        case 'Supervisor': header('Location: ../inicio_supervisor.php');
        break;
        case 'Deposito': header('Location: ../inicio_deposito.php');
        break;
      }
    }
    else
    {

      $r = mysqli_query($conn, "INSERT INTO movimiento_interno(token, quien, movimiento, inicio, dia, tipo, zona, latitud, longitud) VALUES ('$token', '$quien_notas','Inicio', '$hoy', '$tipo_dia', '$tipo_us', '$zona_us', '$latitud', '$longitud')");
      if(!$r)
      {
        $titulo_toast = "Error";
        $msj_toast = "Hubo un error interno al guardar el proceso";
        $color_toast = "danger";
      }
      else
      {
        $titulo_toast = "Guardado";
        $msj_toast = "La asistencia fue guardada correctamente.";
        $color_toast = "success";
      }


      $_SESSION['card'] = 1;
      $_SESSION['titulo_toast'] = $titulo_toast;
      $_SESSION['mensaje_toast'] = $msj_toast;
      $_SESSION['color_toast'] = $color_toast;

      switch ($tipo_us)
      {
        case 'Administrador': header('Location: ../inicio_administrador.php');
        break;
        case 'Despacho': header('Location: ../inicio_despacho.php');
        break;
        case 'Supervisor': header('Location: ../inicio_supervisor.php');
        break;
        case 'Deposito': header('Location: ../inicio_deposito.php');
        break;
      }

    }
  }

  if (isset($_POST['fin']))
  {
    $token = uniqid();
    $hoy_es = date("Y-m-j");
    $hoy = date("Y-m-j");

    $latitud = $_POST['latitud'];
    $longitud = $_POST['longitud'];

    $a = date("l j m", strtotime($hoy));
    $b = explode(" ", $a);
    $c = $b[0];
    if($c == 'Saturday')
    {
      $tipo_dia = "Sabado";
    }
    else
    {
      $tipo_dia = "Normal";
    }

    $asis = mysqli_query($conn, "SELECT * FROM movimiento_interno WHERE quien = '$quien_notas' AND movimiento = 'Fin' AND pag = '' AND inicio LIKE '$hoy_es%' ");
    if(mysqli_num_rows($asis) > 0)
    {
      $_SESSION['card'] = 1;
      $_SESSION['titulo_toast'] = 'Guardado';
      $_SESSION['mensaje_toast'] = 'El fin del dia ya habia sido registrado';
      $_SESSION['color_toast'] = 'warning';

      switch ($tipo_us)
      {
        case 'Administrador': header('Location: ../inicio_administrador.php');
        break;
        case 'Despacho': header('Location: ../inicio_despacho.php');
        break;
        case 'Supervisor': header('Location: ../inicio_supervisor.php');
        break;
        case 'Deposito': header('Location: ../inicio_deposito.php');
        break;
      }
    }
    else
    {

      $r = mysqli_query($conn, "INSERT INTO movimiento_interno(token, quien, movimiento, inicio, dia, tipo, zona, latitud, longitud) VALUES ('$token', '$quien_notas','Fin', '$hoy', '$tipo_dia', '$tipo_us', '$zona_us', '$latitud', '$longitud')");
      if(!$r)
      {
        $titulo_toast = "Error";
        $msj_toast = "Hubo un error interno al guardar el proceso";
        $color_toast = "danger";
      }
      else
      {
        $titulo_toast = "Guardado";
        $msj_toast = "La asistencia fue guardada correctamente.";
        $color_toast = "success";
      }

      $_SESSION['card'] = 1;
      $_SESSION['titulo_toast'] = $titulo_toast;
      $_SESSION['mensaje_toast'] = $msj_toast;
      $_SESSION['color_toast'] = $color_toast;

      switch ($tipo_us)
      {
        case 'Administrador': header('Location: ../inicio_administrador.php');
        break;
        case 'Despacho': header('Location: ../inicio_despacho.php');
        break;
        case 'Supervisor': header('Location: ../inicio_supervisor.php');
        break;
        case 'Deposito': header('Location: ../inicio_deposito.php');
        break;
      }
    }
  }

  if (isset($_POST['no_registrar']))
  {
    switch ($tipo_us)
    {
      case 'Administrador': header('Location: ../inicio_administrador.php');
      break;
      case 'Despacho': header('Location: ../inicio_despacho.php');
      break;
      case 'Supervisor': header('Location: ../inicio_supervisor.php');
      break;
      case 'Deposito': header('Location: ../inicio_deposito.php');
      break;
    }
  }

  if (isset($_POST['edicion']))
  {
      $token = $_POST['token'];
      $dia= $_POST['dia'];
      $obs = $_POST['obs'];
      
      $r = mysqli_query($conn, "UPDATE movimiento_interno set dia = '$dia', obs = '$obs' WHERE token = '$token' ");
      if(!$r)
      {
        $titulo_toast = "Error";
        $msj_toast = "Hubo un error interno al borrar el proceso";
        $color_toast = "danger";
      }
      else
      {
        $titulo_toast = "Actualizado";
        $msj_toast = "El movimiento fue actualizado";
        $color_toast = "warning";
      }
      $_SESSION['card'] = 1;
      $_SESSION['titulo_toast'] = $titulo_toast;
      $_SESSION['mensaje_toast'] = $msj_toast;
      $_SESSION['color_toast'] = $color_toast;
      header('Location: ../Basico/movimientos_internos.php');
    
  }

  if (isset($_POST['nuevo']))
  {
    $token = uniqid();
    $usuario= $_POST['usuario'];
    $b = explode(" ", $usuario);
    $nombre = $b[0];
    $apellido = $b[1];
    $fecha= $_POST['fecha'];
    $hoy = date("Y-m-j");
    $dia= $_POST['dia'];
    $obs = $_POST['obs'];

    $aa = mysqli_query($conn, "SELECT * FROM usuarios WHERE nombre = '$nombre' AND apellido = '$apellido' ");
    while($row = mysqli_fetch_assoc($aa))
    {
      $tipo_us = $row['tipo_us'] ;
      $zona_us = $row['zona'] ;
    }
    
    $r = mysqli_query($conn, "INSERT INTO movimiento_interno(token, quien, movimiento, inicio, dia, tipo, zona, latitud, longitud) VALUES ('$token', '$usuario','Inicio', '$hoy', '$dia', '$tipo_us', '$zona_us', 'No se obtuvo la coordenada', 'No se obtuvo la coordenada')");
    if(!$r)
    {
      $titulo_toast = "Error";
      $msj_toast = "Hubo un error interno al borrar el proceso";
      $color_toast = "danger";
    }
    else
    {
      $titulo_toast = "Guardado";
      $msj_toast = "La asistencia fue guardada correctamente.";
      $color_toast = "warning";
    }
    $_SESSION['card'] = 1;
    $_SESSION['titulo_toast'] = $titulo_toast;
    $_SESSION['mensaje_toast'] = $msj_toast;
    $_SESSION['color_toast'] = $color_toast;
    header('Location: ../Basico/movimientos_internos.php');
  }
?>