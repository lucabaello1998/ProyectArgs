<?php include("../db.php");

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

if(isset($_POST['enviar']))
{
    /* MOVIMIENTO INDIVIDUAL */
        $token_movi = uniqid();
        $quien_notas = $_SESSION['nombre'] . ' ' .$_SESSION['apellido'];
        $tipo_us = $_SESSION['tipo_us'];
    $zona_us = $_SESSION['zona'];
        $hoy_movi = date("Y-m-j");
        mysqli_query($conn, "INSERT INTO movimiento_interno(token, quien, movimiento, pag, inicio, tipo, zona) VALUES ('$token_movi', '$quien_notas', 'Guardado', 'Penalizaciones', '$hoy_movi', '$tipo_us', '$zona_us')");
    /* MOVIMIENTO INDIVIDUAL */
    $quien = $nombre ." " .$apellido;

    $pedido = $_POST['pedido'];
    $sap = $_POST['sap'];
    $seriado = $_POST['seriado'];
    $cantidad = '1';
    $obs_uno = $_POST['obs'];


    $consulta_pedido="SELECT COUNT(num_pedido) AS 'totales' FROM ingresomaterial WHERE num_pedido like '%$pedido%'";
    $resuktado_pedido=mysqli_query($conn,$consulta_pedido);
    while($row = mysqli_fetch_assoc($resuktado_pedido))
    {
        if($row['totales'] >= 1)
        {
            $consaulta_sap="SELECT COUNT(sap) AS 'total' FROM basemateriales WHERE sap = '$sap' LIMIT 1";
            $resultado_sap=mysqli_query($conn,$consaulta_sap);
            while($row = mysqli_fetch_assoc($resultado_sap))
            {
                if($row['total'] == 1)
                {
                    
                    $fecha = '2000-01-01';
                    $num_pedido = '0';
                    $proveedor = '-';
                    $operatoria = 'IPTV';
                    $deposito = 'Deposito';
                    $obs_dos = '-';
                    $query = "SELECT * FROM ingresomaterial WHERE num_pedido like '%$pedido%' LIMIT 1";
                    $result_tasks = mysqli_query($conn, $query);    
                    while($row = mysqli_fetch_assoc($result_tasks))
                    {           
                        $fecha = $row['fecha'];
                        $num_pedido = $row['num_pedido'];
                        $proveedor = $row['proveedor'];
                        $operatoria = $row['operatoria'];
                        $deposito = $row['deposito'];
                        $obs_dos = $row['obs'] .'-' .$obs_uno;    
                    }


                    $material_nombre = "SELECT * FROM basemateriales WHERE sap like '%$sap%' LIMIT 1";
                    $base = mysqli_query($conn, $material_nombre);    
                    while($row = mysqli_fetch_assoc($base))
                    {           
                        $material = $row['material'];  
                    }

                    while(true) {

                        //// RECUPERAR LOS VALORES DE LOS ARREGLOS ////////
                        $item1 = $quien;
                        $item2 = $fecha;
                        $item3 = $proveedor;
                        $item4 = $num_pedido;
                        $item5 = $operatoria;
                        $item6 = current($seriado);
                        $item7 = $sap;
                        $item8 = $material;
                        $item9 = $cantidad;
                        $item10 = $deposito;
                        $item11 = $obs_dos;
                        
                        ////// ASIGNARLOS A VARIABLES ///////////////////
                        $quienquien=$item1;
                        $fechafecha=$item2;
                        $proveedorproveedor=$item3;
                        $num_pedido_num_pedido=$item4;
                        $operatoriaoperatoria=$item5;
                        $seriadoseriado=(( $item6 !== false) ? $item6 : ", &nbsp;");
                        $sapsap=$item7;
                        $materialmaterial=$item8;
                        $cantidadcantidad=$item9;
                        $depositodeposito=$item10;
                        $obsobs=$item11;

                        //// CONCATENAR LOS VALORES EN ORDEN PARA SU FUTURA INSERCIÓN ////////
                        $valores='("'.$quienquien.'","'.$fechafecha.'","'.$proveedorproveedor.'","'.$num_pedido_num_pedido.'","'.$operatoriaoperatoria.'","'.$seriadoseriado.'","'.$sapsap.'","'.$materialmaterial.'","'.$cantidadcantidad.'","'.$depositodeposito.'","'.$obsobs.'"),';

                        //////// YA QUE TERMINA CON COMA CADA FILA, SE RESTA CON LA FUNCIÓN SUBSTR EN LA ULTIMA FILA /////////////////////
                        $valoresQ= substr($valores, 0, -1);
                        

                        if($seriadoseriado !== ''){
                            ///////// QUERY DE INSERCIÓN ////////////////////////////
                            $entrada = "INSERT INTO  ingresomaterial(usuario, fecha, proveedor, num_pedido, operatoria, seriado, sap, material, cantidad, deposito, obs) VALUES $valoresQ";
                            $result = mysqli_query($conn, $entrada);
                            if(!$result)
                            {
                                $msj = "Error en el servidor.";
                                $color = "danger";
                            }
                            else
                            {
                                $msj = "Los equipos del pedido " .$pedido ." fueron guardados.";
                                $color = "success";
                            }
                        }
                        
                        
                        // Up! Next Value
                        $item6 = next( $seriado );        
                        // Check terminator
                        if($item6 === false) break;
                    }  
                }
                else
                {
                    $msj = "El codigo sap no se encuentra en la base de datos.";
                    $color = "danger";
                }
            }
        }
        else
        {
            $msj = "El numero de pedido no se encuentra cargado.";
            $color = "danger";
        }
    }


    
    

$_SESSION['card'] = 1;
$_SESSION['message'] = $msj;
$_SESSION['message_type'] = $color;
header('Location: ../Basico/ingresomaterial.php');
}
?>