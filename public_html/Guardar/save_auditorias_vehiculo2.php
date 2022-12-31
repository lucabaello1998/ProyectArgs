<?php
include('../db.php');
session_start();
if(!$_SESSION['nombre'])
{
session_destroy();
header("location: ../index.php");
exit();
}
$tipo = $_SESSION['tipo_us'];
if($tipo == "Administrador") { $usu = 1; }
if($tipo == "Despacho") { $usu = 1; }
if($tipo == "Supervisor") { $usu = 1; }
if($usu != 1)
{
  header("location: ../index.php");
}
$nombre = $_SESSION['nombre'];
$apellido = $_SESSION['apellido'];

$relevador = strtoupper(substr($nombre, 0, 1)) .strtoupper(substr($apellido, 0, 1));

function generarCodigo($longitud)
{
  $key = '';
  $pattern = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $max = strlen($pattern)-1;
  for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};
  return $key;
}

$idem = generarCodigo(6);
$identificador = "V" .$relevador ."-" .$idem;

$msg = '';
$msgColor = '';
$msg1 = '';
$msg2 = '';
$msg3 = '';
$msg4 = '';

$formatos = array('.jpg', '.jpeg', '.png');
if (isset($_POST['save_auditoria_vehiculo']))
{
  /* MOVIMIENTO INDIVIDUAL */
    $token_movi = uniqid();
    $quien_notas = $_SESSION['nombre'] . ' ' .$_SESSION['apellido'];
    $tipo_us = $_SESSION['tipo_us'];
    $zona_us = $_SESSION['zona'];
    $hoy_movi = date("Y-m-j");
    mysqli_query($conn, "INSERT INTO movimiento_interno(token, quien, movimiento, pag, inicio, tipo, zona) VALUES ('$token_movi', '$quien_notas', 'Guardado', 'Auditoria vehiculos', '$hoy_movi', '$tipo_us', '$zona_us')");
  /* MOVIMIENTO INDIVIDUAL */
  $supervisor = $nombre ." " .$apellido ;
  $tecnico = $_POST['tecnico'];
  $fecha = $_POST['fecha'];
  $dv_auxilio = $_POST['dv_auxilio'];
  $dv_balizas = $_POST['dv_balizas'];
  $dv_cedula = $_POST['dv_cedula'];
  $dv_chasis = $_POST['dv_chasis'];
  $dv_color = $_POST['dv_color'];
  $dv_criquet = $_POST['dv_criquet'];
  $dv_dominio = $_POST['dv_dominio'];
  $dv_llave_cruz = $_POST['dv_llave_cruz'];
  $dv_matafuego = $_POST['dv_matafuego'];
  $dv_modelo = $_POST['dv_modelo'];
  $dv_motor = $_POST['dv_motor'];
  $i_aire = $_POST['i_aire'];
  $i_balizas = $_POST['i_balizas'];
  $i_bocina = $_POST['i_bocina'];
  $i_calefaccion = $_POST['i_calefaccion'];
  $i_encendedor = $_POST['i_encendedor'];
  $i_giro_del_acom = $_POST['i_giro_del_acom'];
  $i_giro_del_conductor = $_POST['i_giro_del_conductor'];
  $i_giro_tras_acom = $_POST['i_giro_tras_acom'];
  $i_giro_tras_conductor = $_POST['i_giro_tras_conductor'];
  $i_limpiaparabrisa = $_POST['i_limpiaparabrisa'];
  $i_luz_alta = $_POST['i_luz_alta'];
  $i_luz_baja = $_POST['i_luz_baja'];
  $i_luz_freno = $_POST['i_luz_freno'];
  $i_sapito = $_POST['i_sapito'];
  $i_stereo = $_POST['i_stereo'];
  $i_tapa_fusilera = $_POST['i_tapa_fusilera'];
  $i_temperatura = $_POST['i_temperatura'];
  $i_velocimetro = $_POST['i_velocimetro'];
  $i_llave = $_POST['i_llave'];
  $tor_manijas_giro = $_POST['tor_manijas_giro'];
  $tor_manijas_luces = $_POST['tor_manijas_luces'];
  $tor_pulsadores = $_POST['tor_pulsadores'];
  $tor_rejilla_ventilacion = $_POST['tor_rejilla_ventilacion'];
  $extfre_capot = $_POST['extfre_capot'];
  $extfre_cubiertas = $_POST['extfre_cubiertas'];
  $extfre_llantas = $_POST['extfre_llantas'];
  $extfre_opticas = $_POST['extfre_opticas'];
  $extfre_parabrisas = $_POST['extfre_parabrisas'];
  $extfre_paragolpe = $_POST['extfre_paragolpe'];
  $extfre_parrilla = $_POST['extfre_parrilla'];
  $extfre_portaescalera = $_POST['extfre_portaescalera'];
  $exttras_baul = $_POST['exttras_baul'];
  $exttras_cano_esc = $_POST['exttras_cano_esc'];
  $exttras_cerradura = $_POST['exttras_cerradura'];
  $exttras_cubiertas = $_POST['exttras_cubiertas'];
  $exttras_llantas = $_POST['exttras_llantas'];
  $exttras_luneta = $_POST['exttras_luneta'];
  $exttras_opticas = $_POST['exttras_opticas'];
  $exttras_paragolpe = $_POST['exttras_paragolpe'];
  $intcond_alfombra_del = $_POST['intcond_alfombra_del'];
  $intcond_alfombra_tras = $_POST['intcond_alfombra_tras'];
  $intcond_apoya_brazo_del = $_POST['intcond_apoya_brazo_del'];
  $intcond_apoya_brazo_tras = $_POST['intcond_apoya_brazo_tras'];
  $intcond_butaca_del = $_POST['intcond_butaca_del'];
  $intcond_butaca_tras = $_POST['intcond_butaca_tras'];
  $intcond_cerradura_del = $_POST['intcond_cerradura_del'];
  $intcond_cerradura_tras = $_POST['intcond_cerradura_tras'];
  $intcond_manija_puerta_del = $_POST['intcond_manija_puerta_del'];
  $intcond_manija_puerta_tras = $_POST['intcond_manija_puerta_tras'];
  $intcond_manija_ventanilla_del = $_POST['intcond_manija_ventanilla_del'];
  $intcond_manija_ventanilla_tras = $_POST['intcond_manija_ventanilla_tras'];
  $intcond_panel_puerta_del = $_POST['intcond_panel_puerta_del'];
  $intcond_panel_puerta_tras = $_POST['intcond_panel_puerta_tras'];
  $intcond_panel_techo = $_POST['intcond_panel_techo'];
  $intcond_polarizado_del = $_POST['intcond_polarizado_del'];
  $intcond_polarizado_tras = $_POST['intcond_polarizado_tras'];
  $intcond_seguro_puerta_del = $_POST['intcond_seguro_puerta_del'];
  $intcond_seguro_puerta_tras = $_POST['intcond_seguro_puerta_tras'];
  $intacom_alfombra_del = $_POST['intacom_alfombra_del'];
  $intacom_alfombra_tras = $_POST['intacom_alfombra_tras'];
  $intacom_apoya_brazo_del = $_POST['intacom_apoya_brazo_del'];
  $intacom_apoya_brazo_tras = $_POST['intacom_apoya_brazo_tras'];
  $intacom_butaca_del = $_POST['intacom_butaca_del'];
  $intacom_butaca_tras = $_POST['intacom_butaca_tras'];
  $intacom_cerradura_del = $_POST['intacom_cerradura_del'];
  $intacom_cerradura_tras = $_POST['intacom_cerradura_tras'];
  $intacom_manija_puerta_del = $_POST['intacom_manija_puerta_del'];
  $intacom_manija_puerta_tras = $_POST['intacom_manija_puerta_tras'];
  $intacom_manija_ventanilla_del = $_POST['intacom_manija_ventanilla_del'];
  $intacom_manija_ventanilla_tras = $_POST['intacom_manija_ventanilla_tras'];
  $intacom_panel_puerta_del = $_POST['intacom_panel_puerta_del'];
  $intacom_panel_puerta_tras = $_POST['intacom_panel_puerta_tras'];
  $intacom_panel_techo = $_POST['intacom_panel_techo'];
  $intacom_polarizado_del = $_POST['intacom_polarizado_del'];
  $intacom_polarizado_tras = $_POST['intacom_polarizado_tras'];
  $intacom_seguro_puerta_del = $_POST['intacom_seguro_puerta_del'];
  $intacom_seguro_puerta_tras = $_POST['intacom_seguro_puerta_tras'];
  $extcond_bagueta_del = $_POST['extcond_bagueta_del'];
  $extcond_bagueta_tras = $_POST['extcond_bagueta_tras'];
  $extcond_cerradura_del = $_POST['extcond_cerradura_del'];
  $extcond_cerradura_tras = $_POST['extcond_cerradura_tras'];
  $extcond_espejo_lateral = $_POST['extcond_espejo_lateral'];
  $extcond_espejo_retrovisor = $_POST['extcond_espejo_retrovisor'];
  $extcond_manija_puerta_del = $_POST['extcond_manija_puerta_del'];
  $extcond_manija_puerta_tras = $_POST['extcond_manija_puerta_tras'];
  $extcond_tapa_tanque = $_POST['extcond_tapa_tanque'];
  $extcond_ventanilla_del = $_POST['extcond_ventanilla_del'];
  $extcond_ventanilla_tras = $_POST['extcond_ventanilla_tras'];
  $extacom_bagueta_del = $_POST['extacom_bagueta_del'];
  $extacom_bagueta_tras = $_POST['extacom_bagueta_tras'];
  $extacom_cerradura_del = $_POST['extacom_cerradura_del'];
  $extacom_cerradura_tras = $_POST['extacom_cerradura_tras'];
  $extacom_espejo_lateral = $_POST['extacom_espejo_lateral'];
  $extacom_manija_puerta_del = $_POST['extacom_manija_puerta_del'];
  $extacom_manija_puerta_tras = $_POST['extacom_manija_puerta_tras'];
  $extacom_ventanilla_del = $_POST['extacom_ventanilla_del'];
  $extacom_ventanilla_tras = $_POST['extacom_ventanilla_tras'];
  $extacom_higuiene_int = $_POST['extacom_higuiene_int'];
  $extacom_higuiene_ext = $_POST['extacom_higuiene_ext'];
  $obs = Reemplazo($_POST['obs']);

  /////////////IMAGEN 1////////////////////
    
    if ($_FILES['imagen1']['name'] != null)
    {     
      $imagen1 = $identificador ."-" ."imagen1";

      $nombreArchivo1 = $_FILES['imagen1']['name'];
      $nombreTmpArchivo1 = $_FILES['imagen1']['tmp_name'];
      $ext1 = substr($nombreArchivo1, strrpos($nombreArchivo1, '.'));
      if (in_array($ext1, $formatos)) ////buscame este elemento en esta lista
      {
        if($_FILES['imagen1']['size'] < 9000000 )
        {
          if (move_uploaded_file($nombreTmpArchivo1, "../Archivos/foto_vehiculos/" .$imagen1 .$ext1))
          {   
              $imagenpri = $imagen1 .$ext1;
              $msg1 = "1";
          }
          else
          {
            $msg1 = "E-I"; ///servidor
          }
        }
        else
        {
          $msg1 = "E-P"; ///Tamaño
        }
      }
      else
      {
        $msg1 = "E-F"; ///Fomrato
      }
    }
    else
    {
      $imagenpri = "";
      $msg1 = '';
    }
  /////////////IMAGEN 1////////////////////

  /////////////IMAGEN 2////////////////////
    
    if ($_FILES['imagen2']['name'] != null)
    {     
      $imagen2 = $identificador ."-" ."imagen2";

      $nombreArchivo2 = $_FILES['imagen2']['name'];
      $nombreTmpArchivo2 = $_FILES['imagen2']['tmp_name'];
      $ext2 = substr($nombreArchivo2, strrpos($nombreArchivo2, '.'));
      if (in_array($ext2, $formatos)) ////buscame este elemento en esta lista
      {
        if($_FILES['imagen2']['size'] < 9000000 )
        {
          if (move_uploaded_file($nombreTmpArchivo2, "../Archivos/foto_vehiculos/" .$imagen2 .$ext2))
          {   
              $imagenseg = $imagen2 .$ext2;
              $msg2 = "1";
          }
          else
          {
            $msg2 = "E-I";
          }
        }
        else
        {
          $msg2 = "E-P";
        }
      }
      else
      {
        $msg2 = "E-F";
      }
    }
    else
    {
      $imagenseg = "";
      $msg2 = '';
    }
  /////////////IMAGEN 2////////////////////

  /////////////IMAGEN 3////////////////////
    
    if ($_FILES['imagen3']['name'] != null)
    {     
      $imagen3 = $identificador ."-" ."imagen3";

      $nombreArchivo3 = $_FILES['imagen3']['name'];
      $nombreTmpArchivo3 = $_FILES['imagen3']['tmp_name'];
      $ext3 = substr($nombreArchivo3, strrpos($nombreArchivo3, '.'));
      if (in_array($ext3, $formatos)) ////buscame este elemento en esta lista
      {
        if($_FILES['imagen3']['size'] < 9000000 )
        {
          if (move_uploaded_file($nombreTmpArchivo3, "../Archivos/foto_vehiculos/" .$imagen3 .$ext3))
          {   
              $imagenter = $imagen3 .$ext3;
              $msg3 = "1";
          }
          else
          {
            $msg3 = "E-I";
          }
        }
        else
        {
          $msg3 = "E-P";
        }
      }
      else
      {
        $msg3 = "E-F";
      }
    }
    else
    {
      $imagenter = "";
      $msg3 = '';
    }
  /////////////IMAGEN 3////////////////////

  /////////////IMAGEN 4////////////////////
    
    if ($_FILES['imagen4']['name'] != null)
    {     
      $imagen4 = $identificador ."-" ."imagen4";

      $nombreArchivo4 = $_FILES['imagen4']['name'];
      $nombreTmpArchivo4 = $_FILES['imagen4']['tmp_name'];
      $ext4 = substr($nombreArchivo4, strrpos($nombreArchivo4, '.'));
      if (in_array($ext4, $formatos)) ////buscame este elemento en esta lista
      {
        if($_FILES['imagen4']['size'] < 9000000 )
        {
          if (move_uploaded_file($nombreTmpArchivo4, "../Archivos/foto_vehiculos/" .$imagen4 .$ext4))
          {   
              $imagencuar = $imagen4 .$ext4;
              $msg4 = "1";
          }
          else
          {
            $msg4 = "E-I";
          }
        }
        else
        {
          $msg4 = "E-P";
        }
      }
      else
      {
        $msg4 = "E-F";
      }
    }
    else
    {
      $imagencuar = "";
      $msg4 = '';
    }
  /////////////IMAGEN 4////////////////////

  $imagenes = $msg1 + $msg2 + $msg3 + $msg4;
  $result = mysqli_query($conn, "INSERT INTO auditoria_vehiculo(identificador, supervisor, tecnico, fecha, dv_auxilio,dv_balizas,dv_cedula,dv_chasis,dv_color,dv_criquet,dv_dominio,dv_llave_cruz,dv_matafuego,dv_modelo,dv_motor,i_aire,i_balizas,i_bocina,i_calefaccion,i_encendedor,i_giro_del_acom,i_giro_del_conductor,i_giro_tras_acom,i_giro_tras_conductor,i_limpiaparabrisa,i_luz_alta,i_luz_baja,i_luz_freno,i_sapito,i_stereo,i_tapa_fusilera,i_temperatura,i_velocimetro,i_llave,tor_manijas_giro,tor_manijas_luces,tor_pulsadores,tor_rejilla_ventilacion,extfre_capot,extfre_cubiertas,extfre_llantas,extfre_opticas,extfre_parabrisas,extfre_paragolpe,extfre_parrilla,extfre_portaescalera,exttras_baul,exttras_cano_esc,exttras_cerradura,exttras_cubiertas,exttras_llantas,exttras_luneta,exttras_opticas,exttras_paragolpe,intcond_alfombra_del,intcond_alfombra_tras,intcond_apoya_brazo_del,intcond_apoya_brazo_tras,intcond_butaca_del,intcond_butaca_tras,intcond_cerradura_del,intcond_cerradura_tras,intcond_manija_puerta_del,intcond_manija_puerta_tras,intcond_manija_ventanilla_del,intcond_manija_ventanilla_tras,intcond_panel_puerta_del,intcond_panel_puerta_tras,intcond_panel_techo,intcond_polarizado_del,intcond_polarizado_tras,intcond_seguro_puerta_del,intcond_seguro_puerta_tras,intacom_alfombra_del,intacom_alfombra_tras,intacom_apoya_brazo_del,intacom_apoya_brazo_tras,intacom_butaca_del,intacom_butaca_tras,intacom_cerradura_del,intacom_cerradura_tras,intacom_manija_puerta_del,intacom_manija_puerta_tras,intacom_manija_ventanilla_del,intacom_manija_ventanilla_tras,intacom_panel_puerta_del,intacom_panel_puerta_tras,intacom_panel_techo,intacom_polarizado_del,intacom_polarizado_tras,intacom_seguro_puerta_del,intacom_seguro_puerta_tras,extcond_bagueta_del,extcond_bagueta_tras,extcond_cerradura_del,extcond_cerradura_tras,extcond_espejo_lateral,extcond_espejo_retrovisor,extcond_manija_puerta_del,extcond_manija_puerta_tras,extcond_tapa_tanque,extcond_ventanilla_del,extcond_ventanilla_tras,extacom_bagueta_del,extacom_bagueta_tras,extacom_cerradura_del,extacom_cerradura_tras,extacom_espejo_lateral,extacom_manija_puerta_del,extacom_manija_puerta_tras,extacom_ventanilla_del,extacom_ventanilla_tras,extacom_higuiene_int,extacom_higuiene_ext, obs, imagenpri, imagenseg, imagenter, imagencuar) VALUES ('$identificador','$supervisor', '$tecnico', '$fecha', '$dv_auxilio','$dv_balizas','$dv_cedula','$dv_chasis','$dv_color','$dv_criquet','$dv_dominio','$dv_llave_cruz','$dv_matafuego','$dv_modelo','$dv_motor','$i_aire','$i_balizas','$i_bocina','$i_calefaccion','$i_encendedor','$i_giro_del_acom','$i_giro_del_conductor','$i_giro_tras_acom','$i_giro_tras_conductor','$i_limpiaparabrisa','$i_luz_alta','$i_luz_baja','$i_luz_freno','$i_sapito','$i_stereo','$i_tapa_fusilera','$i_temperatura','$i_velocimetro','$i_llave','$tor_manijas_giro','$tor_manijas_luces','$tor_pulsadores','$tor_rejilla_ventilacion','$extfre_capot','$extfre_cubiertas','$extfre_llantas','$extfre_opticas','$extfre_parabrisas','$extfre_paragolpe','$extfre_parrilla','$extfre_portaescalera','$exttras_baul','$exttras_cano_esc','$exttras_cerradura','$exttras_cubiertas','$exttras_llantas','$exttras_luneta','$exttras_opticas','$exttras_paragolpe','$intcond_alfombra_del','$intcond_alfombra_tras','$intcond_apoya_brazo_del','$intcond_apoya_brazo_tras','$intcond_butaca_del','$intcond_butaca_tras','$intcond_cerradura_del','$intcond_cerradura_tras','$intcond_manija_puerta_del','$intcond_manija_puerta_tras','$intcond_manija_ventanilla_del','$intcond_manija_ventanilla_tras','$intcond_panel_puerta_del','$intcond_panel_puerta_tras','$intcond_panel_techo','$intcond_polarizado_del','$intcond_polarizado_tras','$intcond_seguro_puerta_del','$intcond_seguro_puerta_tras','$intacom_alfombra_del','$intacom_alfombra_tras','$intacom_apoya_brazo_del','$intacom_apoya_brazo_tras','$intacom_butaca_del','$intacom_butaca_tras','$intacom_cerradura_del','$intacom_cerradura_tras','$intacom_manija_puerta_del','$intacom_manija_puerta_tras','$intacom_manija_ventanilla_del','$intacom_manija_ventanilla_tras','$intacom_panel_puerta_del','$intacom_panel_puerta_tras','$intacom_panel_techo','$intacom_polarizado_del','$intacom_polarizado_tras','$intacom_seguro_puerta_del','$intacom_seguro_puerta_tras','$extcond_bagueta_del','$extcond_bagueta_tras','$extcond_cerradura_del','$extcond_cerradura_tras','$extcond_espejo_lateral','$extcond_espejo_retrovisor','$extcond_manija_puerta_del','$extcond_manija_puerta_tras','$extcond_tapa_tanque','$extcond_ventanilla_del','$extcond_ventanilla_tras','$extacom_bagueta_del','$extacom_bagueta_tras','$extacom_cerradura_del','$extacom_cerradura_tras','$extacom_espejo_lateral','$extacom_manija_puerta_del','$extacom_manija_puerta_tras','$extacom_ventanilla_del','$extacom_ventanilla_tras','$extacom_higuiene_int','$extacom_higuiene_ext', '$obs', '$imagenpri', '$imagenseg', '$imagenter', '$imagencuar')");
  if(!$result) {
    $titulo_toast = "Error";
    $msj_toast = "Hubo un error interno al guardar el proceso";
    $color_toast = "danger";
    $_SESSION['card'] = 1;
    $_SESSION['titulo_toast'] = $titulo_toast;
    $_SESSION['mensaje_toast'] = $msj_toast;
    $_SESSION['color_toast'] = $color_toast;
    header('Location: ../Basico/auditorias_vehiculo2.php');
  }
  else
  {
  if (isset($_POST['realizado']))
    {
      $token_calendario = $_POST['token_calendario'];
      mysqli_query($conn, "UPDATE calendario set color = '#7ED321', estado = 'Finalizado', id_auditoria = '$identificador', tomado_por = '' WHERE token = '$token_calendario'");


      /* MSJ */
        $tec_sup = mysqli_query($conn, "SELECT * FROM calendario WHERE token = '$token_calendario' LIMIT 1");
        if (mysqli_num_rows($tec_sup) == 1)
        {
          $row = mysqli_fetch_array($tec_sup);
          $quien_sup = $row['quien'];
          $tarea_sup = $row['tarea'];
          $tecnico_sup = $row['tecnico'];
          $contenido_sup = $row['contenido'];
        }
        $porciones = explode(" ", $quien_sup);
        $nombre_nota = $porciones[0];
        $apellido_nota = $porciones[1];
        
        $link = '/Basico/b_ver_calendario.php?token='.$token;
        $icono="/images/icon_512.png";

        $msj = mysqli_query($conn, "SELECT * FROM usuarios WHERE nombre = '$nombre_nota' AND apellido = '$apellido_nota' LIMIT 1");
        if (mysqli_num_rows($msj) == 1)
        {
          $row = mysqli_fetch_array($msj);
          $firebase = $row['firebase'];  
        }

        if($tecnico_sup == '')
          {
            $cuerpo_msj = $contenido_sup;
          }
          else
          {
            if($contenido_sup == '')
            {
              $cuerpo_msj = 'Tecnico: ' .$tecnico_sup;
            }
            else
            {
              $cuerpo_msj = 'Tecnico: ' .$tecnico_sup .' - ' .'Contenido: ' .$contenido_sup;
            }
          }

        $field=array(
            'data'=>array(
            'notification'=>array(
            'title'=>'Tarea finalizada (' .$tarea_sup .')',
            'body'=>$cuerpo_msj,
            'icon'=>$icono,
            'link'=>$link
            )
          ),
        'to'=>$firebase
        );
        $fields=json_encode($field);

        $header=array(
          'Authorization: key=AAAAsHb0r4c:APA91bFnf2A8l7nYJ1ajJuQSy6SJHjiGcHFU3fzw2gHyLbu9C5dYfl7n7fQ4n8LOVr8y2vg2P65O0g8wuo7S-DHZkGgxF_m2DEh9vNMYsP7_83Qb4DNj_Rgj_e0I9xuYkjAGYiGHjQhY',
          'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

        $result=curl_exec($ch);
        curl_close($ch);
      /* MSJ */


      $titulo_toast = "Guardado";
      $msj_toast = "La auditoria de " .$tecnico ." con el vehiculo " .$dv_dominio ." fue guardada correctamente con " .$imagenes ." imagenes";
      $color_toast = "success";
      $_SESSION['card'] = 1;
      $_SESSION['titulo_toast'] = $titulo_toast;
      $_SESSION['mensaje_toast'] = $msj_toast;
      $_SESSION['color_toast'] = $color_toast;
      header('Location: ../Basico/calendario.php');
    }
    else
    {
      $titulo_toast = "Guardado";
      $msj_toast = "La auditoria de " .$tecnico ." con el vehiculo " .$dv_dominio ." fue guardada correctamente con " .$imagenes ." imagenes";
      $color_toast = "success";
      $_SESSION['card'] = 1;
      $_SESSION['titulo_toast'] = $titulo_toast;
      $_SESSION['mensaje_toast'] = $msj_toast;
      $_SESSION['color_toast'] = $color_toast;
      header('Location: ../Basico/auditorias_vehiculo2.php');
    }
  }
}
?>