<?php
include('../db.php');
if(!$_SESSION['nombre'])
{
session_destroy();
header("location: ../index.php");
exit();
}
$tipo = $_SESSION['tipo'];
$activo = $_SESSION['activo'];
if($tipo == "Administrador" && $activo== 'SI') { $usu = 1; }
if($tipo == "Supervisor" && $activo== 'SI') { $usu = 1; }
if($tipo == "Tecnico" && $activo== 'SI') { $usu = 1; }
if($tipo == "Cliente" && $activo== 'SI') { $usu = 1; }
if($tipo == "Publico" && $activo== 'SI') { $usu = 1; }
if($tipo == "Seguridad e higiene" && $activo== 'SI') { $usu = 1; }
if($usu != 1)
{
	$_SESSION['mensaje'] = "Acceso restringido";
  header("location: ../index.php");
}
$formatos = array('.jpg', '.jpeg', '.png');
$nombre = $_SESSION['nombre'];
$apellido = $_SESSION['apellido'];
if (isset($_POST['guardar_nota']))
{
  $token = uniqid();
	$quien = $nombre ." " .$apellido;
  $notass = $_POST['nota'];
  $quines = implode(",", $_POST['para_quien']);
  $para_quien = $quines;
  $fecha = $_POST['fecha'];
  $color = $_POST['color'];
  $icono = $_POST['icono'];
  $nota = Reemplazo($notass);

  /////////////IMAGEN 1////////////////////
    if ($_FILES['imagen1']['name'] != null)
    {     
      $imagen1 = $token ."-img1";
      $nombreArchivo1 = $_FILES['imagen1']['name'];
      $nombreTmpArchivo1 = $_FILES['imagen1']['tmp_name'];
      $ext1 = substr($nombreArchivo1, strrpos($nombreArchivo1, '.'));
      if (in_array($ext1, $formatos)) ////buscame este elemento en esta lista
      {
        if($_FILES['imagen1']['size'] < 9000000 )
        {
          if (move_uploaded_file($nombreTmpArchivo1, "../files/notas/" .$imagen1 .$ext1))
          {   
            $imagen_uno = $imagen1 .$ext1;
            $msg1 = "Subido img1";
          }
          else
          {
            $msg1 = "Error en el servidor"; ///servidor
          }
        }
        else
        {
          $msg1 = "Error de tamaño"; ///Tamaño
        }
      }
      else
      {
        $msg1 = "Error de formato"; ///Fomrato
      }
    }
    else
    {
      $imagen_uno = "";
    }
  /////////////IMAGEN 1////////////////////

  /////////////IMAGEN 2////////////////////
    if ($_FILES['imagen2']['name'] != null)
    {     
      $imagen2 = $token ."-img2";
      $nombreArchivo2 = $_FILES['imagen2']['name'];
      $nombreTmpArchivo2 = $_FILES['imagen2']['tmp_name'];
      $ext2 = substr($nombreArchivo2, strrpos($nombreArchivo2, '.'));
      if (in_array($ext2, $formatos)) ////buscame este elemento en esta lista
      {
        if($_FILES['imagen2']['size'] < 9000000 )
        {
          if (move_uploaded_file($nombreTmpArchivo2, "../files/notas/" .$imagen2 .$ext2))
          {   
            $imagen_dos = $imagen2 .$ext2;
            $msg2 = "Subido img2";
          }
          else
          {
            $msg2 = "Error en el servidor"; ///servidor
          }
        }
        else
        {
          $msg2 = "Error de tamaño"; ///Tamaño
        }
      }
      else
      {
        $msg2 = "Error de formato"; ///Fomrato
      }
    }
    else
    {
      $imagen_dos = "";
    }
  /////////////IMAGEN 2////////////////////

  /////////////IMAGEN 3////////////////////
    if ($_FILES['imagen3']['name'] != null)
    {     
      $imagen3 = $token ."-img3";
      $nombreArchivo3 = $_FILES['imagen3']['name'];
      $nombreTmpArchivo3 = $_FILES['imagen3']['tmp_name'];
      $ext3 = substr($nombreArchivo3, strrpos($nombreArchivo3, '.'));
      if (in_array($ext3, $formatos)) ////buscame este elemento en esta lista
      {
        if($_FILES['imagen3']['size'] < 9000000 )
        {
          if (move_uploaded_file($nombreTmpArchivo3, "../files/notas/" .$imagen3 .$ext3))
          {   
            $imagen_tres = $imagen3 .$ext3;
            $msg3 = "Subido img3";
          }
          else
          {
            $msg3 = "Error en el servidor"; ///servidor
          }
        }
        else
        {
          $msg3 = "Error de tamaño"; ///Tamaño
        }
      }
      else
      {
        $msg3 = "Error de formato"; ///Fomrato
      }
    }
    else
    {
      $imagen_tres = "";
    }
  /////////////IMAGEN 3////////////////////

  /////////////IMAGEN 4////////////////////
    if ($_FILES['imagen4']['name'] != null)
    {     
      $imagen4 = $token ."-img4";
      $nombreArchivo4 = $_FILES['imagen4']['name'];
      $nombreTmpArchivo4 = $_FILES['imagen4']['tmp_name'];
      $ext4 = substr($nombreArchivo4, strrpos($nombreArchivo4, '.'));
      if (in_array($ext4, $formatos)) ////buscame este elemento en esta lista
      {
        if($_FILES['imagen4']['size'] < 9000000 )
        {
          if (move_uploaded_file($nombreTmpArchivo4, "../files/notas/" .$imagen4 .$ext4))
          {   
            $imagen_cuatro = $imagen4 .$ext4;
            $msg4 = "Subido img4";
          }
          else
          {
            $msg4 = "Error en el servidor"; ///servidor
          }
        }
        else
        {
          $msg4 = "Error de tamaño"; ///Tamaño
        }
      }
      else
      {
        $msg4 = "Error de formato"; ///Fomrato
      }
    }
    else
    {
      $imagen_cuatro = "";
    }
  /////////////IMAGEN 4////////////////////

  $insert_nota = "INSERT INTO notas (token, quien, fecha, nota, para, color, icono, imagen_uno, imagen_dos, imagen_tres, imagen_cuatro) VALUES ('$token', '$quien', '$fecha', '$nota', '$para_quien', '$color', '$icono', '$imagen_uno', '$imagen_dos', '$imagen_tres', '$imagen_cuatro')";
  $result_nota = mysqli_query($conn, $insert_nota);
  if(!$result_nota)
    {
			$alerta = "Error";
			$msj = "Error en el servidor.";
			$color = "error";
    }
    else
    {
			$alerta = "Guardado";
			$msj = "La nota fue guardada.";
			$color = "success";      
    }
    $_SESSION['card'] = 1;
    $_SESSION['toast'] = '
    <script>
    (function ($) {
    "use strict"
    toastr.' .$color .'("' .$msj .'", "' .$alerta .'", {
			positionClass: "toast-top-center",
			timeOut: 5e3,
			closeButton: !0,
			debug: !1,
			newestOnTop: !0,
			progressBar: !0,
			preventDuplicates: !0,
			onclick: null,
			showDuration: "300",
			hideDuration: "1000",
			extendedTimeOut: "1000",
			showEasing: "swing",
			hideEasing: "linear",
			showMethod: "fadeIn",
			hideMethod: "fadeOut",
			tapToDismiss: !1
    });
    })(jQuery);
    </script>
    ';    
    echo '
    <script>    
			window.history.back();    
    </script>
    ';
}
?>