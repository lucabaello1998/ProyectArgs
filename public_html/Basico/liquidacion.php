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
	if($usu != 1)
	{
		header("location: ../index.php");
	}
?>
<?php include('../includes/header.php'); ?>

<div class="container-fluid p-4">
  <div class="row p-2">
    <div class="container-fluid rounded bg-white shadow p-0">
      <div class="row justify-content-center p-1 m-0">
        <div class="col-auto">
					<form action="../Basico/pdf.php" method="POST">
						<p class="h4 mb-4 text-center">Liquidacion</p>

						<div class="form-row">
							<div class="form-group col-6">
								<label for="exampleFormControlSelect1">Tecnico</label >
								<select type="text" name="tecnico" class="form-control">                
									<option selected="0">Tecnicos...</option>                
									<?php
										$ejecutar=mysqli_query($conn,"SELECT * FROM tecnicos WHERE activo='SI' AND tipo='Tecnico' ORDER BY tecnico asc");
									?>
									<?php foreach ($ejecutar as $opciones): ?>   
										<option value="<?php echo $opciones['tecnico'] ?>"><?php echo $opciones['tecnico'] ?></option>  
									<?php endforeach ?>
					
									<?php
										$ejecutar=mysqli_query($conn,"SELECT * FROM tecnicos WHERE tipo='Tecnico' AND activo ='NO' ORDER BY tecnico asc");
									?>
									<?php foreach ($ejecutar as $opciones): ?>   
										<option class="text-danger" value="<?php echo $opciones['tecnico'] ?>"><?php echo $opciones['tecnico'] ?></option>                    
									<?php endforeach ?>
								</select>
							</div>
							<div class="form-group col-6">
								<label for="exampleFormControlSelect1">Mes</label >
								<select type="text" name="mes" class="form-control">
									<option selected>Mes...</option>
									<option value="2021-10">Octubre 21</option>
									<option value="2021-11">Noviembre 21</option>
									<option value="2021-12">Diciembre 21</option>
									<option value="2022-01">Enero 22</option>
									<option value="2022-02">Febrero 22</option>
									<option value="2022-03">Marzo 22</option>
									<option value="2022-04">Abril 22</option>
									<option value="2022-05">Mayo 22</option>
									<option value="2022-06">Junio 22</option>
									<option value="2022-07">Julio 22</option>
									<option value="2022-08">Agosto 22</option>
									<option value="2022-09">Septiembre 22</option>
									<option value="2022-10">Octubre 22</option>
									<option value="2022-11">Noviembre 22</option>
									<option value="2022-12">Diciembre 22</option>
								</select>							
							</div>
							<input type="submit" value="Generar PDF" name="crear" class="btn btn-success btn-block">
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>


<!-- PIE DE PAGINA -->

<!-- Bootstrap -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>