<?php
include("../db.php");
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
if($tipo == "Deposito") { $usu = 1; }
if($usu != 1)
{
  header("location: ../index.php");
}
$nombre = $_SESSION['nombre'];
$apellido = $_SESSION['apellido'];

require_once('../Basico/excel/vendor/php-excel-reader/excel_reader2.php');
require_once('../Basico/excel/vendor/SpreadsheetReader.php');

if(isset($_POST['import']))
{
    /* MOVIMIENTO INDIVIDUAL */
        $token_movi = uniqid();
        $quien_notas = $_SESSION['nombre'] . ' ' .$_SESSION['apellido'];
        $tipo_us = $_SESSION['tipo_us'];
        $zona_us = $_SESSION['zona'];
        $hoy_movi = date("Y-m-j");
        mysqli_query($conn, "INSERT INTO movimiento_interno(token, quien, movimiento, pag, inicio, tipo, zona) VALUES ('$token_movi', '$quien_notas', 'Guardado', 'Ingreso de material excel', '$hoy_movi', '$tipo_us', '$zona_us')");
    /* MOVIMIENTO INDIVIDUAL */

    $quien = $nombre ." " .$apellido;

    $fecha = $_POST['fecha'];
    $proveedor = $_POST['proveedor'];
    $deposito = $_POST['deposito'];
    $obs = $_POST['obs'];

    
    $allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
  
  if(in_array($_FILES["file"]["type"],$allowedFileType))
    {

        $targetPath = '../Basico/excel/subidas/'.$_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);
        
        $Reader = new SpreadsheetReader($targetPath);
        
        $sheetCount = count($Reader->sheets());
        for($i=0;$i<$sheetCount;$i++)
        {
            
            $Reader->ChangeSheet($i);
            
            foreach ($Reader as $Row)
            {
          
                $nro_pedido = "";
                if(isset($Row[0])) {
                    $nro_pedido = mysqli_real_escape_string($conn,$Row[0]);
                }
                
                $nro_entrega = "";
                if(isset($Row[1])) {
                    $nro_entrega = mysqli_real_escape_string($conn,$Row[1]);
                }
        
                $fecha_pedido = "";
                if(isset($Row[2])) {
                    $fecha_pedido = mysqli_real_escape_string($conn,$Row[2]);
                }
        
                $fecha_aprobado = "";
                if(isset($Row[3])) {
                    $fecha_aprobado = mysqli_real_escape_string($conn,$Row[3]);
                }

                $contratista = "";
                if(isset($Row[4])) {
                    $contratista = mysqli_real_escape_string($conn,$Row[4]);
                }

                $nombre_contratista = "";
                if(isset($Row[5])) {
                    $nombre_contratista = mysqli_real_escape_string($conn,$Row[5]);
                }

                $num_material = "";
                if(isset($Row[6])) {
                    $num_material = mysqli_real_escape_string($conn,$Row[6]);
                }

                $descripcion_material = "";
                if(isset($Row[7])) {
                    $descripcion_material = mysqli_real_escape_string($conn,$Row[7]);
                }

                $cantidad = "";
                if(isset($Row[8])) {
                    $canti = mysqli_real_escape_string($conn,$Row[8]);
                    $cantidad = (int)$canti;
                }

                $status = "";
                if(isset($Row[9])) {
                    $status = mysqli_real_escape_string($conn,$Row[9]);
                }

                $inicio_prep = "";
                if(isset($Row[10])) {
                    $inicio_prep = mysqli_real_escape_string($conn,$Row[10]);
                }

                $salida_merc = "";
                if(isset($Row[11])) {
                    $salida_merc = mysqli_real_escape_string($conn,$Row[11]);
                }

                $fecha_entrega = "";
                if(isset($Row[12])) {
                    $fecha_entrega = mysqli_real_escape_string($conn,$Row[12]);
                }

                $fecha_despacho = "";
                if(isset($Row[13])) {
                    $fecha_despacho = mysqli_real_escape_string($conn,$Row[13]);
                }

                $referencia = "";
                if(isset($Row[14])) {
                    $referencia = mysqli_real_escape_string($conn,$Row[14]);
                }

                $codigo_operatoria = "";
                if(isset($Row[15])) {
                    $codigo_operatoria = mysqli_real_escape_string($conn,$Row[15]);
                }

                $centro = "";
                if(isset($Row[16])) {
                    $centro = mysqli_real_escape_string($conn,$Row[16]);
                }

                $almacen = "";
                if(isset($Row[17])) {
                    $almacen = mysqli_real_escape_string($conn,$Row[17]);
                }

                $linea_text = "";
                if(isset($Row[18])) {
                    $linea_text = mysqli_real_escape_string($conn,$Row[18]);
                }
                
                if (!empty($contratista) || !empty($nombre_contratista))
                {
                    $query = "INSERT INTO ingresomaterial(usuario, fecha, proveedor, num_pedido, operatoria, seriado, sap, material, cantidad, deposito, obs) VALUES('$quien','$fecha','$proveedor','$nro_pedido','$codigo_operatoria', '','$num_material','$descripcion_material','$cantidad','$deposito','$obs')";
                    $resultados = mysqli_query($conn, $query);
                
                    if (! empty($resultados)) {
                        $msgColor = "success";
                        $msg = "El excel del pedido " .$nro_pedido ." fue cargado correctamente.";
                        $_SESSION['card'] = 1;
                        $_SESSION['message'] = $msg;
                        $_SESSION['message_type'] = $msgColor;
                        header('Location: ../Basico/ingresomaterial.php');
                    } else {
                        $msgColor = "danger";
                        $msg = "Hubo un problema al cargar los datos";
                        $_SESSION['card'] = 1;
                        $_SESSION['message'] = $msg;
                        $_SESSION['message_type'] = $msgColor;
                        header('Location: ../Basico/ingresomaterial.php');
                    }
                }
            }
        
        }
    }
    else
    { 
        $msgColor = "danger";
        $msg = "Fallo el envio del archivo. Por favor vuelva a intentarlo";
        $_SESSION['card'] = 1;
        $_SESSION['message'] = $msg;
        $_SESSION['message_type'] = $msgColor;
        header('Location: ../Basico/ingresomaterial.php');
    }

    ?>
    <script src="../Basico/excel/assets/jquery-1.12.4-jquery.min.js"></script>
    <?php

    $_SESSION['card'] = 1;
    $_SESSION['message'] = $msg;
    $_SESSION['message_type'] = $msgColor;
    header('Location: ../Basico/ingresomaterial.php');
}

if(isset($_POST['serie']))
{
    /* MOVIMIENTO INDIVIDUAL */
        $token_movi = uniqid();
        $quien_notas = $_SESSION['nombre'] . ' ' .$_SESSION['apellido'];
        $tipo_us = $_SESSION['tipo_us'];
        $zona_us = $_SESSION['zona'];
        $hoy_movi = date("Y-m-j");
        mysqli_query($conn, "INSERT INTO movimiento_interno(token, quien, movimiento, pag, inicio, tipo, zona) VALUES ('$token_movi', '$quien_notas', 'Guardado', 'Ingreso de material seriado excel', '$hoy_movi', '$tipo_us', '$zona_us')");
    /* MOVIMIENTO INDIVIDUAL */

    $quien = $nombre ." " .$apellido;

    $fecha = $_POST['fecha'];
    $proveedor = $_POST['proveedor'];
    $deposito = $_POST['deposito'];
    $obs = $_POST['obs'];
		$pedido = $_POST['pedido'];

    
    $allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
  
  if(in_array($_FILES["file"]["type"],$allowedFileType))
    {
			$targetPath = '../Basico/excel/subidas/'.$_FILES['file']['name'];
			move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);
			
			$Reader = new SpreadsheetReader($targetPath);
			
			$sheetCount = count($Reader->sheets());
			for($i=0;$i<$sheetCount;$i++)
			{
					
				$Reader->ChangeSheet($i);
				
				foreach ($Reader as $Row)
				{
					$sap = "";
					if(isset($Row[0])) {
							$sap = mysqli_real_escape_string($conn,$Row[0]);
					}

					$num_material = "";
					if(isset($Row[1])) {
							$num_material = mysqli_real_escape_string($conn,$Row[1]);
					}

					$descripcion_material = "";
					if(isset($Row[2])) {
							$descripcion_material = mysqli_real_escape_string($conn,$Row[2]);
					}
					
					if (!empty($sap) || !empty($num_material) || !empty($descripcion_material))
					{
                        $a = mysqli_query($conn, "SELECT * FROM ingresomaterial WHERE seriado = '$num_material' AND cantidad = 1 ");
                        if (mysqli_num_rows($a) >= 1)
                        {
                            $titulo_toast = "Error";
                            $msj_toast = "El equipo " .$num_material ." ya se encuentra ingresado";
                            $color_toast = "danger";
                            $_SESSION['card'] = 1;
                            $_SESSION['titulo_toast'] = $titulo_toast;
                            $_SESSION['mensaje_toast'] = $msj_toast;
                            $_SESSION['color_toast'] = $color_toast;
                            header('Location: ../Basico/ingresoseriado.php');
                        }
                        else
                        {
                            $resultados = mysqli_query($conn, "INSERT INTO ingresomaterial(usuario, fecha, proveedor, num_pedido, operatoria, seriado, sap, material, cantidad, deposito, obs) VALUES('$quien','$fecha','$proveedor','$pedido','IPTV','$num_material', '$sap','$descripcion_material','1','$deposito','$obs')");
                        
                            if ($resultados)
                            {
                                $titulo_toast = "Guardado";
                                $msj_toast = "El excel fue cargado correctamente.";
                                $color_toast = "success";
                                $_SESSION['card'] = 1;
                                $_SESSION['titulo_toast'] = $titulo_toast;
                                $_SESSION['mensaje_toast'] = $msj_toast;
                                $_SESSION['color_toast'] = $color_toast;
                                header('Location: ../Basico/ingresoseriado.php');
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
                                header('Location: ../Basico/ingresoseriado.php');
                            }
                        }
					}
					else
					{
						$titulo_toast = "Error";
						$msj_toast = "Algunos datos estan incompletos";
						$color_toast = "danger";
						$_SESSION['card'] = 1;
						$_SESSION['titulo_toast'] = $titulo_toast;
						$_SESSION['mensaje_toast'] = $msj_toast;
						$_SESSION['color_toast'] = $color_toast;
						header('Location: ../Basico/ingresoseriado.php');
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
			header('Location: ../Basico/ingresoseriado.php');
    }

    ?>
    <script src="../Basico/excel/assets/jquery-1.12.4-jquery.min.js"></script>
    <?php

		$_SESSION['card'] = 1;
		$_SESSION['titulo_toast'] = $titulo_toast;
		$_SESSION['mensaje_toast'] = $msj_toast;
		$_SESSION['color_toast'] = $color_toast;
    header('Location: ../Basico/ingresoseriado.php');
}
?>