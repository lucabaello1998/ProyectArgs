<?php
  include("../db.php");
  if(!$_SESSION['nombre'])
  {
    session_destroy();
    header("location: ../index.php");
    exit();
  }
  $tipo_us = $_SESSION['tipo_us'];
  $nombre_us = $_SESSION['nombre'];
  $apellido_us = $_SESSION['apellido'];
  if($tipo_us == "Administrador") { $usu = 1; }
  if($usu != 1)
  {
    header("location: ../index.php");
  }

  if (isset($_POST['cambiar_dia']))
  {
    $ultima_fecha = $_POST['ultima_fecha'];
    $dia_cambio = $_POST['dia_cambio'];
    mysqli_query($conn, "UPDATE carga_dia SET dia = '$dia_cambio' WHERE fecha = '$ultima_fecha'");
    $msgColor = "warning";
    $msg = "Se cambio el dia correctamente.";
    $_SESSION['card'] = 1;
    $_SESSION['message'] = $msg;
    $_SESSION['message_type'] = $msgColor;
    header('Location: ../Basico/produccion3.php');
  }

  if (isset($_POST['cambiar_tecnico']))
  {
    $ultima_fecha = $_POST['ultima_fecha'];
    $tecnicoa= $_POST['tecnicoa'];
    $tecnicob = $_POST['tecnicob'];
    $cambiar_tecnico = "UPDATE carga_dia SET tecnico = '$tecnicob' WHERE fecha = '$ultima_fecha' AND tecnico = '$tecnicoa'";
    mysqli_query($conn, $cambiar_tecnico);
    $msgColor = "warning";
    $msg = "Se cambio el tecnico correctamente.";
    $_SESSION['card'] = 1;
    $_SESSION['message'] = $msg;
    $_SESSION['message_type'] = $msgColor;
    header('Location: ../Basico/produccion3.php');
  }

  if (isset($_POST['cargar_tecnico']))
  {
    $ultima_fecha = $_POST['ultima_fecha'];
    $quien = $nombre_us ." " .$apellido_us;
    $tecnicoc = $_POST['tecnicoc'];
    $dia_solo = $_POST['dia_solo'];

    $rr = mysqli_query($conn, "SELECT * FROM carga_dia WHERE tecnico = '$tecnicoc' AND dia = '$dia_solo' AND quien = '$quien' AND fecha = '$ultima_fecha' LIMIT 1 ");
    if (mysqli_num_rows($rr) !== 1)
    {
      $resultado_cargo_tecnico = mysqli_query($conn, "SELECT * FROM tecnicos WHERE tecnico = '$tecnicoc' LIMIT 1 ");
      while($row = mysqli_fetch_assoc($resultado_cargo_tecnico))
      {
        $solo_tecnico = $row['tecnico'];
        $zona_recurso_tec = $row['zona'];
      }
      $cargar_tecnico = "INSERT INTO carga_dia (quien,tecnico,id_actividad,ot,direccion,localidad,zona,fecha,intervalo,actividad,codigo,cantidad_tv,estado,razon_completada,razon_no_completada,nota_cierre,inicio,fin,duracion,cliente,telefono,nim,motivo_asignacion,revisita,obs,dos_play,tres_play,stb,mudanza_interna,baja,garantia,garantia_justificada,baja_tecnica,baja_desmonte,mtto,mtto_externo,dia, zona_recurso)VALUES('$quien','$tecnicoc','-','-','-','-','-','$ultima_fecha','-','-','-','-','-','-','-','-','00:00:00','00:00:00','-','-','-','-','-','-','','0','0','0','0','0','0','0','0','0','0','0','$dia_solo','$zona_recurso_tec')";                 
      $agregar_tec = mysqli_query($conn, $cargar_tecnico);
      if(!$agregar_tec)
      {
        $msgColor = "danger";
        $msg = "El técnico " .$tecnicoc ." ya fue cargado anteriormente.";
      }
      else
      {
        $msgColor = "success";
        $msg = "El tecnico " .$tecnicoc ." fue cargado correctamente.";
      }
    }
    else
    {
      $msgColor = "danger";
      $msg = "El técnico ya fue cargado anteriormente.";
    }
    $_SESSION['card'] = 1;
    $_SESSION['message'] = $msg;
    $_SESSION['message_type'] = $msgColor;
    header('Location: ../Basico/produccion3.php');
  }

  if (isset($_POST['borrar_dia']))
  {
    $ultima_fecha = $_POST['ultima_fecha'];
    $query_borrar = "DELETE FROM carga_dia WHERE fecha = '$ultima_fecha'";
    $borrado = mysqli_query($conn, $query_borrar);
    if($borrado)
    {
      $msgColor = "danger";
      $msg = "Se borro el dia correctamente.";
      $_SESSION['card'] = 1;
      $_SESSION['message'] = $msg;
      $_SESSION['message_type'] = $msgColor;
      header('Location: ../Basico/produccion3.php');
    }
  }

  if (isset($_POST['menos']))
  {
    if(isset($_POST['menos']))
    {
      $ultima_fecha = $_POST['ultima_fecha'];
      $fechaa = date ('Y-m-d', strtotime($ultima_fecha."-1 day"));
    }
    header('Location: ../Basico/produccion3.php?dia='.$fechaa);
  }

  if (isset($_POST['mas']))
  {
    if(isset($_POST['mas']))
    {
      $ultima_fecha = $_POST['ultima_fecha'];
      $fechaa = date ('Y-m-d', strtotime($ultima_fecha."+1 day"));
    }
    header('Location: ../Basico/produccion3.php?dia='.$fechaa);
  }
?>