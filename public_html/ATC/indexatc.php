<?php include("../db.php"); ?>
<?php include('includesatc/headeratc.php'); ?>
<?php  header ('Content-type: text/html; charset=utf-8');  ?>


<div class="container-fluid p-4">  <!---- RESUMEN--->
	<div class="row">		
		<div class="col-12 col-md-3 col-sm-6 align-items-center"> <!---ALTAS--->
			<div class="card bg-info">					
				<div class="row">			
					<div class="col ">
						<p class="h2 card-text text-light text-left font-weight-bold p-2"><?php echo $todocum ?></p>				
						<p class="h4 text-light text-left ml-4">Partido</p>	
					</div>
					<div class="col">
						<br>						
						<p class="h1 text-light text-center"><i class="fas fa-angle-double-up"></i></i></p>	
					</div>											
				</div>				
			</div>
		</div>
		<div class="col-12 col-md-3 col-sm-6 align-items-center"><!---BAJAS--->
			<div class="card bg-danger">					
				<div class="row">			
					<div class="col ">
						<p class="h2 card-text text-light text-left font-weight-bold p-2"><?php echo $todobaja ?></p>
						<p class="h4 text-light text-left ml-4">Localidad</p>	
					</div>
					<div class="col">
						<br>						
						<p class="h1 text-light text-center"><i class="fas fa-angle-double-down"></i></i></p>	
					</div>							
				</div>
			</div>
		</div>
		<div class="col-12 col-md-3 col-sm-6 align-items-center"> <!---GARANTIAS--->
			<div class="card bg-warning">					
				<div class="row">			
					<div class="col ">
						<p class="h2 card-text text-light text-left font-weight-bold p-2"><?php echo $totalgar ?></p>					
						<p class="h4 text-light text-left ml-4">Reportes</p>	
					</div>
					<div class="col">
						<br>						
						<p class="h1 text-light text-center"><i class="fas fa-sync-alt"></i></i></i></p>	
					</div>							
				</div>
			</div>
		</div>
		<div class="col-12 col-md-3 col-sm-6 align-items-center"> <!---TOTAL--->
			<div class="card bg-dark">					
				<div class="row">			
					<div class="col ">
						<p class="h2 card-text text-light text-left font-weight-bold p-2"><?php echo $todototal ?></p>
						<p class="h4 text-light text-left ml-4">%</p>	
					</div>
					<div class="col">
						<br>						
						<p class="h1 text-light text-center"><i class="fas fa-layer-group"></i></i></i></i></p>	
					</div>							
				</div>
			</div>
		</div>
	</div>
</div>

<!-- MESSAGES -->
      <?php session_start();      
       if ($_SESSION['card'] == 1) { ?>
      <div class="alert alert-<?= $_SESSION['message_type']?> alert-dismissible fade show" role="alert">
        <?= $_SESSION['message']?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?php $_SESSION['card'] = 0; } ?>
<!-- MESSAGES -->

<style>
#mapacol
{ 
  max-width: 100%;
  height: 75vh;
  padding: 0px;
}

#map
{ 
  max-width: 100%;
  height: 75vh;
  padding: 0px;
}

</style>

<div class="container-fluid">
	<div class="row">
		<div class="col-sm-3 col-xl-2 p-1">
			<ul class="nav nav-tabs" id="myTab" role="tablist">
				<li class="nav-item" role="presentation">
			    <a class="nav-link active" id="reportes-tab" data-toggle="tab" href="#reportes" role="tab" aria-controls="reportes" aria-selected="true"><i class="fas fa-map-marked-alt"></i></a>
			  </li>
			  <li class="nav-item" role="presentation">
			    <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="false"><i class="fas fa-filter"></i></a>
			  </li>
			  <li class="nav-item" role="presentation">
			    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false"><i class="fas fa-info"></i></a>
			  </li>
			  <li class="nav-item" role="presentation">
			    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false"><i class="fas fa-pencil-alt"></i></a>
			  </li>
			  <li class="nav-item" role="presentation">
			    <a class="nav-link" id="kilometros-tab" data-toggle="tab" href="#kilometros" role="tab" aria-controls="kilometros" aria-selected="false"><i class="fas fa-route"></i></a>
			  </li>
			</ul>
			<div class="tab-content" id="myTabContent">
				<div class="tab-pane fade show active" id="reportes" role="tabpanel" aria-labelledby="reportes-tab">
			  	
		        <form action="../../ATC/indexatc.php" method="POST">
		          <p class="h4 mb-4 text-center">Reportes</p>
		          <div class="form-row">
		            <div class="form-group col">
		              <label>Rango de fecha</label >
		              <div class="input-group">
		                <input type="date" name="fecha_uno" class="input-sm form-control">
		                  <span class="input-group-addon">-</span>
		                <input type="date" name="fecha_dos" class="input-sm form-control">
		              </div>
		              <br>
                	<div class="form-row">
                		<div class="form-group col">
			              <div class="form-check">
										  <input class="form-check-input" type="radio" name="reporte" id="reporte1" value="gpon" checked>
										  <label class="form-check-label">
										    Gpon
										  </label>
										</div>
									</div>
									<div class="form-group col">
										<div class="form-check">
										  <input class="form-check-input" type="radio" name="reporte" id="reporte2" value="lineal">
										  <label class="form-check-label">
										    Lineal
										  </label>
										</div>
									</div>
                	</div>
		            </div>
		          </div> 
		          <input type="submit" name="save_fechas" class="btn btn-success btn-block" value="Cargar reportes">
		        </form>
		      
			  </div>
			  <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
			  	<div class="col-auto pt-2" id="capaslargo"><style>#capaslargo {max-height: 75vh;;overflow-y:auto;}</style>
			  		<div class="row" id="trazaslargo"><style>#trazaslargo {max-height: 32vh;;overflow-y:auto;}</style>
          		<div id="new-parent"></div>
            </div>
              	<br>
            <div class="row" id="reporteslargo"><style>#reporteslargo {max-height: 32vh;;overflow-y:auto;}</style>
            			<div id="nuevo_objeto"></div>
          	</div>
          </div>
		  	</div>
			  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
			  	<label class="p-3" id="informacion">Informacion</label>
			  </div>
			  <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
			  	<label class="p-3" id="editar">Edicion</label>
			  </div>
			  <div class="tab-pane fade" id="kilometros" role="tabpanel" aria-labelledby="kilometros-tab">
			  	<div class="col px-1 py-1" id="tablaacro"><style>#tablaacro {max-height: 75vh;;overflow-y:auto;}</style>

			        <br>
			        <form action="../../ATC/Guardar/save_kilometrosindividual.php" method="POST" class="col">
		        	<!-- <div class="card card-body"> -->
			        <p class="h5 mb-4 text-center">Carga de kilometros</p>			        
	            <div class="form-row justify-content-center">
	              <div class="form-group col text-center">
                  <input type="date" name="fecha" required>
                </div>
	            </div>
			        <div class="form-group row justify-content-center">
			        	<div class="form-group col">
									
									<div class="form-group row justify-content-center my-0">
		                <div class="form-group col-6 px-1 py-1">
										  <select type="text" name="nombre" class="form-control">                
			                  <option selected disabled>Relevador...</option>                
			                  <?php include "../../db.php";
			                  $consulta="SELECT * FROM tecnicosatc WHERE operativo = 'SI' ORDER BY nombre asc";
			                  $ejecutar=mysqli_query($conn,$consulta) or die (mysqli_error($conn));
			                  ?>
			                  <?php foreach ($ejecutar as $opcioness): ?>   
			                    <option value="<?php echo $opcioness['nombre']  ." " .$opcioness['apellido'] ?>"><?php echo $opcioness['nombre']  ." " .$opcioness['apellido'] ?></option>                                      
			                  <?php endforeach ?>
			                </select>
		                </div>
		                	<div class="form-group col-6 px-1 py-1">                						    				   
										    <select type="text" name="dia" class="form-control" required>
			                    <option selected disabled>Tipo de dia</option>
													<option>Dia normal</option>
                          <option>Sabado</option>	
										      <option>Feriado</option>
			                    <option>Ausente</option>
			                    <option>Medio dia</option>					      					      
										    </select>
									    </div>
									  </div>
								    
                    <div class="form-group row justify-content-center my-0">
                      <div class="form-group col-6 px-1 py-1">
                        <label class="col-form-label-sm">primer reporte</label>
                        <input type="text" class="form-control clockpicker" readonly="" data-autoclose="true" name="hora">
                      </div>
                      <div class="form-group col-6 px-1 py-1">
                        <label class="col-form-label-sm">ultimo reporte</label>
                        <input type="text" class="form-control clockpicker" readonly="" data-autoclose="true" name="fin">
                      </div>
                    </div>
                    <div class="form-group row justify-content-center my-0">
                      <div class="form-group col-6 px-1 py-1">
                        <label class="col-form-label-sm">Km</label>
                        <input type="number" name="km" step="0.01" class="form-control" placeholder="Km del dia">
                      </div>
                    
                      <div class="form-group col px-1 py-1">
                        <label class="col-form-label-sm">Partido</label>
                          <select type="text" name="partido" class="form-control form-control">
                            <option selected disabled>Partido...</option>
                            <option value="Tres de Febrero" class="alert-warning">Tres de Febrero</option>
                            <option value="La Matanza" class="alert-success">La Matanza</option>
                            <option value="Moreno" class="alert-success">Moreno</option>
                            <option value="Ituzaingo" class="alert-success">Ituzaingo</option>
                            <option value="Hurlingham" class="alert-success">Hurlingham</option>
                            <option value="Merlo" class="alert-success">Merlo</option>
                            <option value="Moron" class="alert-success">Moron</option>
                            <option value="San Miguel" class="alert-danger">San Miguel</option>
                            <option value="Jose C Paz" class="alert-danger">Jose C Paz</option>
                            <option value="Escobar" class="alert-danger">Escobar</option>
                            <option value="Pilar" class="alert-danger">Pilar</option>
                            <option value="San Isidro" class="alert-danger">San Isidro</option>
                            <option value="San Martin" class="alert-danger">San Martin</option>
                            <option value="Vicente Lopez" class="alert-danger">Vicente Lopez</option>
                            <option value="Malvinas Argentinas" class="alert-danger">Malvinas Argentinas</option>
                            <option value="Tigre" class="alert-danger">Tigre</option>
                            <option value="San Fernando" class="alert-danger">San Fernando</option>
                            <option value="Campana" class="alert-danger">Campana</option>
                          </select>
                      </div>
			              </div>
                    <div class="form-group row justify-content-center my-0">
                      <div class="form-group col-12 px-1 py-1">
                        <label class="col-form-label-sm">Cantidad de reportes</label>
                        <input type="number" name="reportes" step="1" min="0" class="form-control" placeholder="Reportes del dia">
                      </div>
                    </div>
			              <div class="form-group row justify-content-center my-0">
			              	<div class="form-group col px-1 py-1">
			                  <label class="col-form-label-sm">Observaciones</label >
			                  <textarea type="text" name="obs" maxlength="255" class="form-control" placeholder="Ingrese una observacion"></textarea>
			                </div>
			              </div>
		            	</div>    
			           </div>
			        <!-- </div> -->
		           <br>
		         		<input type="submit" name="save_kilometrosindividual" class="btn btn-success btn-block" value="Guardar dia">		            
			        </form>
	        </div>     
			  </div>
			</div>
		</div>
		<div class="col-sm-9 col-xl-10" id="mapacol">
			<div id="map"></div>
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

<!------Plugin de los mapas------->
<script src="plugin/js/leaflet-control-geocoder.Geocoder.js"></script>
<script src="plugin/js/leaflet-search.js"></script>
<!------Plugin de los mapas------->

<?php include('slider.php'); ?>
<?php include('mapa.php'); ?>
<?php include('traza.php'); ?>

<?php include('capas.php'); ?>
<?php include('reportesgpon.php'); ?>
<?php include('extras.php'); ?>

 <!------Timepicker 1---->
<script src="../../clockpicker.js"></script>
<script type="text/javascript">
    var input = $('.clockpicker').clockpicker({
      placement: 'top',
      align: 'left',
      autoclose: true,
      'default': 'now'});
</script>
</body>
</html>