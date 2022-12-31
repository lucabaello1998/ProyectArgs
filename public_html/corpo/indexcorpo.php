<?php include("../db.php"); ?>
<?php include('include/header.php'); ?>
<?php  header ('Content-type: text/html; charset=utf-8');  ?>

<?php
$mes = date ('y-m', strtotime('-0 month'));
if(isset($_POST['meses']))
{
	$mes1 = $_POST['mes'];
	$mes = "20" .date ('y-m', strtotime($mes1));
}
?>

<!-- TOTAL ALTAS-->
<?php $query= "SELECT COUNT(tarea) as 'contador_altas', tarea FROM corpo WHERE tarea = 'ALTA' AND fecha LIKE '%$mes%'";  
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$todoalta= $row['contador_altas'];}?>
<!-- TOTAL ALTAS-->


<!-- TOTAL coordinados-->
<?php $query= "SELECT COUNT(estado) as 'contador_coord', estado FROM corpo_tareas WHERE estado = 'APROBADO'";  
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$todocoord= $row['contador_coord'];}?>
<!-- TOTAL coordinados-->

<!-- TOTAL BAJAS-->


<!-- TOTAL BAJAS-->
<?php $query= "SELECT COUNT(tarea) as 'contador_bajas', tarea FROM corpo WHERE tarea = 'BAJA' AND fecha LIKE  '%$mes%'";
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$todobaja= $row['contador_bajas'];}?>
<!-- TOTAL BAJAS-->

<!-- TOTAL TOTAL-->
<?php $query= "SELECT COUNT(tarea) as 'contador_total', tarea FROM corpo WHERE fecha LIKE  '%$mes%'";
$result_tasks = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result_tasks)) { 
$todototal= $row['contador_total'];}?>
<!-- TOTAL BAJAS-->

<div class="container-fluid p-4">  <!---- RESUMEN--->
	<div class="row">		
		<div class="col-12 col-md-3 col-sm-6 align-items-center"> <!---ALTAS--->
			<div class="card bg-info">					
				<div class="row">			
					<div class="col ">
						<p class="h2 card-text text-light text-left font-weight-bold p-2"><?php echo $todoalta ?></p>				
						<p class="h4 text-light text-left ml-4">Altas</p>                           	
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
						<p class="h4 text-light text-left ml-4">Bajas</p>	
					</div>                   
					<div class="col">
						<br>						
						<p class="h1 text-light text-center"><i class="fas fa-angle-double-down"></i></i></p>	
					</div>							
				</div>
			</div>
		</div>
        
        <div class="col-12 col-md-3 col-sm-6 align-items-center"><!---coordinado--->
			<div class="card bg-danger">					
				<div class="row">			
					<div class="col ">
						<p class="h2 card-text text-light text-left font-weight-bold p-2"><?php echo $todocoord ?></p>
						<p class="h4 text-light text-left ml-4">TAREAS APROBADAS</p>	
					</div>                   
					<div class="col">
						<br>						
						<p class="h1 text-light text-center"><i class="fas fa-angle-double-down"></i></i></p>	
					</div>							
				</div>
			</div>
		</div>
       
        <div class="col-12 col-md-3 col-sm-6 align-items-center"> <!---TOTAL--->
			<div class="card bg-dark">					
				<div class="row">			
					<div class="col ">
						<p class="h2 card-text text-light text-left font-weight-bold p-2"></p>
						<p class="h4 text-light text-left ml-4">Total de Tareas<br><?php echo $todototal ?></p>
                        
					</div>
                    <div class="col">
						<br>						
						<p class="h1 text-light text-center">Altas<i class="fas fa-layer-group">
						<br><?php echo $todoalta ?></i></i></i></i></p>	
					</div>	
                    <div class="col">
						<br>						
						<p class="h1 text-light text-center">Bajas<i class="fas fa-layer-group">
						<br><?php echo $todobaja ?></i></i></i></i></p>	
					</div>	
				  <div class="col">
						<br>						
						<p class="h1 text-light text-center"><i class="fas fa-layer-group"></i></i></i></i></p>	
					</div>							
				</div>
			</div>
		</div>
	</div>
    
            
        
                     <!----BOTONES DE INFO------->
                        
                        
                <div class="row p-2">
                 <div class="col-12 col-md-3 col-sm-6 align-items-center">
				<div class="col">
                <p>
				<p><a class="btn btn-success text-light">Coordinadas <span class="badge badge-light"><?php echo $todototal?></span></a>
					</p>
				</div>
				<div class="col">
					<p>				
						<a class="btn btn-success text-light">Altas <span class="badge badge-light"><?php echo $todoalta ?></span></a>
					</p>
				</div>
				<div class="col">
					<p>				
						<a class="btn btn-success text-light">Bajas <span class="badge badge-light"><?php echo $todobaja ?></span></a>
					</p>
				</div> 
			</div></p>
		</div>
	</div>
    </div>
<!---------------------------------------------------fin de botones --------------------------------------------->    
    
                    
    
    
</div><!------Total------->
<div class="container-fluid p-4">  <!---- Coordinacion--->
	<div class="row p-2 border border">		
		<div class="col-12 col-md-3 col-sm-6 align-items-center"> <!---ALTAS--->
			<div class="card bg-info">					
				<div class="row">			
					<div class="col ">
						<p class="h2 card-text text-light text-left font-weight-bold p-2"><?php echo $todototal ?></p>				
						<p class="h4 text-light text-left ml-4">Tareas Coordinadas</p>	
					</div>
					<div class="col">
						<br>						
						<p class="h1 text-light text-center"><i class="fas fa-angle-double-up"></i></i></p>	
					</div>											
				</div>				
			</div>
			<div class="row p-2"> <!----BOTONES DE INFO------->
				<div class="col-sm-6 col-6 col-md-12 col-xl-6">
					<p>				
						<a class="btn btn-primary text-light">Tareas Coordinadas <span class="badge badge-light"><?php echo $todocoordinacion ?></span></a>
					</p>
				</div>
				<div class="col-sm-6 col-6 col-md-12 col-xl-6 align-items-center">
					<p>				
						<a class="btn btn-primary text-light">tareas <span class="badge badge-light"><?php echo $todototal ?></span></a>
					</p>
				</div> 
			</div>
		</div>
<!---------------------------------------------------------coordinacion--------------------------->





<div class="col-12 col-md-3 col-sm-6 align-items-center"> <!---Coordinacion Corpo--->
	<div>
			<div class="card bg-success">					
				<div class="row">			
					<div class="col ">
						<p class="h2 card-text text-light text-left font-weight-bold p-2"><?php echo $todototal?></p>					
						<p class="h4 text-light text-left ml-4">En Coordinacion </p>	
					</div>
					<div class="col">
						<br>						
						<p class="h1 text-light text-center"><i class="fas fa-sync-alt"></i></i></i></p>	
					</div>							
				</div>
			</div>
			<div class="row p-2"> <!----BOTONES DE INFO------->
				<div class="col">
					<p>				
						<a class="btn btn-success text-light">Coordinadas <span class="badge badge-light"><?php echo $todototal?></span></a>
					</p>
				</div>
				<div class="col">
					<p>				
						<a class="btn btn-success text-light">Altas <span class="badge badge-light"><?php echo $todoalta ?></span></a>
					</p>
				</div>
				<div class="col">
					<p>				
						<a class="btn btn-success text-light">Bajas <span class="badge badge-light"><?php echo $todobaja ?></span></a>
					</p>
				</div> 
			</div>
		</div>
	</div>
    
    
    
    
    
    
    
<!-- BOTON DESPLEGABLE-->

<div class="container-fluid p-4 border">
	<div class="row justify-content-center p-2">		
		<p><a class="btn btn-primary mt-4" data-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">Ver tablas</a></p>		
	</div>
	<div class="row justify-content-center p-1">
		<div class="col">			
		<div class="collapse multi-collapse" id="multiCollapseExample1">
        <div class="row justify-content-center p-1">
			<div class="col-12 col-md-3 col-sm-6 order-1 order-md-1 order-sm-1">
				<div class="card card-body border-info">
            		<div class="container-fluid">
            			<div class="container p-2">
                 			<div class="row justify-content-center">
                     			 <div class="col-auto p-2 text-center">
                       			 <p class="h4 mb-6 text-center">Altas Totales</p>
                       			 <table class="table table-bordered table-responsive table-striped table-sm">
                        		 <thead class="thead-dark text-center">
                            	 <tr>          
                            	 <th>Altas</th>
                            	 <th>Cant</th>       
                            	 </tr>
                         		 </thead>
                         		 <tbody>
                          		 <?php
                            	$query = "SELECT COUNT(tarea) as 'total_altas', Tarea FROM corpo WHERE tarea = 'ALTA'";
                            	$result_tasks = mysqli_query($conn, $query);  
                            	while($row = mysqli_fetch_assoc($result_tasks)) { ?>
                            	<tr>                       
                            	<td><?php echo "Total de Altas"; ?></td>
                            	<td align="center"><?php echo $row['total_altas']; ?></td>
                            	</tr>        
                           		<?php } ?>
                          		</tbody>
                        		</table>
                      			</div>
                    		</div>
                  		</div>
                        <div class="row justify-content-center">
                            <div class="col-auto p-2 text-center">
                              <p class="h4 mb-6 text-center">Bajas Totales</p>
                              <table class="table table-bordered table-responsive table-striped table-sm table-6">
                                <thead class="thead-dark text-center">
                                  <tr>          
                                  <th>BAJAS</th>
                                  <th>Cant</th>         
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                  $query = "SELECT COUNT(tarea) as 'total_bajas', Tarea FROM corpo WHERE tarea = 'BAJA'";
                                  $result_tasks = mysqli_query($conn, $query);  
                                  while($row = mysqli_fetch_assoc($result_tasks)) { ?>
                                  <tr>                       
                                  <td><?php echo "Total de Bajas"; ?></td>
                                  <td align="center"><?php echo $row['total_bajas']; ?></td>
                                  </tr>        
                                <?php } ?>
                                </tbody>
                              </table>
                            </div>
                          </div> 
                          <div class="row justify-content-center">
                      <div class="col-auto p-2 text-center">
                        <p class="h4 mb-6 text-center">Relevamiento</p>
                        <table class="table table-bordered table-responsive table-striped table-sm">
                          <thead class="thead-dark text-center">
                            <tr>          
                            <th>RELEVAMIENTO</th>
                            <th>Cant</th>         
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $query = "SELECT COUNT(tarea) as 'releva', Tarea FROM corpo WHERE tarea = 'Relevamiento'";
                            $result_tasks = mysqli_query($conn, $query);  
                            while($row = mysqli_fetch_assoc($result_tasks)) { ?>
                            <tr>       
                            <td><?php echo "Relevamiento"; ?></td>                
                            <td><?php echo $row['releva']; ?></td>
                            </tr>        
                          <?php } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                	</div>
              	 </div>
              </div>
  <div class="col-12 col-md-6 col-sm-12 order-md-2 order-sm-3 order-2">
		<div class="card border border-danger">
			<div class="row">
		    <div class="col-sm-6 col-md-6 d-none d-sm-block d-md-block d-lg-block">
					<div class="card card-body  border-0">
                      <div class="container-fluid">
                        <div class="container p-2">
                           </div>
                      </div>
                      </div>
                     </div>	
                     </div>
					<div class="col-12 col-sm-6 col-md-6 d-block d-sm-block d-md-block d-lg-block">
					<div class="card card-body border-0">
                      <div class="container-fluid">
                        <div class="container p-2">
                       
                          <div class="row justify-content-center">
                            <div class="col-auto p-2 text-center">
                              <p class="h4 mb-6 text-center">Asistencias Tecnicas </p>
                              <table class="table table-bordered table-responsive table-striped table-sm table-6">
                                <thead class="thead-dark text-center">
                                  <tr>          
                                  <th>ASISTENCIA TECNICAS</th>
                                  <th>Cant</th>         
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                  $query = "SELECT COUNT(tarea) as 'Cantidad', Tarea FROM corpo WHERE tarea = 'AsistenciaTec'";
                                  $result_tasks = mysqli_query($conn, $query);  
                                  while($row = mysqli_fetch_assoc($result_tasks)) { ?>
                                  <tr>                       
                                  <td><?php echo "Total de Cantidad"; ?></td>
                                  <td align="center"><?php echo $row['Cantidad']; ?></td>
                                  </tr>        
                                <?php } ?>
                                </tbody>
                              </table>
                              <div class="row justify-content-center">
                      <div class="col-auto p-2 text-center">
                        <p class="h4 mb-6 text-center">Asistencias Fallida</p>
                        <table class="table table-bordered table-responsive table-striped table-sm">
                          <thead class="thead-dark text-center">
                            <tr>          
                            <th>ASISTENCIA FALLIDA</th>
                            <th>Cant</th>         
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $query = "SELECT COUNT(tarea) as 'asist_fallida', Tarea FROM corpo WHERE tarea = 'Mudanza'";
                            $result_tasks = mysqli_query($conn, $query);  
                            while($row = mysqli_fetch_assoc($result_tasks)) { ?>
                            <tr>                       
                            <td><?php echo "Total de Asist Fallida"; ?></td>
                            <td align="center"><?php echo $row['asist_fallida']; ?></td>
                            </tr>        
                          <?php } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                            /////
                    
                  </div>
               </div>
               </div>
                </div>
                </div>
                </div>	
                </div>	
			</div>
		</div>
	</div>
</div>
</div>
<!-- BOTON DESPLEGABLE-->

<!-- BOTON DESPLEGABLE-->

<!--- GRAFICO TODOS LOS TECNICOS---->

<div class="container-fluid p-4 d-md-block d-lg-block">
	<div class="row p-2">
		<div class="col-12 border p-2">			
			<figure class="highcharts-figure">
        <div id="container">    	
        </div>
        <p class="highcharts-description">			       
        </p>
			</figure>			
		</div>		
	</div>
</div>


<!--- GRAFICO TODOS LOS TECNICOS---->


<div class="container">
	<div class="row">
		<div class="col">
			<div class="card card-body">
				<form action="../inicio_corpo.php" method="POST">
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


<!-- Calendario 1-->
<script src="../jquery-3.3.1.min.js"></script>
<script src="../jquery-ui-1.12.1.custom/jquery-ui.js"></script>
<script type="text/javascript">
	$(function() {
		$("#fechaint").datepicker({ dateFormat: "yy-mm-dd"});
		$( "#anim" ).on( "change", function() {
			$( "#fechaint" ).datepicker( "option", "showAnim", $( this ).val() );
		});
	} );
</script>
<!-- Calendario 2-->
<script src="../jquery-3.3.1.min.js"></script>
<script src="../jquery-ui-1.12.1.custom/jquery-ui.js"></script>
<script type="text/javascript">
	$(function() {
		$("#fecharep").datepicker({ dateFormat: "yy-mm-dd"});
		$( "#anim" ).on( "change", function() {
			$( "#fecharep" ).datepicker( "option", "showAnim", $( this ).val() );
		});
	} );
</script>



<!-- Grafico 1-->
<script src="HC/code/highcharts.js"></script>
<script src="HC/code/modules/heatmap.js"></script>
<script src="HC/code/modules/series-label.js"></script>
<script src="HC/code/modules/exporting.js"></script>
<script src="HC/code/modules/export-data.js"></script>
<script src="HC/code/modules/accessibility.js"></script>
<script type="text/javascript">
Highcharts.chart('container', {

    title: {
        text: 'Tareas'
    },

    subtitle: {
        text: 'Tipos de tareas dividido por dia'
    },

    yAxis: {
        title: {
            text: 'Total de tareas'
        }
    },

    xAxis: {
        categories:
        [
	    <?php
			$query= "SELECT SUM(CT) as 'contador_total' FROM corpo WHERE";
			$result_tasks = mysqli_query($conn, $query);
			while($row = mysqli_fetch_array($result_tasks)){
			$bb = $row['fecha'];
            $tomorrow = date('d-m', strtotime("$bb"));
			
			?>
			 '<?php echo $tomorrow; ?>',
			<?php
			}
			?>
        ]
    },

    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle'
    },

    plotOptions: {
        series: {
            label: {
                connectorAllowed: false
            },
            
        }
    },

    series: [
    {
        name: 'Tareas cumplidas',
        data:
        [
	        <?php 
			$query1= "SELECT COUNT(tarea) as 'contador_total', tarea FROM corpo";
			$result_tasks1 = mysqli_query($conn, $query1);
			while($row1 = mysqli_fetch_array($result_tasks1))
			{
			?>
			 <?php echo $row1['totcum']; ?>,
			<?php
			}
			?>
        ]
    },
    {
        name: 'Bajas',
        data:
        [
	        <?php 
			$query1= "SELECT COUNT(tarea) as 'total_bajas', Tarea FROM corpo WHERE tarea = 'BAJA'";
			$result_tasks1 = mysqli_query($conn, $query1);
			while($row1 = mysqli_fetch_array($result_tasks1))
			{
			?>
			 <?php echo $row1['totbajas']; ?>,
			<?php
			}
			?>
        ]
    },
    
    
</script>
<!-- Grafico 1-->
</body>
</html>

