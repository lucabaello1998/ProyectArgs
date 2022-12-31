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
$quien_notas = $_SESSION['nombre'] . ' ' .$_SESSION['apellido'];
if($tipo_us == "Administrador") { $usu = 1; }
if($tipo_us == "Despacho") { $usu = 1; }
if($tipo_us == "Supervisor") { $usu = 1; }
if($tipo_us == "Deposito") { $usu = 1; }
if($usu != 1)
{
  header("location: ../index.php");
}

require_once('../Basico/excel/vendor/php-excel-reader/excel_reader2.php');
require_once('../Basico/excel/vendor/SpreadsheetReader.php');

if(isset($_POST['regula']))
{
    /* MOVIMIENTO INDIVIDUAL */
        $token_movi = uniqid();
        
        $tipo_us = $_SESSION['tipo_us'];
        $zona_us = $_SESSION['zona'];
        $hoy_movi = date("Y-m-j");
        mysqli_query($conn, "INSERT INTO movimiento_interno(token, quien, movimiento, pag, inicio, tipo, zona) VALUES ('$token_movi', '$quien_notas', 'Guardado', 'Ingreso de regularizacion', '$hoy_movi', '$tipo_us', '$zona_us')");
    /* MOVIMIENTO INDIVIDUAL */
    
    $allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
  
  if(in_array($_FILES["file"]["type"],$allowedFileType))
    {
			$targetPath = '../Archivos/regularizacion/'.$_FILES['file']['name'];
			move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);
			
			$Reader = new SpreadsheetReader($targetPath);

      $contador = 0;
			
			$sheetCount = count($Reader->sheets());
			for($i=0;$i<$sheetCount;$i++)
			{
					
				$Reader->ChangeSheet($i);
				
				foreach ($Reader as $Row)
				{
					$sn = "";
          // Si existe la primera columna, obtiene los datos
					if(isset($Row[0])) {
						$sn = mysqli_real_escape_string($conn,$Row[0]);
					}

					$ot = "";
          // Si existe la segunda columna, obtiene los datos
					if(isset($Row[1])) {
						$ot = mysqli_real_escape_string($conn,$Row[1]);
					}

          // Establecemos las variables
          $fecha = '';
          $tecnico = '';
          $deposito = '';

          //Buscamos en la base de datos de altas
          $a = mysqli_query($conn, "SELECT * FROM altas WHERE sn_ont = '$sn' OR sn_uno_stb = '$sn' OR sn_dos_stb = '$sn' OR sn_tres_stb = '$sn' OR ap_uno_sn = '$sn' OR ap_dos_sn = '$sn' OR ap_tres_sn = '$sn'  LIMIT 1 ");
          if (mysqli_num_rows($a) == 1)
          {
            //Si hay alguna coincidencia guardame los valores de fecha, tecnico, zona y ot
            while($row = mysqli_fetch_array($a))
            {
              $fecha = $row['calendario'];
              $tecnico = $row['tecnico'];
              $deposito = $row['zona'];
              if($ot == '')
              {
                $ot = $row['ot'];
              }
            }
          }
          else
          {
            //Buscamos en la base de datos de mantenimientos
            $c = mysqli_query($conn, "SELECT * FROM mtto WHERE ont_sn = '$sn' OR stb_sn_uno = '$sn' OR stb_sn_dos = '$sn' OR stb_sn_tres = '$sn' LIMIT 1 ");
            if (mysqli_num_rows($c) == 1)
            {
              //Si hay alguna coincidencia guardame los valores de fecha, tecnico, zona y ot
              while($row = mysqli_fetch_array($c))
              {
                $fecha = $row['fecha'];
                $tecnico = $row['tecnico'];
                $deposito = $row['zona'];
                if($ot == '')
                {
                  $ot = $row['ot'];
                }
              }
            }
          }

          // Busca en la base de datos de materiales ingresados donde coincida el nuemro de serie y no haya sido devuelto
          $b = mysqli_query($conn, "SELECT * FROM ingresomaterial WHERE seriado = '$sn' AND obs NOT LIKE 'Material devuelto en el remito%'");
          if (mysqli_num_rows($b) >= 1)
          {
            while($row = mysqli_fetch_array($b))
            {
              $material = $row['material'];

              if($row['sap'] == '0' || $row['sap'] == '')
              {
                $f = mysqli_query($conn, "SELECT * FROM basemateriales WHERE material = '$material'");
                if (mysqli_num_rows($f) >= 1)
                {
                  while($rof = mysqli_fetch_array($f))
                  {
                    $sap = $rof['sap'];
                  }
                }
              }
              else
              {
                $sap = $row['sap'];
              }
              if($ot == '')
              {
                $cantidad = $row['cantidad'];
                $obs = '';
              }
              else
              {
                $cantidad = '0';
                $obs = 'regularizacion de material, equipo usado por ' .$tecnico;
              }

              if($sn !== '')
              {
                $bbb = mysqli_query($conn, "UPDATE ingresomaterial set sap = '$sap', ot = '$ot', cantidad = '$cantidad', deposito = '$deposito', descargado_cuando = '$fecha', obs = '$obs' WHERE seriado = '$sn' ");

                if ($bbb)
                {
                  

                  $e = mysqli_query($conn, "SELECT * FROM asignacion_material WHERE seriado = '$sn' AND tipo = 'Descarga' AND usado = '1' ");
                  if (mysqli_num_rows($e) >= 1)
                  {
                    $contador += 1;
                    $titulo_toast = "Guardado";
                    $msj_toast = "ingreso de material con " .$contador ."equipos";
                    $color_toast = "success";
                    $_SESSION['card'] = 1;
                    $_SESSION['titulo_toast'] = $titulo_toast;
                    $_SESSION['mensaje_toast'] = $msj_toast;
                    $_SESSION['color_toast'] = $color_toast;
                    header('Location: ../Basico/regularizacion.php');
                  }
                  else
                  {
                    $strtotime = (strtotime("now"));
                    $result_id = mysqli_query($conn, "SELECT * FROM tecnicos WHERE tecnico = '$tecnico' ");
                    while($row = mysqli_fetch_assoc($result_id))
                    {
                      $id_tec = $row['token'];
                    }
                    $d = mysqli_query($conn, "INSERT INTO asignacion_material (quien, token, fecha, tecnico, id_tec, sap, material, seriado, cantidad, usado, ot, deposito, tipo) VALUES ('$quien_notas', '$strtotime', '$fecha', '$tecnico', '$id_tec', '$sap', '$material', '$sn', '0', '1', '$ot', '$deposito', 'Descarga')");

                    if ($d)
                    {
                      $contador += 1;
                      $titulo_toast = "Guardado";
                      $msj_toast = "ingreso de material y descarga actualizados con " .$contador ." equipos";
                      $color_toast = "success";
                      $_SESSION['card'] = 1;
                      $_SESSION['titulo_toast'] = $titulo_toast;
                      $_SESSION['mensaje_toast'] = $msj_toast;
                      $_SESSION['color_toast'] = $color_toast;
                      header('Location: ../Basico/regularizacion.php');
                    }
                    else
                    {
                      $titulo_toast = "Guardado";
                      $msj_toast = "Ingreso de material actualizado con " .$contador ." equipos";
                      $color_toast = "success";
                      $_SESSION['card'] = 1;
                      $_SESSION['titulo_toast'] = $titulo_toast;
                      $_SESSION['mensaje_toast'] = $msj_toast;
                      $_SESSION['color_toast'] = $color_toast;
                      header('Location: ../Basico/regularizacion.php');
                    }
                  }
                }
                else
                {
                  $titulo_toast = "Error";
                  $msj_toast = "Hubo un problema al cargar los datos";
                  $color_toast = "danger";
                  $_SESSION['card'] = 1;
                  $_SESSION['titulo_toast'] = $titulo_toast;
                  $_SESSION['mensaje_toast'] = $msj_toast;
                  $_SESSION['color_toast'] = $color_toast;
                  header('Location: ../Basico/regularizacion.php');
                }
              }
            }
          }
				}
			}
    }
    else
    { 
			$titulo_toast = "Error";
			$msj_toast = "Fallo el envio";
			$color_toast = "danger";
			$_SESSION['card'] = 1;
			$_SESSION['titulo_toast'] = $titulo_toast;
			$_SESSION['mensaje_toast'] = $msj_toast;
			$_SESSION['color_toast'] = $color_toast;
			header('Location: ../Basico/regularizacion.php');
    }

    ?>
    <script src="../Basico/excel/assets/jquery-1.12.4-jquery.min.js"></script>
    <?php

  $_SESSION['card'] = 1;
  $_SESSION['titulo_toast'] = $titulo_toast;
  $_SESSION['mensaje_toast'] = $msj_toast;
  $_SESSION['color_toast'] = $color_toast;
  header('Location: ../Basico/regularizacion.php');
}
?>