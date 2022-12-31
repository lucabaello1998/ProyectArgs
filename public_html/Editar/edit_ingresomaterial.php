<?php
include("../db.php");
session_start();
if(!$_SESSION['tipo_us'])
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

$quien = $nombre ." " .$apellido;
$fecha = '';
$proveedor = '';
$deposito = '';
$pedido = '';
$sap = '';
$material = '';
$cantidad = '';
$obs = '';

if  (isset($_GET['id'])) {
  $id = $_GET['id'];
  $query = "SELECT * FROM ingresomaterial WHERE id=$id";
  $result = mysqli_query($conn, $query);
  if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_array($result);
    $fecha = $row['fecha'];
		$proveedor = $row['proveedor'];
		$deposito = $row['deposito'];
		$pedido = $row['num_pedido'];
		$sap = $row['sap'];
		$material = $row['material'];
		$cantidad = $row['cantidad'];
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
		'Ingreso material',
		'$hoy_movi',
		'$tipo_us',
		'$zona_us')");
	/* MOVIMIENTO INDIVIDUAL */

	$id = $_GET['id'];
	$fecha = $_POST['fecha'];
	$proveedor = $_POST['proveedor'];
	$deposito = $_POST['deposito'];
	$pedido = $_POST['pedido'];
	$sap = $_POST['sap'];
	$material = $_POST['material'];
	$cantidad = $_POST['cantidad'];
	$obs = $_POST['obs'];

  $query = "UPDATE ingresomaterial set usuario = '$quien', fecha = '$fecha', proveedor = '$proveedor', deposito = '$deposito', num_pedido = '$pedido', sap = '$sap', material = '$material', cantidad = '$cantidad', obs = '$obs' WHERE id=$id";
  mysqli_query($conn, $query);
  $_SESSION['card'] = 1;
  $_SESSION['message'] = 'Material actualizado';
  $_SESSION['message_type'] = 'warning';
  header('Location: ../Basico/ingresomaterial.php');
}
?>
<?php include('../includes/header.php'); ?>

<div class="container-fluid pr-4 pl-4 pt-0 pb-0">
  <div class="row pr-2 pl-2 pt-0 pb-0">
    <div class="container-fluid rounded bg-white shadow p-0">

      <div class="row justify-content-center p-1 m-0">
        <div class="col-auto">
					<div class="card card-body">
						<form action="edit_ingresomaterial.php?id=<?php echo $_GET['id']; ?>" method="POST">
							<p class="h4 mb-4 text-center">Actualizar material</p>

								<div class="form-row">
										<div class="form-group col">
											<label for="ingresoMaterial">Fecha</label >
											<input type="date" name="fecha" class="form-control" value="<?php echo $fecha; ?>" placeholder="Actualice la fecha" autofocus>
										</div>
										<div class="form-group col">
											<label for="ingresoMaterial">Proveedor</label>
											<input type="text" maxlength="255" name="proveedor" class="form-control" value="<?php echo $proveedor; ?>" placeholder="Actualice el Proveedor" autofocus>
										</div>
											<div class="form-group col-sm">
											<label for="exampleFormControlSelect1">Deposito</label >
												<select type="text" name="deposito" class="form-control">
													<option selected><?php echo $deposito; ?></option>
													<option value="Lomas de Zamora">Lomas de Zamora</option>
									<option value="Jose Leon Suarez">Jose Leon Suarez</option>
									<option value="La Tablada">La Tablada</option>
												</select>
									</div>
									<div class="form-group col">
										<label for="ingresoMaterial">Numero de pedido</label >
										<input type="number" name="pedido" maxlength="11" class="form-control" value="<?php echo $pedido; ?>" placeholder="Actualice el numero de pedido" autofocus>
									</div>
								</div>

								<div class="form-row">      
									<div class="form-group col">
										<label for="exampleFormControlSelect1">Observaciones</label >
										<textarea type="text" maxlength="255" name="obs" class="form-control" autofocus ><?php echo $obs; ?></textarea>
									</div>         
								</div>

								<div class="form-row">      
									<div class="form-group col">
											<label for="ingresoMaterial">SAP</label>
											<input type="text" maxlength="255" name="sap" class="form-control" value="<?php echo $sap; ?>" placeholder="Actualice el sap" autofocus>
										</div>
										<div class="form-group col">
											<label for="ingresoMaterial">Material</label>
											<input type="text" maxlength="255" name="material" class="form-control" value="<?php echo $material; ?>" placeholder="Actualice el material" autofocus>
										</div>
										<div class="form-group col">
											<label for="ingresoMaterial">Cantidad</label>
											<input type="text" maxlength="255" name="cantidad" class="form-control" value="<?php echo $cantidad; ?>" placeholder="Actualice la cantidad" autofocus>
										</div>   
								</div>

								<input type="submit" name="update" class="btn btn-success btn-block" value="Actualizar material">

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
<!-- Bootstrap -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>
