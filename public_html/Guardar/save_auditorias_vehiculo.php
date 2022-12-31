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
  header("location: ../index.php");   /////Visor - Deposito/////
}else{
$nombre = $_SESSION['nombre'];
$apellido = $_SESSION['apellido'];
}

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
  $obs = $_POST['obs'];

  


  $query = "INSERT INTO auditoria_vehiculo(supervisor, tecnico, fecha, dv_auxilio,dv_balizas,dv_cedula,dv_chasis,dv_color,dv_criquet,dv_dominio,dv_llave_cruz,dv_matafuego,dv_modelo,dv_motor,i_aire,i_balizas,i_bocina,i_calefaccion,i_encendedor,i_giro_del_acom,i_giro_del_conductor,i_giro_tras_acom,i_giro_tras_conductor,i_limpiaparabrisa,i_luz_alta,i_luz_baja,i_luz_freno,i_sapito,i_stereo,i_tapa_fusilera,i_temperatura,i_velocimetro,i_llave,tor_manijas_giro,tor_manijas_luces,tor_pulsadores,tor_rejilla_ventilacion,extfre_capot,extfre_cubiertas,extfre_llantas,extfre_opticas,extfre_parabrisas,extfre_paragolpe,extfre_parrilla,extfre_portaescalera,exttras_baul,exttras_cano_esc,exttras_cerradura,exttras_cubiertas,exttras_llantas,exttras_luneta,exttras_opticas,exttras_paragolpe,intcond_alfombra_del,intcond_alfombra_tras,intcond_apoya_brazo_del,intcond_apoya_brazo_tras,intcond_butaca_del,intcond_butaca_tras,intcond_cerradura_del,intcond_cerradura_tras,intcond_manija_puerta_del,intcond_manija_puerta_tras,intcond_manija_ventanilla_del,intcond_manija_ventanilla_tras,intcond_panel_puerta_del,intcond_panel_puerta_tras,intcond_panel_techo,intcond_polarizado_del,intcond_polarizado_tras,intcond_seguro_puerta_del,intcond_seguro_puerta_tras,intacom_alfombra_del,intacom_alfombra_tras,intacom_apoya_brazo_del,intacom_apoya_brazo_tras,intacom_butaca_del,intacom_butaca_tras,intacom_cerradura_del,intacom_cerradura_tras,intacom_manija_puerta_del,intacom_manija_puerta_tras,intacom_manija_ventanilla_del,intacom_manija_ventanilla_tras,intacom_panel_puerta_del,intacom_panel_puerta_tras,intacom_panel_techo,intacom_polarizado_del,intacom_polarizado_tras,intacom_seguro_puerta_del,intacom_seguro_puerta_tras,extcond_bagueta_del,extcond_bagueta_tras,extcond_cerradura_del,extcond_cerradura_tras,extcond_espejo_lateral,extcond_espejo_retrovisor,extcond_manija_puerta_del,extcond_manija_puerta_tras,extcond_tapa_tanque,extcond_ventanilla_del,extcond_ventanilla_tras,extacom_bagueta_del,extacom_bagueta_tras,extacom_cerradura_del,extacom_cerradura_tras,extacom_espejo_lateral,extacom_manija_puerta_del,extacom_manija_puerta_tras,extacom_ventanilla_del,extacom_ventanilla_tras,extacom_higuiene_int,extacom_higuiene_ext, obs) VALUES ('$supervisor', '$tecnico', '$fecha', '$dv_auxilio','$dv_balizas','$dv_cedula','$dv_chasis','$dv_color','$dv_criquet','$dv_dominio','$dv_llave_cruz','$dv_matafuego','$dv_modelo','$dv_motor','$i_aire','$i_balizas','$i_bocina','$i_calefaccion','$i_encendedor','$i_giro_del_acom','$i_giro_del_conductor','$i_giro_tras_acom','$i_giro_tras_conductor','$i_limpiaparabrisa','$i_luz_alta','$i_luz_baja','$i_luz_freno','$i_sapito','$i_stereo','$i_tapa_fusilera','$i_temperatura','$i_velocimetro','$i_llave','$tor_manijas_giro','$tor_manijas_luces','$tor_pulsadores','$tor_rejilla_ventilacion','$extfre_capot','$extfre_cubiertas','$extfre_llantas','$extfre_opticas','$extfre_parabrisas','$extfre_paragolpe','$extfre_parrilla','$extfre_portaescalera','$exttras_baul','$exttras_cano_esc','$exttras_cerradura','$exttras_cubiertas','$exttras_llantas','$exttras_luneta','$exttras_opticas','$exttras_paragolpe','$intcond_alfombra_del','$intcond_alfombra_tras','$intcond_apoya_brazo_del','$intcond_apoya_brazo_tras','$intcond_butaca_del','$intcond_butaca_tras','$intcond_cerradura_del','$intcond_cerradura_tras','$intcond_manija_puerta_del','$intcond_manija_puerta_tras','$intcond_manija_ventanilla_del','$intcond_manija_ventanilla_tras','$intcond_panel_puerta_del','$intcond_panel_puerta_tras','$intcond_panel_techo','$intcond_polarizado_del','$intcond_polarizado_tras','$intcond_seguro_puerta_del','$intcond_seguro_puerta_tras','$intacom_alfombra_del','$intacom_alfombra_tras','$intacom_apoya_brazo_del','$intacom_apoya_brazo_tras','$intacom_butaca_del','$intacom_butaca_tras','$intacom_cerradura_del','$intacom_cerradura_tras','$intacom_manija_puerta_del','$intacom_manija_puerta_tras','$intacom_manija_ventanilla_del','$intacom_manija_ventanilla_tras','$intacom_panel_puerta_del','$intacom_panel_puerta_tras','$intacom_panel_techo','$intacom_polarizado_del','$intacom_polarizado_tras','$intacom_seguro_puerta_del','$intacom_seguro_puerta_tras','$extcond_bagueta_del','$extcond_bagueta_tras','$extcond_cerradura_del','$extcond_cerradura_tras','$extcond_espejo_lateral','$extcond_espejo_retrovisor','$extcond_manija_puerta_del','$extcond_manija_puerta_tras','$extcond_tapa_tanque','$extcond_ventanilla_del','$extcond_ventanilla_tras','$extacom_bagueta_del','$extacom_bagueta_tras','$extacom_cerradura_del','$extacom_cerradura_tras','$extacom_espejo_lateral','$extacom_manija_puerta_del','$extacom_manija_puerta_tras','$extacom_ventanilla_del','$extacom_ventanilla_tras','$extacom_higuiene_int','$extacom_higuiene_ext', '$obs')";
  $result = mysqli_query($conn, $query);
  if(!$result) {
    $msj = "Recuerda que el tecnico, la fecha son obligatorios y el comentario maximo 255 caracteres.";
    $color = "danger";
  }else{
  $msj = "La auditoria de " .$tecnico ." con el vehiculo " .$dv_dominio ." fue guardada.";
  $color = "success";
  }
}
  $_SESSION['card'] = 1;
  $_SESSION['message'] = $msj;
  $_SESSION['message_type'] = $color;
  header('Location: ../Basico/auditorias_vehiculo.php');
?>
