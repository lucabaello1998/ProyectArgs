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
if($tipo_us == "Administrador") { $usu = 1; }
if($tipo_us == "Despacho") { $usu = 1; }
if($tipo_us == "Supervisor") { $usu = 1; }
if($usu != 1)
{
  header("location: ../index.php");
}else{
$nombre = $_SESSION['nombre'];
$apellido = $_SESSION['apellido'];
}

$tecnico = '';
$fecha= '';
$dv_auxilio = '';
$dv_balizas = '';
$dv_cedula = '';
$dv_chasis = '';
$dv_color = '';
$dv_criquet = '';
$dv_dominio = '';
$dv_llave_cruz = '';
$dv_matafuego = '';
$dv_modelo = '';
$dv_motor = '';
$i_aire = '';
$i_balizas = '';
$i_bocina = '';
$i_calefaccion = '';
$i_encendedor = '';
$i_giro_del_acom = '';
$i_giro_del_conductor = '';
$i_giro_tras_acom = '';
$i_giro_tras_conductor = '';
$i_limpiaparabrisa = '';
$i_luz_alta = '';
$i_luz_baja = '';
$i_luz_freno = '';
$i_sapito = '';
$i_stereo = '';
$i_tapa_fusilera = '';
$i_temperatura = '';
$i_velocimetro = '';
$i_llave = '';
$tor_manijas_giro = '';
$tor_manijas_luces = '';
$tor_pulsadores = '';
$tor_rejilla_ventilacion = '';
$extfre_capot = '';
$extfre_cubiertas = '';
$extfre_llantas = '';
$extfre_opticas = '';
$extfre_parabrisas = '';
$extfre_paragolpe = '';
$extfre_parrilla = '';
$extfre_portaescalera = '';
$exttras_baul = '';
$exttras_cano_esc = '';
$exttras_cerradura = '';
$exttras_cubiertas = '';
$exttras_llantas = '';
$exttras_luneta = '';
$exttras_opticas = '';
$exttras_paragolpe = '';
$intcond_alfombra_del = '';
$intcond_alfombra_tras = '';
$intcond_apoya_brazo_del = '';
$intcond_apoya_brazo_tras = '';
$intcond_butaca_del = '';
$intcond_butaca_tras = '';
$intcond_cerradura_del = '';
$intcond_cerradura_tras = '';
$intcond_manija_puerta_del = '';
$intcond_manija_puerta_tras = '';
$intcond_manija_ventanilla_del = '';
$intcond_manija_ventanilla_tras = '';
$intcond_panel_puerta_del = '';
$intcond_panel_puerta_tras = '';
$intcond_panel_techo = '';
$intcond_polarizado_del = '';
$intcond_polarizado_tras = '';
$intcond_seguro_puerta_del = '';
$intcond_seguro_puerta_tras = '';
$intacom_alfombra_del = '';
$intacom_alfombra_tras = '';
$intacom_apoya_brazo_del = '';
$intacom_apoya_brazo_tras = '';
$intacom_butaca_del = '';
$intacom_butaca_tras = '';
$intacom_cerradura_del = '';
$intacom_cerradura_tras = '';
$intacom_manija_puerta_del = '';
$intacom_manija_puerta_tras = '';
$intacom_manija_ventanilla_del = '';
$intacom_manija_ventanilla_tras = '';
$intacom_panel_puerta_del = '';
$intacom_panel_puerta_tras = '';
$intacom_panel_techo = '';
$intacom_polarizado_del = '';
$intacom_polarizado_tras = '';
$intacom_seguro_puerta_del = '';
$intacom_seguro_puerta_tras = '';
$extcond_bagueta_del = '';
$extcond_bagueta_tras = '';
$extcond_cerradura_del = '';
$extcond_cerradura_tras = '';
$extcond_espejo_lateral = '';
$extcond_espejo_retrovisor = '';
$extcond_manija_puerta_del = '';
$extcond_manija_puerta_tras = '';
$extcond_tapa_tanque = '';
$extcond_ventanilla_del = '';
$extcond_ventanilla_tras = '';
$extacom_bagueta_del = '';
$extacom_bagueta_tras = '';
$extacom_cerradura_del = '';
$extacom_cerradura_tras = '';
$extacom_espejo_lateral = '';
$extacom_manija_puerta_del = '';
$extacom_manija_puerta_tras = '';
$extacom_ventanilla_del = '';
$extacom_ventanilla_tras = '';
$extacom_higuiene_int = '';
$extacom_higuiene_ext = '';
$obs = '';

if  (isset($_GET['id']))
{
  $id = $_GET['id'];
  $query = "SELECT * FROM auditoria_vehiculo WHERE id=$id";
  $result = mysqli_query($conn, $query);
  if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_array($result);
    $tecnico = $row['tecnico'];
    $fecha = $row['fecha'];
    $dv_auxilio = $row['dv_auxilio'];
    $dv_balizas = $row['dv_balizas'];
    $dv_cedula = $row['dv_cedula'];
    $dv_chasis = $row['dv_chasis'];
    $dv_color = $row['dv_color'];
    $dv_criquet = $row['dv_criquet'];
    $dv_dominio = $row['dv_dominio'];
    $dv_llave_cruz = $row['dv_llave_cruz'];
    $dv_matafuego = $row['dv_matafuego'];
    $dv_modelo = $row['dv_modelo'];
    $dv_motor = $row['dv_motor'];
    $i_aire = $row['i_aire'];
    $i_balizas = $row['i_balizas'];
    $i_bocina = $row['i_bocina'];
    $i_calefaccion = $row['i_calefaccion'];
    $i_encendedor = $row['i_encendedor'];
    $i_giro_del_acom = $row['i_giro_del_acom'];
    $i_giro_del_conductor = $row['i_giro_del_conductor'];
    $i_giro_tras_acom = $row['i_giro_tras_acom'];
    $i_giro_tras_conductor = $row['i_giro_tras_conductor'];
    $i_limpiaparabrisa = $row['i_limpiaparabrisa'];
    $i_luz_alta = $row['i_luz_alta'];
    $i_luz_baja = $row['i_luz_baja'];
    $i_luz_freno = $row['i_luz_freno'];
    $i_sapito = $row['i_sapito'];
    $i_stereo = $row['i_stereo'];
    $i_tapa_fusilera = $row['i_tapa_fusilera'];
    $i_temperatura = $row['i_temperatura'];
    $i_velocimetro = $row['i_velocimetro'];
    $i_llave = $row['i_llave'];
    $tor_manijas_giro = $row['tor_manijas_giro'];
    $tor_manijas_luces = $row['tor_manijas_luces'];
    $tor_pulsadores = $row['tor_pulsadores'];
    $tor_rejilla_ventilacion = $row['tor_rejilla_ventilacion'];
    $extfre_capot = $row['extfre_capot'];
    $extfre_cubiertas = $row['extfre_cubiertas'];
    $extfre_llantas = $row['extfre_llantas'];
    $extfre_opticas = $row['extfre_opticas'];
    $extfre_parabrisas = $row['extfre_parabrisas'];
    $extfre_paragolpe = $row['extfre_paragolpe'];
    $extfre_parrilla = $row['extfre_parrilla'];
    $extfre_portaescalera = $row['extfre_portaescalera'];
    $exttras_baul = $row['exttras_baul'];
    $exttras_cano_esc = $row['exttras_cano_esc'];
    $exttras_cerradura = $row['exttras_cerradura'];
    $exttras_cubiertas = $row['exttras_cubiertas'];
    $exttras_llantas = $row['exttras_llantas'];
    $exttras_luneta = $row['exttras_luneta'];
    $exttras_opticas = $row['exttras_opticas'];
    $exttras_paragolpe = $row['exttras_paragolpe'];
    $intcond_alfombra_del = $row['intcond_alfombra_del'];
    $intcond_alfombra_tras = $row['intcond_alfombra_tras'];
    $intcond_apoya_brazo_del = $row['intcond_apoya_brazo_del'];
    $intcond_apoya_brazo_tras = $row['intcond_apoya_brazo_tras'];
    $intcond_butaca_del = $row['intcond_butaca_del'];
    $intcond_butaca_tras = $row['intcond_butaca_tras'];
    $intcond_cerradura_del = $row['intcond_cerradura_del'];
    $intcond_cerradura_tras = $row['intcond_cerradura_tras'];
    $intcond_manija_puerta_del = $row['intcond_manija_puerta_del'];
    $intcond_manija_puerta_tras = $row['intcond_manija_puerta_tras'];
    $intcond_manija_ventanilla_del = $row['intcond_manija_ventanilla_del'];
    $intcond_manija_ventanilla_tras = $row['intcond_manija_ventanilla_tras'];
    $intcond_panel_puerta_del = $row['intcond_panel_puerta_del'];
    $intcond_panel_puerta_tras = $row['intcond_panel_puerta_tras'];
    $intcond_panel_techo = $row['intcond_panel_techo'];
    $intcond_polarizado_del = $row['intcond_polarizado_del'];
    $intcond_polarizado_tras = $row['intcond_polarizado_tras'];
    $intcond_seguro_puerta_del = $row['intcond_seguro_puerta_del'];
    $intcond_seguro_puerta_tras = $row['intcond_seguro_puerta_tras'];
    $intacom_alfombra_del = $row['intacom_alfombra_del'];
    $intacom_alfombra_tras = $row['intacom_alfombra_tras'];
    $intacom_apoya_brazo_del = $row['intacom_apoya_brazo_del'];
    $intacom_apoya_brazo_tras = $row['intacom_apoya_brazo_tras'];
    $intacom_butaca_del = $row['intacom_butaca_del'];
    $intacom_butaca_tras = $row['intacom_butaca_tras'];
    $intacom_cerradura_del = $row['intacom_cerradura_del'];
    $intacom_cerradura_tras = $row['intacom_cerradura_tras'];
    $intacom_manija_puerta_del = $row['intacom_manija_puerta_del'];
    $intacom_manija_puerta_tras = $row['intacom_manija_puerta_tras'];
    $intacom_manija_ventanilla_del = $row['intacom_manija_ventanilla_del'];
    $intacom_manija_ventanilla_tras = $row['intacom_manija_ventanilla_tras'];
    $intacom_panel_puerta_del = $row['intacom_panel_puerta_del'];
    $intacom_panel_puerta_tras = $row['intacom_panel_puerta_tras'];
    $intacom_panel_techo = $row['intacom_panel_techo'];
    $intacom_polarizado_del = $row['intacom_polarizado_del'];
    $intacom_polarizado_tras = $row['intacom_polarizado_tras'];
    $intacom_seguro_puerta_del = $row['intacom_seguro_puerta_del'];
    $intacom_seguro_puerta_tras = $row['intacom_seguro_puerta_tras'];
    $extcond_bagueta_del = $row['extcond_bagueta_del'];
    $extcond_bagueta_tras = $row['extcond_bagueta_tras'];
    $extcond_cerradura_del = $row['extcond_cerradura_del'];
    $extcond_cerradura_tras = $row['extcond_cerradura_tras'];
    $extcond_espejo_lateral = $row['extcond_espejo_lateral'];
    $extcond_espejo_retrovisor = $row['extcond_espejo_retrovisor'];
    $extcond_manija_puerta_del = $row['extcond_manija_puerta_del'];
    $extcond_manija_puerta_tras = $row['extcond_manija_puerta_tras'];
    $extcond_tapa_tanque = $row['extcond_tapa_tanque'];
    $extcond_ventanilla_del = $row['extcond_ventanilla_del'];
    $extcond_ventanilla_tras = $row['extcond_ventanilla_tras'];
    $extacom_bagueta_del = $row['extacom_bagueta_del'];
    $extacom_bagueta_tras = $row['extacom_bagueta_tras'];
    $extacom_cerradura_del = $row['extacom_cerradura_del'];
    $extacom_cerradura_tras = $row['extacom_cerradura_tras'];
    $extacom_espejo_lateral = $row['extacom_espejo_lateral'];
    $extacom_manija_puerta_del = $row['extacom_manija_puerta_del'];
    $extacom_manija_puerta_tras = $row['extacom_manija_puerta_tras'];
    $extacom_ventanilla_del = $row['extacom_ventanilla_del'];
    $extacom_ventanilla_tras = $row['extacom_ventanilla_tras'];
    $extacom_higuiene_int = $row['extacom_higuiene_int'];
    $extacom_higuiene_ext = $row['extacom_higuiene_ext'];
    $obs = $row['obs'];



  }
}

if (isset($_POST['update']))
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
    'Auditoria vehiculos',
    '$hoy_movi',
    '$tipo_us',
    '$zona_us')");
  /* MOVIMIENTO INDIVIDUAL */

  $id = $_GET['id'];
  $tecnico= $_POST['tecnico'];
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

  

  $query = "UPDATE auditoria_vehiculo set tecnico = '$tecnico', fecha = '$fecha', dv_auxilio = '$dv_auxilio',
  dv_balizas = '$dv_balizas',
  dv_cedula = '$dv_cedula',
  dv_chasis = '$dv_chasis',
  dv_color = '$dv_color',
  dv_criquet = '$dv_criquet',
  dv_dominio = '$dv_dominio',
  dv_llave_cruz = '$dv_llave_cruz',
  dv_matafuego = '$dv_matafuego',
  dv_modelo = '$dv_modelo',
  dv_motor = '$dv_motor',
  i_aire = '$i_aire',
  i_balizas = '$i_balizas',
  i_bocina = '$i_bocina',
  i_calefaccion = '$i_calefaccion',
  i_encendedor = '$i_encendedor',
  i_giro_del_acom = '$i_giro_del_acom',
  i_giro_del_conductor = '$i_giro_del_conductor',
  i_giro_tras_acom = '$i_giro_tras_acom',
  i_giro_tras_conductor = '$i_giro_tras_conductor',
  i_limpiaparabrisa = '$i_limpiaparabrisa',
  i_luz_alta = '$i_luz_alta',
  i_luz_baja = '$i_luz_baja',
  i_luz_freno = '$i_luz_freno',
  i_sapito = '$i_sapito',
  i_stereo = '$i_stereo',
  i_tapa_fusilera = '$i_tapa_fusilera',
  i_temperatura = '$i_temperatura',
  i_velocimetro = '$i_velocimetro',
  i_llave = '$i_llave',
  tor_manijas_giro = '$tor_manijas_giro',
  tor_manijas_luces = '$tor_manijas_luces',
  tor_pulsadores = '$tor_pulsadores',
  tor_rejilla_ventilacion = '$tor_rejilla_ventilacion',
  extfre_capot = '$extfre_capot',
  extfre_cubiertas = '$extfre_cubiertas',
  extfre_llantas = '$extfre_llantas',
  extfre_opticas = '$extfre_opticas',
  extfre_parabrisas = '$extfre_parabrisas',
  extfre_paragolpe = '$extfre_paragolpe',
  extfre_parrilla = '$extfre_parrilla',
  extfre_portaescalera = '$extfre_portaescalera',
  exttras_baul = '$exttras_baul',
  exttras_cano_esc = '$exttras_cano_esc',
  exttras_cerradura = '$exttras_cerradura',
  exttras_cubiertas = '$exttras_cubiertas',
  exttras_llantas = '$exttras_llantas',
  exttras_luneta = '$exttras_luneta',
  exttras_opticas = '$exttras_opticas',
  exttras_paragolpe = '$exttras_paragolpe',
  intcond_alfombra_del = '$intcond_alfombra_del',
  intcond_alfombra_tras = '$intcond_alfombra_tras',
  intcond_apoya_brazo_del = '$intcond_apoya_brazo_del',
  intcond_apoya_brazo_tras = '$intcond_apoya_brazo_tras',
  intcond_butaca_del = '$intcond_butaca_del',
  intcond_butaca_tras = '$intcond_butaca_tras',
  intcond_cerradura_del = '$intcond_cerradura_del',
  intcond_cerradura_tras = '$intcond_cerradura_tras',
  intcond_manija_puerta_del = '$intcond_manija_puerta_del',
  intcond_manija_puerta_tras = '$intcond_manija_puerta_tras',
  intcond_manija_ventanilla_del = '$intcond_manija_ventanilla_del',
  intcond_manija_ventanilla_tras = '$intcond_manija_ventanilla_tras',
  intcond_panel_puerta_del = '$intcond_panel_puerta_del',
  intcond_panel_puerta_tras = '$intcond_panel_puerta_tras',
  intcond_panel_techo = '$intcond_panel_techo',
  intcond_polarizado_del = '$intcond_polarizado_del',
  intcond_polarizado_tras = '$intcond_polarizado_tras',
  intcond_seguro_puerta_del = '$intcond_seguro_puerta_del',
  intcond_seguro_puerta_tras = '$intcond_seguro_puerta_tras',
  intacom_alfombra_del = '$intacom_alfombra_del',
  intacom_alfombra_tras = '$intacom_alfombra_tras',
  intacom_apoya_brazo_del = '$intacom_apoya_brazo_del',
  intacom_apoya_brazo_tras = '$intacom_apoya_brazo_tras',
  intacom_butaca_del = '$intacom_butaca_del',
  intacom_butaca_tras = '$intacom_butaca_tras',
  intacom_cerradura_del = '$intacom_cerradura_del',
  intacom_cerradura_tras = '$intacom_cerradura_tras',
  intacom_manija_puerta_del = '$intacom_manija_puerta_del',
  intacom_manija_puerta_tras = '$intacom_manija_puerta_tras',
  intacom_manija_ventanilla_del = '$intacom_manija_ventanilla_del',
  intacom_manija_ventanilla_tras = '$intacom_manija_ventanilla_tras',
  intacom_panel_puerta_del = '$intacom_panel_puerta_del',
  intacom_panel_puerta_tras = '$intacom_panel_puerta_tras',
  intacom_panel_techo = '$intacom_panel_techo',
  intacom_polarizado_del = '$intacom_polarizado_del',
  intacom_polarizado_tras = '$intacom_polarizado_tras',
  intacom_seguro_puerta_del = '$intacom_seguro_puerta_del',
  intacom_seguro_puerta_tras = '$intacom_seguro_puerta_tras',
  extcond_bagueta_del = '$extcond_bagueta_del',
  extcond_bagueta_tras = '$extcond_bagueta_tras',
  extcond_cerradura_del = '$extcond_cerradura_del',
  extcond_cerradura_tras = '$extcond_cerradura_tras',
  extcond_espejo_lateral = '$extcond_espejo_lateral',
  extcond_espejo_retrovisor = '$extcond_espejo_retrovisor',
  extcond_manija_puerta_del = '$extcond_manija_puerta_del',
  extcond_manija_puerta_tras = '$extcond_manija_puerta_tras',
  extcond_tapa_tanque = '$extcond_tapa_tanque',
  extcond_ventanilla_del = '$extcond_ventanilla_del',
  extcond_ventanilla_tras = '$extcond_ventanilla_tras',
  extacom_bagueta_del = '$extacom_bagueta_del',
  extacom_bagueta_tras = '$extacom_bagueta_tras',
  extacom_cerradura_del = '$extacom_cerradura_del',
  extacom_cerradura_tras = '$extacom_cerradura_tras',
  extacom_espejo_lateral = '$extacom_espejo_lateral',
  extacom_manija_puerta_del = '$extacom_manija_puerta_del',
  extacom_manija_puerta_tras = '$extacom_manija_puerta_tras',
  extacom_ventanilla_del = '$extacom_ventanilla_del',
  extacom_ventanilla_tras = '$extacom_ventanilla_tras',
  extacom_higuiene_int = '$extacom_higuiene_int',
  extacom_higuiene_ext = '$extacom_higuiene_ext', 
  obs = '$obs' WHERE id=$id";
  $resultado = mysqli_query($conn, $query);
  if(!$resultado) {
  $msj = "Recuerda que el comentario es como maximo de 255 caracteres.";
  $color = "danger";
  }else{
  $msj = "La auditoria de " .$tecnico ." con el vehiculo " .$dv_dominio ." fue actualizada.";
  $color = "warning";
  }

  $_SESSION['card'] = 1;
  $_SESSION['message'] = $msj;
  $_SESSION['message_type'] = $color;
  header('Location: ../Basico/auditorias_vehiculo.php');
}
?>

<?php include('../includes/header.php'); ?>
<div class="container-fluid pr-4 pl-4 pt-0 pb-0">
  <div class="row pr-2 pl-2 pt-0 pb-0">
    <div class="container-fluid rounded bg-white shadow p-0">
      <div class="row justify-content-center p-1 m-0">
        <div class="col-auto">
          <div class="card card-body">
            <form action="edit_auditoria_vehiculo.php?id=<?php echo $_GET['id']; ?>" method="POST">
              <p class="h4 mb-4 text-center">Actualizar auditoria</p>
              <div class="form-row align-items-end">            
                <div class="form-group col">
                  <label for="exampleFormControlSelect1">Tecnico</label >
                  <select type="text" name="tecnico" class="form-control">                
                    <option selected><?php echo $tecnico; ?></option>                
                    <?php
                      $ejecutar=mysqli_query($conn,"SELECT * FROM tecnicos WHERE activo='SI' AND tipo='Tecnico' ORDER BY tecnico asc");
                    ?>
                    <?php foreach ($ejecutar as $opciones): ?>   
                      <option value="<?php echo $opciones['tecnico'] ?>"><?php echo $opciones['tecnico'] ?></option>                                      
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="form-group col">
                  <label for="exampleFormControlSelect1">Fecha de la instalacion</label >
                  <input type="text" id="fecha" name="fecha" value="<?php echo $fecha; ?>" readonly="" class="form-control" >
                </div> 
              </div>

              <div class="card card-body border-info">

                <p class="h4 mb-4 text-center">Datos del vehiculo</p>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Dominio</b></label >
                  <div class="form-row align-items-center">                  
                      <input type="text" maxlength="255" name="dv_dominio" class="form-control" autofocus value="<?php echo $dv_dominio; ?>">
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Color</b></label >
                  <div class="form-row align-items-center">                  
                      <input type="text" maxlength="255" name="dv_color" class="form-control" autofocus value="<?php echo $dv_color; ?>">
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Modelo</b></label >
                  <div class="form-row align-items-center">                  
                      <input type="text" maxlength="255" name="dv_modelo" class="form-control" autofocus value="<?php echo $dv_modelo; ?>">
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Balizas</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="dv_balizas" id="gridRadios2" value="BIEN" <?php if ($dv_balizas == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="dv_balizas" id="gridRadios2" value="MAL" <?php if ($dv_balizas == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Cedula</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="dv_cedula" id="gridRadios2" value="BIEN" <?php if ($dv_cedula == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="dv_cedula" id="gridRadios2" value="MAL"  <?php if ($dv_cedula == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Chasis</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="dv_chasis" id="gridRadios2" value="BIEN"  <?php if ($dv_chasis == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="dv_chasis" id="gridRadios2" value="MAL"  <?php if ($dv_chasis == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Criquet</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="dv_criquet" id="gridRadios2" value="BIEN" <?php if ($dv_criquet == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="dv_criquet" id="gridRadios2" value="MAL"  <?php if ($dv_criquet == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Llave cruz</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="dv_llave_cruz" id="gridRadios2" value="BIEN" <?php if ($dv_llave_cruz == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="dv_llave_cruz" id="gridRadios2" value="MAL"  <?php if ($dv_llave_cruz == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Matafuego</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="dv_matafuego" id="gridRadios2" value="BIEN" <?php if ($dv_matafuego == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="dv_matafuego" id="gridRadios2" value="MAL"  <?php if ($dv_matafuego == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Motor</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="dv_motor" id="gridRadios2" value="BIEN" <?php if ($dv_motor == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="dv_motor" id="gridRadios2" value="MAL"  <?php if ($dv_motor == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Rueda de auxilio</b></label>
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="dv_auxilio" id="gridRadios2" value="BIEN" <?php if ($dv_auxilio == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="dv_auxilio" id="gridRadios2" value="MAL"  <?php if ($dv_auxilio == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                </div>





              <div class="card card-body border-warning">

                <p class="h4 mb-4 text-center">Instrumental</p>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Aire</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="i_aire" id="gridRadios2" value="BIEN" <?php if ($i_aire == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="i_aire" id="gridRadios2" value="MAL"  <?php if ($i_aire == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Balizas</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="i_balizas" id="gridRadios2" value="BIEN" <?php if ($i_balizas == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="i_balizas" id="gridRadios2" value="MAL"  <?php if ($i_balizas == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Bocina</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="i_bocina" id="gridRadios2" value="BIEN" <?php if ($i_bocina == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="i_bocina" id="gridRadios2" value="MAL"  <?php if ($i_bocina == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Calefaccion</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="i_calefaccion" id="gridRadios2" value="BIEN" <?php if ($i_calefaccion == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="i_calefaccion" id="gridRadios2" value="MAL"  <?php if ($i_calefaccion == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Encendedor</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="i_encendedor" id="gridRadios2" value="BIEN" <?php if ($i_encendedor == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="i_encendedor" id="gridRadios2" value="MAL"  <?php if ($i_encendedor == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Giro delantero lado acompañante</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="i_giro_del_acom" id="gridRadios2" value="BIEN" <?php if ($i_giro_del_acom == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="i_giro_del_acom" id="gridRadios2" value="MAL"  <?php if ($i_giro_del_acom == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Giro delantero lado conductor</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="i_giro_del_conductor" id="gridRadios2" value="BIEN" <?php if ($i_giro_del_conductor == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="i_giro_del_conductor" id="gridRadios2" value="MAL"  <?php if ($i_giro_del_conductor == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Giro trasero lado acompañante</b></label>
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="i_giro_tras_acom" id="gridRadios2" value="BIEN" <?php if ($i_giro_tras_acom == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="i_giro_tras_acom" id="gridRadios2" value="MAL"  <?php if ($i_giro_tras_acom == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Giro trasero lado conductor</b></label>
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="i_giro_tras_conductor" id="gridRadios2" value="BIEN" <?php if ($i_giro_tras_conductor == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="i_giro_tras_conductor" id="gridRadios2" value="MAL"  <?php if ($i_giro_tras_conductor == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Limpiaparabrisa</b></label>
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="i_limpiaparabrisa" id="gridRadios2" value="BIEN" <?php if ($i_limpiaparabrisa == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="i_limpiaparabrisa" id="gridRadios2" value="MAL"  <?php if ($i_limpiaparabrisa == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Luces altas</b></label>
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="i_luz_alta" id="gridRadios2" value="BIEN" <?php if ($i_luz_alta == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="i_luz_alta" id="gridRadios2" value="MAL"  <?php if ($i_luz_alta == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Luces bajas</b></label>
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="i_luz_baja" id="gridRadios2" value="BIEN" <?php if ($i_luz_baja == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="i_luz_baja" id="gridRadios2" value="MAL"  <?php if ($i_luz_baja == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Luces de freno</b></label>
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="i_luz_freno" id="gridRadios2" value="BIEN" <?php if ($i_luz_freno == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="i_luz_freno" id="gridRadios2" value="MAL"  <?php if ($i_luz_freno == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Sapito</b></label>
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="i_sapito" id="gridRadios2" value="BIEN" <?php if ($i_sapito == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="i_sapito" id="gridRadios2" value="MAL"  <?php if ($i_sapito == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Stereo</b></label>
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="i_stereo" id="gridRadios2" value="BIEN" <?php if ($i_stereo == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="i_stereo" id="gridRadios2" value="MAL"  <?php if ($i_stereo == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Tapa fusilera</b></label>
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="i_tapa_fusilera" id="gridRadios2" value="BIEN" <?php if ($i_tapa_fusilera == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="i_tapa_fusilera" id="gridRadios2" value="MAL"  <?php if ($i_tapa_fusilera == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Medidor temperatura</b></label>
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="i_temperatura" id="gridRadios2" value="BIEN" <?php if ($i_temperatura == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="i_temperatura" id="gridRadios2" value="MAL"  <?php if ($i_temperatura == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Medidor velocimetro</b></label>
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="i_velocimetro" id="gridRadios2" value="BIEN" <?php if ($i_velocimetro == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="i_velocimetro" id="gridRadios2" value="MAL"  <?php if ($i_velocimetro == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Llave</b></label>
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="i_llave" id="gridRadios2" value="BIEN" <?php if ($i_llave == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="i_llave" id="gridRadios2" value="MAL"  <?php if ($i_llave == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                </div>




              <div class="card card-body border-primary">

              <p class="h4 mb-4 text-center">Torpedo</p>


                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Manijas de giro</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="tor_manijas_giro" id="gridRadios2" value="BIEN" <?php if ($tor_manijas_giro == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="tor_manijas_giro" id="gridRadios2" value="MAL"  <?php if ($tor_manijas_giro == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Manijas de luces</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="tor_manijas_luces" id="gridRadios2" value="BIEN" <?php if ($tor_manijas_luces == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="tor_manijas_luces" id="gridRadios2" value="MAL"  <?php if ($tor_manijas_luces == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Pulsadores</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="tor_pulsadores" id="gridRadios2" value="BIEN" <?php if ($tor_pulsadores == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="tor_pulsadores" id="gridRadios2" value="MAL"  <?php if ($tor_pulsadores == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Rejilla ventilacion</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="tor_rejilla_ventilacion" id="gridRadios2" value="BIEN" <?php if ($tor_rejilla_ventilacion == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="tor_rejilla_ventilacion" id="gridRadios2" value="MAL"  <?php if ($tor_rejilla_ventilacion == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>            

              </div>




              <div class="card card-body border-info">

              <p class="h4 mb-4 text-center">Exterior frente</p>


                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Capot</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="extfre_capot" id="gridRadios2" value="BIEN" <?php if ($extfre_capot == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="extfre_capot" id="gridRadios2" value="MAL"  <?php if ($extfre_capot == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Cubiertas</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="extfre_cubiertas" id="gridRadios2" value="BIEN" <?php if ($extfre_cubiertas == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="extfre_cubiertas" id="gridRadios2" value="MAL"  <?php if ($extfre_cubiertas == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Llantas</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="extfre_llantas" id="gridRadios2" value="BIEN" <?php if ($extfre_llantas == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="extfre_llantas" id="gridRadios2" value="MAL"  <?php if ($extfre_llantas == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Opticas</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="extfre_opticas" id="gridRadios2" value="BIEN" <?php if ($extfre_opticas == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="extfre_opticas" id="gridRadios2" value="MAL"  <?php if ($extfre_opticas == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div> 

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Parabrisa</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="extfre_parabrisas" id="gridRadios2" value="BIEN" <?php if ($extfre_parabrisas == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="extfre_parabrisas" id="gridRadios2" value="MAL"  <?php if ($extfre_parabrisas == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div> 

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Paragolpe</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="extfre_paragolpe" id="gridRadios2" value="BIEN" <?php if ($extfre_paragolpe == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="extfre_paragolpe" id="gridRadios2" value="MAL"  <?php if ($extfre_paragolpe == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>  

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Parrilla</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="extfre_parrilla" id="gridRadios2" value="BIEN" <?php if ($extfre_parrilla == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="extfre_parrilla" id="gridRadios2" value="MAL"  <?php if ($extfre_parrilla == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Portaescalera</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="extfre_portaescalera" id="gridRadios2" value="BIEN" <?php if ($extfre_portaescalera == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="extfre_portaescalera" id="gridRadios2" value="MAL"  <?php if ($extfre_portaescalera == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>         
                </div>         

              </div>





              <div class="card card-body border-warning">

              <p class="h4 mb-4 text-center">Exterior trasero</p>


                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Baul</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="exttras_baul" id="gridRadios2" value="BIEN" <?php if ($exttras_baul == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="exttras_baul" id="gridRadios2" value="MAL"  <?php if ($exttras_baul == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Caño escape</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="exttras_cano_esc" id="gridRadios2" value="BIEN" <?php if ($exttras_cano_esc == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="exttras_cano_esc" id="gridRadios2" value="MAL"  <?php if ($exttras_cano_esc == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Cerradura</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="exttras_cerradura" id="gridRadios2" value="BIEN" <?php if ($exttras_cerradura == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="exttras_cerradura" id="gridRadios2" value="MAL"  <?php if ($exttras_cerradura == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Cubiertas</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="exttras_cubiertas" id="gridRadios2" value="BIEN" <?php if ($exttras_cubiertas == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="exttras_cubiertas" id="gridRadios2" value="MAL"  <?php if ($exttras_cubiertas == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div> 

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Llantas</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="exttras_llantas" id="gridRadios2" value="BIEN" <?php if ($exttras_llantas == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="exttras_llantas" id="gridRadios2" value="MAL"  <?php if ($exttras_llantas == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div> 

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Luneta</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="exttras_luneta" id="gridRadios2" value="BIEN" <?php if ($exttras_luneta == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="exttras_luneta" id="gridRadios2" value="MAL"  <?php if ($exttras_luneta == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div>  

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Opticas</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="exttras_opticas" id="gridRadios2" value="BIEN" <?php if ($exttras_opticas == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="exttras_opticas" id="gridRadios2" value="MAL"  <?php if ($exttras_opticas == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Paragolpe</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="exttras_paragolpe" id="gridRadios2" value="BIEN" <?php if ($exttras_paragolpe == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="exttras_paragolpe" id="gridRadios2" value="MAL"  <?php if ($exttras_paragolpe == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div>         

              </div>







              <div class="card card-body border-success">

              <p class="h4 mb-4 text-center">Interior lado acompañante</p>


                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Alfombra delantera</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intacom_alfombra_del" id="gridRadios2" value="BIEN" <?php if ($intacom_alfombra_del == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intacom_alfombra_del" id="gridRadios2" value="MAL"  <?php if ($intacom_alfombra_del == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Alfombra trasera</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intacom_alfombra_tras" id="gridRadios2" value="BIEN" <?php if ($intacom_alfombra_tras == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intacom_alfombra_tras" id="gridRadios2" value="MAL"  <?php if ($intacom_alfombra_tras == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Apoya brazo delantero</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intacom_apoya_brazo_del" id="gridRadios2" value="BIEN" <?php if ($intacom_apoya_brazo_del == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intacom_apoya_brazo_del" id="gridRadios2" value="MAL"  <?php if ($intacom_apoya_brazo_del == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Apoya brazo trasero</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intacom_apoya_brazo_tras" id="gridRadios2" value="BIEN" <?php if ($intacom_apoya_brazo_tras == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intacom_apoya_brazo_tras" id="gridRadios2" value="MAL"  <?php if ($intacom_apoya_brazo_tras == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div> 

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Butaca delantera</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intacom_butaca_del" id="gridRadios2" value="BIEN" <?php if ($intacom_butaca_del == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intacom_butaca_del" id="gridRadios2" value="MAL"  <?php if ($intacom_butaca_del == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div> 

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Butaca trasera</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intacom_butaca_tras" id="gridRadios2" value="BIEN" <?php if ($intacom_butaca_tras == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intacom_butaca_tras" id="gridRadios2" value="MAL"  <?php if ($intacom_butaca_tras == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div>  

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Cerradura delantera</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intacom_cerradura_del" id="gridRadios2" value="BIEN" <?php if ($intacom_cerradura_del == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intacom_cerradura_del" id="gridRadios2" value="MAL"  <?php if ($intacom_cerradura_del == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Cerradura trasera</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intacom_cerradura_tras" id="gridRadios2" value="BIEN" <?php if ($intacom_cerradura_tras == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intacom_cerradura_tras" id="gridRadios2" value="MAL"  <?php if ($intacom_cerradura_tras == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div> 

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Manija puerta delantera</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intacom_manija_puerta_del" id="gridRadios2" value="BIEN" <?php if ($intacom_manija_puerta_del == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intacom_manija_puerta_del" id="gridRadios2" value="MAL"  <?php if ($intacom_manija_puerta_del == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Manija puerta trasera</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intacom_manija_puerta_tras" id="gridRadios2" value="BIEN" <?php if ($intacom_manija_puerta_tras == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intacom_manija_puerta_tras" id="gridRadios2" value="MAL"  <?php if ($intacom_manija_puerta_tras == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Manija ventanilla delantera</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intacom_manija_ventanilla_del" id="gridRadios2" value="BIEN" <?php if ($intacom_manija_ventanilla_del == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intacom_manija_ventanilla_del" id="gridRadios2" value="MAL"  <?php if ($intacom_manija_ventanilla_del == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Manija ventanilla trasera</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intacom_manija_ventanilla_tras" id="gridRadios2" value="BIEN" <?php if ($intacom_manija_ventanilla_tras == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intacom_manija_ventanilla_tras" id="gridRadios2" value="MAL"  <?php if ($intacom_manija_ventanilla_tras == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Panel puerta delantera</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intacom_panel_puerta_del" id="gridRadios2" value="BIEN" <?php if ($intacom_panel_puerta_del == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intacom_panel_puerta_del" id="gridRadios2" value="MAL"  <?php if ($intacom_panel_puerta_del == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Panel puerta trasera</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intacom_panel_puerta_tras" id="gridRadios2" value="BIEN" <?php if ($intacom_panel_puerta_tras == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intacom_panel_puerta_tras" id="gridRadios2" value="MAL"  <?php if ($intacom_panel_puerta_tras == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Panel del techo</b></label>
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intacom_panel_techo" id="gridRadios2" value="BIEN" <?php if ($intacom_panel_techo == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intacom_panel_techo" id="gridRadios2" value="MAL"  <?php if ($intacom_panel_techo == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Polarizado delantero</b></label>
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intacom_polarizado_del" id="gridRadios2" value="BIEN" <?php if ($intacom_polarizado_del == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intacom_polarizado_del" id="gridRadios2" value="MAL"  <?php if ($intacom_polarizado_del == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Polarizado trasero</b></label>
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intacom_polarizado_tras" id="gridRadios2" value="BIEN" <?php if ($intacom_polarizado_tras == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intacom_polarizado_tras" id="gridRadios2" value="MAL"  <?php if ($intacom_polarizado_tras == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Seguro puerta delantera</b></label>
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intacom_seguro_puerta_del" id="gridRadios2" value="BIEN" <?php if ($intacom_seguro_puerta_del == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intacom_seguro_puerta_del" id="gridRadios2" value="MAL"  <?php if ($intacom_seguro_puerta_del == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Seguro puerta trasera</b></label>
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intacom_seguro_puerta_tras" id="gridRadios2" value="BIEN" <?php if ($intacom_seguro_puerta_tras == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intacom_seguro_puerta_tras" id="gridRadios2" value="MAL"  <?php if ($intacom_seguro_puerta_tras == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div>

              </div>






              <div class="card card-body border-danger">

              <p class="h4 mb-4 text-center">Interior lado conductor</p>


                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Alfombra delantera</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intcond_alfombra_del" id="gridRadios2" value="BIEN" <?php if ($intcond_alfombra_del == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intcond_alfombra_del" id="gridRadios2" value="MAL"  <?php if ($intcond_alfombra_del == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Alfombra trasera</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intcond_alfombra_tras" id="gridRadios2" value="BIEN" <?php if ($intcond_alfombra_tras == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intcond_alfombra_tras" id="gridRadios2" value="MAL"  <?php if ($intcond_alfombra_tras == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Apoya brazo delantero</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intcond_apoya_brazo_del" id="gridRadios2" value="BIEN" <?php if ($intcond_apoya_brazo_del == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intcond_apoya_brazo_del" id="gridRadios2" value="MAL"  <?php if ($intcond_apoya_brazo_del == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Apoya brazo trasero</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intcond_apoya_brazo_tras" id="gridRadios2" value="BIEN" <?php if ($intcond_apoya_brazo_tras == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intcond_apoya_brazo_tras" id="gridRadios2" value="MAL"  <?php if ($intcond_apoya_brazo_tras == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div> 

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Butaca delantera</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intcond_butaca_del" id="gridRadios2" value="BIEN" <?php if ($intcond_butaca_del == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intcond_butaca_del" id="gridRadios2" value="MAL"  <?php if ($intcond_butaca_del == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div> 

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Butaca trasera</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intcond_butaca_tras" id="gridRadios2" value="BIEN" <?php if ($intcond_butaca_tras == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intcond_butaca_tras" id="gridRadios2" value="MAL"  <?php if ($intcond_butaca_tras == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div>  

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Cerradura delantera</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intcond_cerradura_del" id="gridRadios2" value="BIEN" <?php if ($intcond_cerradura_del == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intcond_cerradura_del" id="gridRadios2" value="MAL"  <?php if ($intcond_cerradura_del == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Cerradura trasera</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intcond_cerradura_tras" id="gridRadios2" value="BIEN" <?php if ($intcond_cerradura_tras == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intcond_cerradura_tras" id="gridRadios2" value="MAL"  <?php if ($intcond_cerradura_tras == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div> 

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Manija puerta delantera</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intcond_manija_puerta_del" id="gridRadios2" value="BIEN" <?php if ($intcond_manija_puerta_del == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intcond_manija_puerta_del" id="gridRadios2" value="MAL"  <?php if ($intcond_manija_puerta_del == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Manija puerta trasera</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intcond_manija_puerta_tras" id="gridRadios2" value="BIEN" <?php if ($intcond_manija_puerta_tras == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intcond_manija_puerta_tras" id="gridRadios2" value="MAL"  <?php if ($intcond_manija_puerta_tras == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Manija ventanilla delantera</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intcond_manija_ventanilla_del" id="gridRadios2" value="BIEN" <?php if ($intcond_manija_ventanilla_del == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intcond_manija_ventanilla_del" id="gridRadios2" value="MAL"  <?php if ($intcond_manija_ventanilla_del == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Manija ventanilla trasera</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intcond_manija_ventanilla_tras" id="gridRadios2" value="BIEN" <?php if ($intcond_manija_ventanilla_tras == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intcond_manija_ventanilla_tras" id="gridRadios2" value="MAL"  <?php if ($intcond_manija_ventanilla_tras == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Panel puerta delantera</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intcond_panel_puerta_del" id="gridRadios2" value="BIEN" <?php if ($intcond_panel_puerta_del == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intcond_panel_puerta_del" id="gridRadios2" value="MAL"  <?php if ($intcond_panel_puerta_del == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Panel puerta trasera</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intcond_panel_puerta_tras" id="gridRadios2" value="BIEN" <?php if ($intcond_panel_puerta_tras == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intcond_panel_puerta_tras" id="gridRadios2" value="MAL"  <?php if ($intcond_panel_puerta_tras == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Panel del techo</b></label>
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intcond_panel_techo" id="gridRadios2" value="BIEN" <?php if ($intcond_panel_techo == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intcond_panel_techo" id="gridRadios2" value="MAL"  <?php if ($intcond_panel_techo == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Polarizado delantero</b></label>
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intcond_polarizado_del" id="gridRadios2" value="BIEN" <?php if ($intcond_polarizado_del == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intcond_polarizado_del" id="gridRadios2" value="MAL"  <?php if ($intcond_polarizado_del == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Polarizado trasero</b></label>
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intcond_polarizado_tras" id="gridRadios2" value="BIEN" <?php if ($intcond_polarizado_tras == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intcond_polarizado_tras" id="gridRadios2" value="MAL"  <?php if ($intcond_polarizado_tras == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Seguro puerta delantera</b></label>
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intcond_seguro_puerta_del" id="gridRadios2" value="BIEN" <?php if ($intcond_seguro_puerta_del == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intcond_seguro_puerta_del" id="gridRadios2" value="MAL"  <?php if ($intcond_seguro_puerta_del == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Seguro puerta trasera</b></label>
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intcond_seguro_puerta_tras" id="gridRadios2" value="BIEN" <?php if ($intcond_seguro_puerta_tras == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="intcond_seguro_puerta_tras" id="gridRadios2" value="MAL"  <?php if ($intcond_seguro_puerta_tras == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div>

              </div>









              <div class="card card-body border-success">

              <p class="h4 mb-4 text-center">Exterior lado acompañante</p>


                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Bagueta delantera</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="extacom_bagueta_del" id="gridRadios2" value="BIEN" <?php if ($extacom_bagueta_del == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="extacom_bagueta_del" id="gridRadios2" value="MAL"  <?php if ($extacom_bagueta_del == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Bagueta trasera</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="extacom_bagueta_tras" id="gridRadios2" value="BIEN" <?php if ($extacom_bagueta_tras == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="extacom_bagueta_tras" id="gridRadios2" value="MAL"  <?php if ($extacom_bagueta_tras == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Cerradura delantera</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="extacom_cerradura_del" id="gridRadios2" value="BIEN" <?php if ($extacom_cerradura_del == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="extacom_cerradura_del" id="gridRadios2" value="MAL"  <?php if ($extacom_cerradura_del == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Cerradura trasera</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="extacom_cerradura_tras" id="gridRadios2" value="BIEN" <?php if ($extacom_cerradura_tras == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="extacom_cerradura_tras" id="gridRadios2" value="MAL"  <?php if ($extacom_cerradura_tras == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div> 

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Espejo lateral</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="extacom_espejo_lateral" id="gridRadios2" value="BIEN" <?php if ($extacom_espejo_lateral == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="extacom_espejo_lateral" id="gridRadios2" value="MAL"  <?php if ($extacom_espejo_lateral == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div> 

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Manija puerta delantera</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="extacom_manija_puerta_del" id="gridRadios2" value="BIEN" <?php if ($extacom_manija_puerta_del == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="extacom_manija_puerta_del" id="gridRadios2" value="MAL"  <?php if ($extacom_manija_puerta_del == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div>  

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Manija puerta trasera</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="extacom_manija_puerta_tras" id="gridRadios2" value="BIEN" <?php if ($extacom_manija_puerta_tras == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="extacom_manija_puerta_tras" id="gridRadios2" value="MAL"  <?php if ($extacom_manija_puerta_tras == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Ventanilla delantera</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="extacom_ventanilla_del" id="gridRadios2" value="BIEN" <?php if ($extacom_ventanilla_del == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="extacom_ventanilla_del" id="gridRadios2" value="MAL"  <?php if ($extacom_ventanilla_del == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div> 

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Ventanilla trasera</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="extacom_ventanilla_tras" id="gridRadios2" value="BIEN" <?php if ($extacom_ventanilla_tras == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="extacom_ventanilla_tras" id="gridRadios2" value="MAL"  <?php if ($extacom_ventanilla_tras == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Higuiene interior</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="extacom_higuiene_int" id="gridRadios2" value="BIEN" <?php if ($extacom_higuiene_int == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="extacom_higuiene_int" id="gridRadios2" value="MAL"  <?php if ($extacom_higuiene_int == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Higuiene exterior</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="extacom_higuiene_ext" id="gridRadios2" value="BIEN" <?php if ($extacom_higuiene_ext == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="extacom_higuiene_ext" id="gridRadios2" value="MAL"  <?php if ($extacom_higuiene_ext == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div>    

              </div>
















              <div class="card card-body border-danger">

              <p class="h4 mb-4 text-center">Exterior lado conductor</p>


                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Bagueta delantera</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="extcond_bagueta_del" id="gridRadios2" value="BIEN" <?php if ($extcond_bagueta_del == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="extcond_bagueta_del" id="gridRadios2" value="MAL"  <?php if ($extcond_bagueta_del == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Bagueta trasera</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="extcond_bagueta_tras" id="gridRadios2" value="BIEN" <?php if ($extcond_bagueta_tras == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="extcond_bagueta_tras" id="gridRadios2" value="MAL"  <?php if ($extcond_bagueta_tras == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Cerradura delantera</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="extcond_cerradura_del" id="gridRadios2" value="BIEN" <?php if ($extcond_cerradura_del == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="extcond_cerradura_del" id="gridRadios2" value="MAL"  <?php if ($extcond_cerradura_del == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Cerradura trasera</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="extcond_cerradura_tras" id="gridRadios2" value="BIEN" <?php if ($extcond_cerradura_tras == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="extcond_cerradura_tras" id="gridRadios2" value="MAL"  <?php if ($extcond_cerradura_tras == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div> 

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Espejo lateral</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="extcond_espejo_lateral" id="gridRadios2" value="BIEN" <?php if ($extcond_espejo_lateral == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="extcond_espejo_lateral" id="gridRadios2" value="MAL"  <?php if ($extcond_espejo_lateral == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div> 

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Espejo retrovisor</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="extcond_espejo_retrovisor" id="gridRadios2" value="BIEN" <?php if ($extcond_espejo_retrovisor == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="extcond_espejo_retrovisor" id="gridRadios2" value="MAL"  <?php if ($extcond_espejo_retrovisor == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div>  

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Manija puerta delantera</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="extcond_manija_puerta_del" id="gridRadios2" value="BIEN" <?php if ($extcond_manija_puerta_del == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="extcond_manija_puerta_del" id="gridRadios2" value="MAL"  <?php if ($extcond_manija_puerta_del == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Manija puerta trasera</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="extcond_manija_puerta_tras" id="gridRadios2" value="BIEN" <?php if ($extcond_manija_puerta_tras == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="extcond_manija_puerta_tras" id="gridRadios2" value="MAL"  <?php if ($extcond_manija_puerta_tras == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div> 

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Tapa del tanque</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="extcond_tapa_tanque" id="gridRadios2" value="BIEN" <?php if ($extcond_tapa_tanque == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="extcond_tapa_tanque" id="gridRadios2" value="MAL"  <?php if ($extcond_tapa_tanque == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Ventanilla delantera</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="extcond_ventanilla_del" id="gridRadios2" value="BIEN" <?php if ($extcond_ventanilla_del == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="extcond_ventanilla_del" id="gridRadios2" value="MAL"  <?php if ($extcond_ventanilla_del == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div>

                <div class="card card-body">
                  <label for="exampleFormControlSelect1"><b>Ventanilla trasera</b></label >
                  <div class="form-row align-items-center">
                      <div class="form-group col-xs-2">
                        <legend class="col-form-label col">Estado</legend>
                      </div>
                      <div class="form-group col-xs-10">
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="extcond_ventanilla_tras" id="gridRadios2" value="BIEN" <?php if ($extcond_ventanilla_tras == 'BIEN') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline1">Bien</label>
                        </div>
                        <div class="form-check custom-control-inline">
                          <input class="form-check-input" type="radio" name="extcond_ventanilla_tras" id="gridRadios2" value="MAL"  <?php if ($extcond_ventanilla_tras == 'MAL') {echo "checked";} ?>>
                          <label class="form-check-label" for="customRadioInline2">Mal</label>
                        </div>
                      </div>
                  </div>
                </div>    

              </div>


              <br>
                <div class="col">
                  <label for="exampleFormControlSelect1"><b>Observaciones (Max 1000 caracteres)</b></label >
                  <textarea type="text" name="obs" maxlength="1000" class="form-control" placeholder="Ingrese una observacion"><?php echo $obs; ?></textarea>
                </div> 
              
              <br>
              <input type="submit" name="update" class="btn btn-success btn-block" value="Actualizar auditoria">
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- PIE DE PAGINA -->
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<!-- then Popper -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<!-- Boapellidostrap -->
<script src="https://stackpath.boapellidostrapcdn.com/boapellidostrap/4.4.1/js/boapellidostrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<!-- Datatable -->
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<!-- Filtro por columnas -->
<script src="https://cdn.datatables.net/fixedheader/3.1.6/js/dataTables.fixedHeader.min.js"></script> 
<!-- Calendario -->
<script src="../jquery-3.3.1.min.js"></script>
<script src="../jquery-ui-1.12.1.custom/jquery-ui.js"></script>
<script type="text/javascript">
  $(function() {
    $("#fecha").datepicker({ dateFormat: "yy-mm-dd"});
    $( "#anim" ).on( "change", function() {
      $( "#fecha" ).datepicker( "option", "showAnim", $( this ).val() );
    });
  } );
</script>
</body>
</html>
