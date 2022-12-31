<?php
  include("../db.php");
  session_start();
  if(!$_SESSION['nombre'])
  {
    session_destroy();
    header("location: ../index.php");
    exit();
  }
  $tipo_us = $_SESSION['tipo_us'];
  $nombre = $_SESSION['nombre'];
  $apellido = $_SESSION['apellido'];
  $quien = $nombre ." " .$apellido;
  if($tipo_us == "Administrador") { $usu = 1; }
  if($tipo_us == "Despacho") { $usu = 1; }
  if($tipo_us == "Supervisor") { $usu = 1; }
  if($tipo_us == "Deposito") { $usu = 1; }
  if($usu != 1)
  {
    header("location: ../index.php");
  }

  if(isset($_GET['id']))
  {
    $id = $_GET['id'];
    $rr = mysqli_query($conn, "SELECT * FROM asignacion_material WHERE id = '$id'");
    if(mysqli_num_rows($rr) == 1)
    {
      $row = mysqli_fetch_array($rr);
      $tecnico = $row['tecnico'];
      $cantidades = $row['cantidad'];
      $material = $row['material'];
      $tipo = $row['tipo'];
      $fecha = $row['fecha'];
      $seriado = $row['seriado'];
      $sap = $row['sap'];
      $deposito = $row['deposito'];
    }
  }

  if(isset($_POST['editar']))
  {
    /* MOVIMIENTO INDIVIDUAL */
      $token_movi = uniqid();
      $quien_notas = $_SESSION['nombre'] . ' ' .$_SESSION['apellido'];
      $tipo_us = $_SESSION['tipo_us'];
      $zona_us = $_SESSION['zona'];
      $hoy_movi = date("Y-m-j");
      mysqli_query($conn, "INSERT INTO movimiento_interno(token,
      quien,
      movimiento,
      pag,
      inicio,
      tipo,
      zona) VALUES ('$token_movi',
      '$quien_notas',
      'Editado',
      'Asignacion material',
      '$hoy_movi',
      '$tipo_us',
      '$zona_us')");
    /* MOVIMIENTO INDIVIDUAL */
    $id = $_GET['id'];
    $cantidad = $_POST['cantidad'];

    $result_tot = mysqli_query($conn, "SELECT *, SUM(cantidad) as 'todos_mate' FROM ingresomaterial WHERE seriado = '' AND deposito = '$deposito' AND material = '$material' AND sap = '$sap' GROUP BY material ");
    while($row = mysqli_fetch_assoc($result_tot))
    {
      $canti = $row['todos_mate'];
      $re_us = mysqli_query($conn, "SELECT *, SUM(usado) as 'todos_usa' FROM asignacion_material WHERE material = '$material' AND deposito = '$deposito' ");
      while($row = mysqli_fetch_assoc($re_us))
      {
        $suado = $row['todos_usa'];
        $resto_depo = $canti - $suado;
      }
      
    }

    $rrr = mysqli_query($conn, "SELECT SUM(usado) as 'resto_usado' FROM asignacion_material WHERE fecha = '$fecha' AND tecnico = '$tecnico' AND tipo = 'Descarga' AND material = '$material' ");
    while($op = mysqli_fetch_array($rrr))
    {
      $usado = $op['resto_usado'];
    }

    if($cantidad < $usado) /* SI LA CANTIDAD ES MENOR AL USADO */
    {
      $msg ="No se puede cambiar la cantidad solicitada, por ser menor a lo que ya fue usado.";
      $msgColor = "danger";
    }
    else
    {
      if($seriado == '') /* SI EL EQUIPO ES SERIADO */
      {
        if($cantidad <= $resto_depo) /* SI LA CANTIDAD ES MENOR O IGUAL AL QUE QUEDA EN EL DEPOSITO */
        {
          $cc = mysqli_query($conn, "UPDATE asignacion_material set cantidad = '$cantidad' WHERE id = '$id'");
          if($cc)
          {
            $msg = "La cantidad de $material fue modificada correctamente." ;
            $msgColor = "warning";
          }
        }
        else
        {
          $msg = "No hay suficiente cantidad en el deposito $deposito" ;
          $msgColor = "danger";
        }
      }
      else
      {
        $msg ="No se puede cambiar la cantidad solicitada, por ser un equipo seriado.";
        $msgColor = "danger";
      }
    }
    $_SESSION['card'] = 1;
    $_SESSION['message'] = $msg;
    $_SESSION['message_type'] = $msgColor;
    header('Location: ../Basico/asignacion_materiales.php'); 
  }

  if(isset($_POST['borrar']))
  {
    /* MOVIMIENTO INDIVIDUAL */
      $token_movi = uniqid();
      $quien_notas = $_SESSION['nombre'] . ' ' .$_SESSION['apellido'];
      $tipo_us = $_SESSION['tipo_us'];
      $zona_us = $_SESSION['zona'];
      $hoy_movi = date("Y-m-j");
      mysqli_query($conn, "INSERT INTO movimiento_interno(token,
      quien,
      movimiento,
      pag,
      inicio,
      tipo,
      zona) VALUES ('$token_movi',
      '$quien_notas',
      'Borrado',
      'Asignacion materiales',
      '$hoy_movi',
      '$tipo_us',
      '$zona_us')");
    /* MOVIMIENTO INDIVIDUAL */
    $id = $_GET['id'];
    $cconsu = mysqli_query($conn, "SELECT SUM(usado) as 'rest_usado' FROM asignacion_material WHERE fecha = '$fecha' AND tecnico = '$tecnico' AND tipo = 'Descarga' AND material = '$material' ");
    while($row = mysqli_fetch_array($cconsu))
    {
      $resto_usado = $row['rest_usado'];
    }

    if($resto_usado !== 0 && $resto_usado !== '') /* SI YA SE USO EL MATERIAL */
    {
      $msg ="No se puede borrar el material, porque ya se utilizaron $resto_usado cantidades.";
      $msgColor = "danger";
    }
    if($resto_usado == '' || $resto_usado == 0 || $resto_usado == ' ') /* SI AUN NO SE USO EL MATERIAL */
    {
      $res = mysqli_query($conn, "DELETE FROM asignacion_material WHERE id = '$id'");
      if($res)
      {
        $msg = "El $material fue eliminado de la asignacion correctamente.";
        $msgColor = "warning";
      }
    }
    
    $_SESSION['card'] = 1;
    $_SESSION['message'] = $msg;
    $_SESSION['message_type'] = $msgColor;
    header('Location: ../Basico/asignacion_materiales.php');
  }

  if(isset($_POST['borrar_dia']))
  {
    /* MOVIMIENTO INDIVIDUAL */
      $token_movi = uniqid();
      $quien_notas = $_SESSION['nombre'] . ' ' .$_SESSION['apellido'];
      $tipo_us = $_SESSION['tipo_us'];
      $zona_us = $_SESSION['zona'];
      $hoy_movi = date("Y-m-j");
      mysqli_query($conn, "INSERT INTO movimiento_interno(token,
      quien,
      movimiento,
      pag,
      inicio,
      tipo,
      zona) VALUES ('$token_movi',
      '$quien_notas',
      'Borrado dia',
      'Asignacion materiales',
      '$hoy_movi',
      '$tipo_us',
      '$zona_us')");
    /* MOVIMIENTO INDIVIDUAL */
    $token = $_POST['token'];
    $cconsud = mysqli_query($conn, "SELECT SUM(usado) as 'rest_usado' FROM asignacion_material WHERE token = '$token' AND tipo = 'Descarga' ");
    while($row = mysqli_fetch_array($cconsud))
    {
      $resto_usado = $row['rest_usado'];
    }

    if($resto_usado > 0) /* SI YA SE USO EL MATERIAL */
    {
      $msg ="No se puede borrar el dia, porque ya se descargaron materiales.";
      $msgColor = "danger";
    }
    else
    {
      $res = mysqli_query($conn, "DELETE FROM asignacion_material WHERE token = '$token'");
      if($res)
      {
        $msg = "La asignacion fue eliminada correctamente.";
        $msgColor = "warning";
      }
    }
    
    $_SESSION['card'] = 1;
    $_SESSION['message'] = $msg;
    $_SESSION['message_type'] = $msgColor;
    header('Location: ../Basico/asignacion_materiales.php');
  }

  if(isset($_POST['transferir']))
  {
    /* MOVIMIENTO INDIVIDUAL */
      $token_movi = uniqid();
      $quien_notas = $_SESSION['nombre'] . ' ' .$_SESSION['apellido'];
      $tipo_us = $_SESSION['tipo_us'];
      $zona_us = $_SESSION['zona'];
      $hoy_movi = date("Y-m-j");
      mysqli_query($conn, "INSERT INTO movimiento_interno(token,
      quien,
      movimiento,
      pag,
      inicio,
      tipo,
      zona) VALUES ('$token_movi',
      '$quien_notas',
      'Transferir',
      'Asignacion materiales',
      '$hoy_movi',
      '$tipo_us',
      '$zona_us')");
    /* MOVIMIENTO INDIVIDUAL */
    $id = $_GET['id'];
    $cantidad = $_POST['cantidad'];
    $transferir = $_POST['tecnico'];

    $ww = mysqli_query($conn, "SELECT * FROM asignacion_material WHERE tecnico = '$transferir' AND fecha = '$fecha' AND tipo = 'Asignacion' LIMIT 1");
    if(mysqli_num_rows($ww) == 1)
    {
      $row = mysqli_fetch_array($ww);
      $tecnicoo = $row['tecnico'];
      $id_tecc = $row['id_tec'];
      $tokenn = $row['token'];
    }

    $rre = mysqli_query($conn, "SELECT SUM(usado) as 'resto_usados' FROM asignacion_material WHERE fecha = '$fecha' AND tecnico = '$tecnico' AND tipo = 'Descarga' AND material = '$material' ");
    while($op = mysqli_fetch_array($rre))
    {
      $usado = $op['resto_usados'];
    }

    if($cantidad < $usado) /* SI LA CANTIDAD ES MENOR AL YA USADO */
    {
      $msg ="No se puede transferir la cantidad solicitada, por ser menor a lo que ya fue usado.";
      $msgColor = "danger";
    }
    else
    {
      if($seriado == '') /* SI NO ES UN EQUIPO SERIADO */
      {
        if($cantidad > $cantidades) /* SI LA CANTIDAD ES MAYOR AL DISPONIBLE EN EL TECNICO */ 
        {
          $msg = "Se esta intentando tranferir una cantidad mayor a la disponible." ;
          $msgColor = "danger";
        }
        else
        {
          $cconsulta = mysqli_query($conn, "SELECT * FROM asignacion_material WHERE fecha = '$fecha' AND tecnico = '$transferir' AND tipo = 'Asignacion' AND material = '$material' ");
          if(mysqli_num_rows($cconsulta) >= 1)
          {
            $ccc = mysqli_query($conn, "UPDATE asignacion_material set cantidad = cantidad - '$cantidad' WHERE tecnico = '$tecnico' AND fecha = '$fecha' AND tipo = 'Asignacion' AND material = '$material' AND seriado = '$seriado' AND sap = '$sap'");
            $ddd = mysqli_query($conn, "UPDATE asignacion_material set cantidad = cantidad + '$cantidad' WHERE tecnico = '$transferir' AND fecha = '$fecha' AND tipo = 'Asignacion' AND material = '$material' AND seriado = '$seriado' AND sap = '$sap'");
            if($ccc && $ddd)
            {
              $msg = "Se transfirio $cantidad $material de $tecnico a $transferir correctamente." ;
              $msgColor = "warning";
            }
          }
          else
          {
            $ggg = mysqli_query($conn, "INSERT INTO asignacion_material(quien, sap, material, cantidad, fecha, tecnico, deposito, tipo, id_tec, token) VALUES ('$quien', '$sap', '$material', '$cantidad', '$fecha', '$transferir', '$deposito', 'Asignacion', '$id_tecc', '$tokenn')");
            if($ggg)
            {
              $msg = "Se creo $cantidad $material, transferidos de $tecnico a $transferir correctamente." ;
              $msgColor = "warning";
            }
          }
        }
      }
      else
      {
        $eee = mysqli_query($conn, "DELETE FROM asignacion_material WHERE id = '$id'");
        $fff = mysqli_query($conn, "INSERT INTO asignacion_material(quien, sap, material, cantidad, seriado, fecha, tecnico, deposito, tipo, id_tec, token) VALUES ('$quien', '$sap', '$material', '1', '$seriado', '$fecha', '$transferir', '$deposito', 'Asignacion', '$id_tecc', '$tokenn')");
        if($eee && $fff)
        {
          $msg = "Se transfirio el equipo $seriado de $tecnico a $transferir correctamente." ;
          $msgColor = "warning";
        }
      }
    }
    $_SESSION['card'] = 1;
    $_SESSION['message'] = $msg;
    $_SESSION['message_type'] = $msgColor;
    header('Location: ../Basico/asignacion_materiales.php'); 
  }

  if(isset($_POST['cargar']))
  {
    /* MOVIMIENTO INDIVIDUAL */
      $token_movi = uniqid();
      $quien_notas = $_SESSION['nombre'] . ' ' .$_SESSION['apellido'];
      $tipo_us = $_SESSION['tipo_us'];
      $zona_us = $_SESSION['zona'];
      $hoy_movi = date("Y-m-j");
      mysqli_query($conn, "INSERT INTO movimiento_interno(token,
      quien,
      movimiento,
      pag,
      inicio,
      tipo,
      zona) VALUES ('$token_movi',
      '$quien_notas',
      'Guardado',
      'Asignacion de materiales no seriados',
      '$hoy_movi',
      '$tipo_us',
      '$zona_us')");
    /* MOVIMIENTO INDIVIDUAL */
    
    $tecnico = $_POST['tecnico'];
    $cantidad = $_POST['cantidad'];
    $zona = $_POST['zona'];
    $material = $_POST['material'];
    $fecha = $_POST['fecha'];
    $token_new = (strtotime("now"));

    $sss = mysqli_query($conn, "SELECT * FROM asignacion_material WHERE tipo = 'Precarga' AND material = '$material' LIMIT 1");
    if(mysqli_num_rows($sss) == 1)
    {
      $row = mysqli_fetch_array($sss);
      $sap = $row['sap'];
    }

    $xx = mysqli_query($conn, "SELECT * FROM asignacion_material WHERE tecnico = '$tecnico' AND tipo = 'Asignacion' LIMIT 1");
    if(mysqli_num_rows($xx) == 1)
    {
      $row = mysqli_fetch_array($xx);
      $id_tecc = $row['id_tec'];
    }

    $yyy = mysqli_query($conn, "SELECT * FROM asignacion_material WHERE tecnico = '$tecnico' AND fecha = '$fecha' AND tipo = 'Asignacion' LIMIT 1");
    if(mysqli_num_rows($yyy) == 1)
    {
      $row = mysqli_fetch_array($yyy);
      $fecha_old = $row['fecha'];
      $token_old = $row['token'];
    }

    $b = mysqli_query($conn,"SELECT *, SUM(cantidad) as 'cancan' FROM ingresomaterial WHERE material = '$material' AND deposito = '$zona' AND cantidad > '$cantidad'");
    while($row = mysqli_fetch_assoc($b))
    {
      $cantt = $row['cancan'];
      $array[] = $row['material'];
    }

    if (in_array($material, $array)) ////buscame el valor de $material en la lista de $array
    {
      if($fecha == $fecha_old)
      {
        $hhh = mysqli_query($conn, "INSERT INTO asignacion_material(quien, sap, material, cantidad, fecha, tecnico, deposito, tipo, id_tec, token) VALUES ('$quien', '$sap', '$material', '$cantidad', '$fecha', '$tecnico', '$zona', 'Asignacion', '$id_tecc', '$token_old')");
        if($hhh)
        {
          $msg = "Se agrego $cantidad $material, a $tecnico correctamente." ;
          $msgColor = "success";
        }
      }
      else
      {
        $iii = mysqli_query($conn, "INSERT INTO asignacion_material(quien, sap, material, cantidad, fecha, tecnico, deposito, tipo, id_tec, token) VALUES ('$quien', '$sap', '$material', '$cantidad', '$fecha', '$tecnico', '$zona', 'Asignacion', '$id_tecc', '$token_new')");
        if($iii)
        {
          $msg = "Se agrego $cantidad $material, a $tecnico correctamente." ;
          $msgColor = "success";
        }
      }
    }
    else
    {
      $msg = "No hay suficiente material en el deposito, solo quedan " .$cantt ."." ;
      $msgColor = "danger";
    }
    
    $_SESSION['card'] = 1;
    $_SESSION['message'] = $msg;
    $_SESSION['message_type'] = $msgColor;
    header('Location: ../Basico/asignacion_materiales.php');     
  }

  if(isset($_POST['cargar_sn']))
  {
    /* MOVIMIENTO INDIVIDUAL */
      $token_movi = uniqid();
      $quien_notas = $_SESSION['nombre'] . ' ' .$_SESSION['apellido'];
      $tipo_us = $_SESSION['tipo_us'];
      $zona_us = $_SESSION['zona'];
      $hoy_movi = date("Y-m-j");
      mysqli_query($conn, "INSERT INTO movimiento_interno(token,
      quien,
      movimiento,
      pag,
      inicio,
      tipo,
      zona) VALUES ('$token_movi',
      '$quien_notas',
      'Guardado',
      'Asisgnacion de materiales seriados',
      '$hoy_movi',
      '$tipo_us',
      '$zona_us')");
    /* MOVIMIENTO INDIVIDUAL */
    $tecnico = $_POST['tecnico'];
    $zona = $_POST['zona'];
    $seriado = $_POST['seriado'];
    $fecha_new = $_POST['fecha'];
    $token_new = (strtotime("now"));

    $sss = mysqli_query($conn, "SELECT * FROM ingresomaterial WHERE seriado = '$seriado' LIMIT 1");
    if(mysqli_num_rows($sss) == 1)
    {
      $row = mysqli_fetch_array($sss);
      $sap = $row['sap'];
      $material = $row['material'];
    }

    $xx = mysqli_query($conn, "SELECT * FROM asignacion_material WHERE tecnico = '$tecnico' AND tipo = 'Asignacion' LIMIT 1");
    if(mysqli_num_rows($xx) == 1)
    {
      $row = mysqli_fetch_array($xx);
      $id_tecc = $row['id_tec'];
    }

    $yyy = mysqli_query($conn, "SELECT * FROM asignacion_material WHERE tecnico = '$tecnico' AND fecha = '$fecha_new' AND tipo = 'Asignacion' AND deposito = '$zona' LIMIT 1");
    if(mysqli_num_rows($yyy) == 1)
    {
      $row = mysqli_fetch_array($yyy);
      $fecha_old = $row['fecha'];
      $token_old = $row['token'];
    }

    $mmm = mysqli_query($conn, "SELECT * FROM asignacion_material WHERE fecha = '$fecha_new' AND seriado = '$seriado' AND tipo = 'Asignacion' ");
    while($op = mysqli_fetch_array($mmm))
    {
      $tecnico_ser = $op['tecnico'];
      $seriado_ser = $op['seriado'];
    }

    if($seriado == $seriado_ser)
    {
      $msg2 = ", El equipo " .$seriado ." ya fue asignado a $tecnico_ser .";
      $msgColor = "danger";
    }
    else
    {
      if($fecha_new == $fecha_old)
      {
        $hhh = mysqli_query($conn, "INSERT INTO asignacion_material(quien, sap, material, seriado, cantidad, fecha, tecnico, deposito, tipo, id_tec, token) VALUES ('$quien', '$sap', '$material', '$seriado', '1', '$fecha_new', '$tecnico', '$zona', 'Asignacion', '$id_tecc', '$token_old')");
        if($hhh)
        {
          $msg = "Se agrego $material ($seriado), a $tecnico correctamente." ;
          $msgColor = "success";
        }
      }
      else
      {
        $iii = mysqli_query($conn, "INSERT INTO asignacion_material(quien, sap, material, seriado, cantidad, fecha, tecnico, deposito, tipo, id_tec, token) VALUES ('$quien', '$sap', '$material', '$seriado', '1', '$fecha_new', '$tecnico', '$zona', 'Asignacion', '$id_tecc', '$token_new')");
        if($iii)
        {
          $msg = "Se agrego $material ($seriado), a $tecnico correctamente." ;
          $msgColor = "success";
        }
      }
    }
      $_SESSION['card'] = 1;
      $_SESSION['message'] = $msg .$msg2;
      $_SESSION['message_type'] = $msgColor;
      header('Location: ../Basico/asignacion_materiales.php');
  }
?>
