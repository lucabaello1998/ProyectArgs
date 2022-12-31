<?php include("../../db.php"); ?>
<?php include('../includesatc/headeratc.php'); ?>
<!-----Visor---->

<!-----Visor---->
<?php 

$mes = "20" .date ('y-m', strtotime('-0 month'));
if(isset($_POST['meses']))
{
  $mes1 = $_POST['mes'];
  $mes = "20" .date ('y-m', strtotime($mes1));
}

?>

<?php 
/////TOTAL KM//////
$consulta = "SELECT SUM(km) as 'kmtotal' FROM atckilometros WHERE fecha LIKE '%$mes%' "; 
$respuesta = mysqli_query($conn, $consulta);
while($row = mysqli_fetch_array($respuesta)){
$kmtot = $row['kmtotal']; 
$kmtotal = bcdiv($kmtot, '1', '2');}
/////TOTAL KM//////
/////TOTAL KM GPON//////          //////////////utilizar un $i, un buble////////////////
$consultag = "SELECT * FROM tecnicosatc WHERE operativo = 'SI' AND tarea LIKE '%ATC Gpon%' "; 
$respuestag = mysqli_query($conn, $consultag);
while($row = mysqli_fetch_array($respuestag)){
$tecnicosatcg = $row['nombre'] ." " .$row['apellido'] ;
echo $tecnicosatcg; }

$consultag = "SELECT SUM(km) as 'kmtotalgpon' FROM atckilometros WHERE fecha LIKE '%$mes%' AND nombre LIKE '%$tecnicosatcg%' "; 
$respuestag = mysqli_query($conn, $consultag);
while($row = mysqli_fetch_array($respuestag)){
$kmtotgpon = $row['kmtotalgpon'];
$kmtotalgpon = bcdiv($kmtotgpon, '1', '2'); }

 

/////TOTAL KM GPON//////
/////TOTAL KM LINEAL//////
$consultal = "SELECT * FROM tecnicosatc WHERE operativo = 'SI' AND tarea LIKE '%Relevamiento lineal%' "; 
$respuestal = mysqli_query($conn, $consultal);
while($row = mysqli_fetch_array($respuestal)){
$tecnicosatclineal = $row['nombre'] ." " .$row['apellido'] ; 

$consultal = "SELECT SUM(km) as 'kmtotallineal' FROM atckilometros WHERE fecha LIKE '%$mes%' AND nombre LIKE '%$tecnicosatclineal%' "; 
$respuestal = mysqli_query($conn, $consultal);
while($row = mysqli_fetch_array($respuestal)){
$kmtotlineal = $row['kmtotallineal'];
$kmtotallineal = bcdiv($kmtotlineal, '1', '2'); }
}
/////TOTAL KM LINEAL//////


/////ULTIMA FECHA//////
$ultimafecha = "SELECT * FROM atckilometros WHERE fecha LIKE '%$mes%' order by fecha desc LIMIT 1 "; 
$ultimafecha_resul = mysqli_query($conn, $ultimafecha);
while($row = mysqli_fetch_assoc($ultimafecha_resul)) { 
$ultimafecha_veh = $row['fecha'];} 

$fechacar_veh  = $ultimafecha_veh;             
$solofecha_veh = explode("-", $fechacar_veh); // explota el string en " " espacios
$ultimafecha_total = $solofecha_veh[2] ."-" .$solofecha_veh[1] ;  // asigna un valor por el resultado del explotado
/////ULTIMA FECHA//////

/////DIAS TRABAJADOS//////
$consulta_dias = "SELECT COUNT(distinct fecha) as 'diastrabajados' FROM atckilometros WHERE fecha like '%$mes%'"; 
$respuesta_dias = mysqli_query($conn, $consulta_dias);
while($row = mysqli_fetch_assoc($respuesta_dias)) { 
$diastrabajados = $row['diastrabajados'];}
/////DIAS TRABAJADOS//////

/////RECURSOS//////
$recursos = "SELECT COUNT(distinct nombre) as 'recursos_mes' FROM atckilometros WHERE fecha like '%$mes%'"; 
$respuesta_recursos = mysqli_query($conn, $recursos);
while($row = mysqli_fetch_assoc($respuesta_recursos)) { 
$recursos_mes = $row['recursos_mes'];}
/////RECURSOS//////
?>


<p class="h2 mb-6 text-center">Kilometros en <?php switch ($mes)
{
case '2021-12': echo "Diciembre";
break;
case '2021-11': echo "Noviembre";
break;
case '2021-10': echo "Octubre";
break;
case '2021-09': echo "Septiembre";
break;
case '2021-08': echo "Agosto";
break;
case '2021-07': echo "Julio";
break;
case '2021-06': echo "Junio";
break;
case '2021-05': echo "Mayo";
break;
case '2021-04': echo "Abril";
break;
case '2021-03': echo "Marzo";
break;
case '2021-02': echo "Febrero";
break;
case '2021-01': echo "Enero";
break;
} ?></p>
<br>

<div class="container-fluid p-4">  <!---- RESUMEN--->
	<div class="row p-2 border border">	
		<div class="col-12 col-md-3 col-sm-6 align-items-center"> <!---NO REALIZADAS--->
			<div class="card bg-success">
				<div class=" card-header h4 text-light font-weight-bold text-center">
			    Kilometros totales
			  </div>
			  <br>
				<div class="row">			
					<div class="col">
						<p class="h2 card-text text-light text-center font-weight-bold p-2"><?php echo $kmtotal; ?></p>							
					</div>							
				</div>
				<br>
			</div>
			<div class="row p-2"> <!----BOTONES DE INFO------->
				<div class="col-sm-6 col-6 col-md-12 col-xl-6">
					<p>				
						<a class="btn btn-success text-light">Lineal <span class="badge badge-light"><?php echo $kmtotallineal; ?></span></a>
					</p>
				</div>
				<div class="col-sm-6 col-6 col-md-12 col-xl-6 align-items-center">
					<p>				
						<a class="btn btn-success text-light">Gpon <span class="badge badge-light"><?php echo $kmtotalgpon; ?></span></a>
					</p>
				</div> 
			</div>
		</div>
		<div class="col-12 col-md-3 col-sm-6 align-items-center"> <!---NO REALIZADAS--->
			<div class="card bg-success">
				<div class=" card-header h4 text-light font-weight-bold text-center">
			    Ultima zona
			  </div>
			  <br>
				<div class="row">			
					<div class="col">
						<p class="h2 card-text text-light text-center font-weight-bold p-2">454545</p>							
					</div>							
				</div>
				<br>
			</div>
			<div class="row p-2"> <!----BOTONES DE INFO------->
				<div class="col-sm-6 col-6 col-md-12 col-xl-6">
					<p>				
						<a class="btn btn-success text-light">Kilometros <span class="badge badge-light">565656</span></a>
					</p>
				</div>
				<div class="col-sm-6 col-6 col-md-12 col-xl-6 align-items-center">
					<p>				
						<a class="btn btn-success text-light">Fecha <span class="badge badge-light">6767676</span></a>
					</p>
				</div> 
			</div>
		</div>
		<div class="col-12 col-md-3 col-sm-6 align-items-center"> <!---NO REALIZADAS--->
			<div class="card bg-success">
				<div class=" card-header h4 text-light font-weight-bold text-center">
			    Meyor cantidad
			  </div>
			  <br>
				<div class="row">			
					<div class="col">
						<p class="h2 card-text text-light text-center font-weight-bold p-2">44444</p>							
					</div>							
				</div>
				<br>
			</div>
			<div class="row p-2"> <!----BOTONES DE INFO------->
				<div class="col-sm-6 col-6 col-md-12 col-xl-6">
					<p>				
						<a class="btn btn-success text-light">Kilometros <span class="badge badge-light">55555</span></a>
					</p>
				</div>
				<div class="col-sm-6 col-6 col-md-12 col-xl-6 align-items-center">
					<p>				
						<a class="btn btn-success text-light">Fecha <span class="badge badge-light">66666</span></a>
					</p>
				</div> 
			</div>
		</div>
		<div class="col-12 col-md-3 col-sm-6 align-items-center"> <!---NO REALIZADAS--->
			<div class="card bg-dark">
				<div class=" card-header h4 text-light font-weight-bold text-center">
			    Otros datos
			  </div>
			  <br>
				<div class="row">			
					<div class="col">
						<p class="h2 card-text text-light text-center font-weight-bold p-2"><?php echo $recursos_mes ." recursos"; ?></p>							
					</div>							
				</div>
				<br>
			</div>
			<div class="row p-2"> <!----BOTONES DE INFO------->
				<div class="col-sm-6 col-6 col-md-12 col-xl-6">
					<p>				
						<a class="btn btn-dark text-light">Dias trabajados <span class="badge badge-light"><?php echo $diastrabajados; ?></span></a>
					</p>
				</div>
				<div class="col-sm-6 col-6 col-md-12 col-xl-6 align-items-center">
					<p>				
						<a class="btn btn-dark text-light">Ultima fecha <span class="badge badge-light"><?php echo $ultimafecha_total; ?></span></a>
					</p>
				</div> 
			</div>
		</div>
	</div>
</div>


<div class="container">
  <div class="row">
    <div class="col">
      <div class="card card-body">
        <form action="../Basico/kmanalisis.php" method="POST">
          <p class="h4 mb-4 text-center">Mes</p>
          <div class="form-row align-items-end">            
            <div class="col">             
              <select type="text" name="mes" class="form-control">
                <option selected>Mes...</option>
                <option value="-0 month">Mes actual</option>
                <option value="-1 month">Hace un mes</option>
                <option value="-2 month">Hace dos meses</option>
                <option value="-3 month">Hace tres meses</option>
              </select>
            </div>            
            <div class="col">
              <input type="submit" name="meses" class="btn btn-success btn-block" value="Cargar mes">
            </div>            
          </div>
        </form>
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