
<?php include("../db.php"); 
include('../includes/header.php'); 
$mes = date ('Y-m', strtotime('-0 month'));
if(isset($_POST['meses']))
{
	$mes1 = $_POST['mes'];
	$mes = date ('Y-m', strtotime($mes1));
}

?>

<?php
$consulta = "SELECT * FROM garantias WHERE fecharep like '%$mes%' GROUP BY fecharep";
$respuesta = mysqli_query($conn, $consulta);   
while($row = mysqli_fetch_assoc($respuesta)) { 
$fefe  = $row['fecharep'];             
$solofefe = explode("-", $fefe);
$mess = $solofefe[1];
}
?>

<p class="h2 mb-4 text-center">Garantias de <?php 
switch ($mess){
  case '12': echo "Diciembre";
  break;
  case '11': echo "Noviembre";
  break;
  case '10': echo "Octubre";
  break;
  case '09': echo "Septiembre";
  break;
  case '08': echo "Agosto";
  break;
  case '07': echo "Julio";
  break;
  case '06': echo "Junio";
  break;
  case '05': echo "Mayo";
  break;
  case '04': echo "Abril";
  break;
  case '03': echo "Marzo";
  break;
  case '02': echo "Febrero";
  break;
  case '01': echo "Enero";
  break;
  }
  ?>
</p>



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

<div class="container-fluid p-4 d-md-block d-lg-block">
	<div class="row p-2">
		<div class="col-12 border p-2">	
			<ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
			  <li class="nav-item" role="presentation">
			    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Jose Leon Suarez</a>
			  </li>
			  <li class="nav-item" role="presentation">
			    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Lomas de Zamora</a>
			  </li>
			</ul>
			<div class="tab-content" id="myTabContent">
			    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <figure class="highcharts-figure">
                      <div id="individual"></div>
                      <p class="highcharts-description"></p>
                    </figure>
                </div>			  
			  <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <figure class="highcharts-figure">
                      <div id="individualsur"></div>
                      <p class="highcharts-description"></p>
                    </figure>
                </div>         
              </div>
			</div>
		</div>
	</div>
</div>

<!--- GRAFICO ---->

<div class="container-fluid p-4 d-md-block d-lg-block">
	<div class="row p-2">
		<div class="col-12 border p-2">			
			<figure class="highcharts-figure">
			    <div id="porzona">    	
			    </div>
			    <p class="highcharts-description">			       
			    </p>
			</figure>			
		</div>		
	</div>
</div>

<!--- GRAFICO ---->

<div class="container">
	<div class="row">
		<div class="col">
			<div class="card card-body">
				<form action="./garantiasgraficos.php" method="POST">
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

<!-- Grafico 1-->
<script src="../HC/code/highcharts.js"></script>
<script src="../HC/code/modules/data.js"></script>
<script src="../HC/code/modules/drilldown.js"></script>
<script src="../HC/code/modules/heatmap.js"></script>
<script src="../HC/code/modules/series-label.js"></script>
<script src="../HC/code/modules/exporting.js"></script>
<script src="../HC/code/modules/export-data.js"></script>
<script src="../HC/code/modules/accessibility.js"></script>
<script type="text/javascript">
Highcharts.chart('container', {

    title: {
        text: 'Garantias por zona'
    },

    subtitle: {
        text: 'Dias'
    },

    yAxis: {
        title: {
            text: 'Total de garantias'
        }
    },

    xAxis: {
        categories:
        [
	        <?php
			$query= "SELECT * FROM garantias WHERE fecharep LIKE '%$mes%' AND tecrep <> 'Tecnicos...' GROUP BY fecharep"; 
			$result_tasks = mysqli_query($conn, $query);
			while($row = mysqli_fetch_array($result_tasks)){
			$bb = $row['fecharep'];
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
        name: 'Jose Leon Suarez',
        data:
        [
	        <?php 
			$query= "SELECT * FROM garantias WHERE fecharep like '%$mes%' AND tecrep <> 'Tecnicos...' GROUP BY fecharep"; 
			$result_tasks = mysqli_query($conn, $query);
			while($row = mysqli_fetch_array($result_tasks)){
			$bb = $row['fecharep'];


				$nortedias= "0";

				$query1= "SELECT COUNT(fecharep) as tito FROM garantias WHERE fecharep like '%$bb%' AND zona = 'Jose Leon Suarez'";
				$result_tasks1 = mysqli_query($conn, $query1);
				while($row2 = mysqli_fetch_array($result_tasks1))
				{ 
			?>
			 <?php echo $row2['tito'] + $nortedias; ?>,
			<?php
			}}
			?>
        ]
    },
    {
        name: 'CABA',
        data:
        [
	        <?php 
			$query= "SELECT * FROM garantias WHERE fecharep like '%$mes%' AND tecrep <> 'Tecnicos...' GROUP BY fecharep"; 
			$result_tasks = mysqli_query($conn, $query);
			while($row = mysqli_fetch_array($result_tasks)){
			$bb = $row['fecharep'];


				$cabadias= "0";

				$query1= "SELECT COUNT(fecharep) as toto FROM garantias WHERE fecharep like '%$bb%' AND zona = 'CABA'";
				$result_tasks1 = mysqli_query($conn, $query1);
				while($row2 = mysqli_fetch_array($result_tasks1))
				{ 
			?>
			 <?php echo $row2['toto'] + $cabadias; ?>,
			<?php
			}}
			?>
        ]
    },
    {
        name: 'Lomas de Zamora',
        data:
        [
	        <?php 
			$query= "SELECT * FROM garantias WHERE fecharep like '%$mes%' AND tecrep <> 'Tecnicos...' GROUP BY fecharep"; 
			$result_tasks = mysqli_query($conn, $query);
			while($row = mysqli_fetch_array($result_tasks)){
			$bb = $row['fecharep'];


				$surdias= "0";

				$query1= "SELECT COUNT(fecharep) as toto FROM garantias WHERE fecharep like '%$bb%' AND zona = 'Lomas de Zamora'";
				$result_tasks1 = mysqli_query($conn, $query1);
				while($row2 = mysqli_fetch_array($result_tasks1))
				{ 
			?>
			 <?php echo $row2['toto'] + $surdias; ?>,
			<?php
			}}
			?>
        ]
    },
   
        ],

    responsive: {
        rules: [{
            condition: {
                maxWidth: 500
            },
            chartOptions: {
                legend: {
                    layout: 'horizontal',
                    align: 'center',
                    verticalAlign: 'bottom'
                }
            }
        }]
    }

});
</script>
<!-- Grafico 1-->


<script type="text/javascript">
	// Create the chart
Highcharts.chart('porzona', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Garantias por tecnico'
    },
    subtitle: {
        text: 'Haz click en cada columna para ver mas detalles'
    },
    accessibility: {
        announceNewData: {
            enabled: true
        }
    },
    xAxis: {
        type: 'category'
    },
    yAxis: {
        title: {
            text: 'Total de garantias'
        }

    },
    legend: {
        enabled: false
    },
    plotOptions: {
        series: {
            borderWidth: 0,
            dataLabels: {
                enabled: true,
                format: '{point.y}'
            }
        }
    },

    tooltip: {
        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> del total<br/>'
    },

    series: [
        {
            name: "Tecnicos",
            colorByPoint: true,
            data: [
                
			        
			        
				        <?php 
						$query1= "SELECT COUNT(tecnico) as canti, tecnico, tecrep, fecharep FROM garantias WHERE fecharep LIKE '%$mes%' AND tecrep <> '%Tecnicos%' GROUP BY tecnico";
						$result_tasks1 = mysqli_query($conn, $query1);
						while($row1 = mysqli_fetch_array($result_tasks1))
						{
						?>
							<?php
							echo '{name: "' .$row1['tecnico'] .'",';
							echo 'y:' .$row1['canti'] .','; 		                    
              echo 'drilldown: "' .$row1['tecnico'] .'"},'; ?>
						 
						<?php
						}
						?>
			        
            ]
        }
    ],
    drilldown: {
        breadcrumbs: {
            position: {
                align: 'right'
            }
        },
        series: [
            <?php
            $query= "SELECT * FROM garantias WHERE fecharep like '%$mes%' AND tecrep <> 'Tecnicos...' GROUP BY tecnico"; 
            $result_tasks = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result_tasks)){
            $aa = $row['tecnico'];
            echo '{name: "' .$aa .'",';
            echo 'id: "' .$aa .'", data: [';
            
                $nortedias= "0";
                $query1= "SELECT COUNT(coment) as tito, tecnico, coment FROM garantias WHERE fecharep like '%$mes%' AND tecnico = '$aa' GROUP BY coment";
                $result_tasks1 = mysqli_query($conn, $query1);
                while($row2 = mysqli_fetch_array($result_tasks1))
                {
                $cc = $row2['coment'];
            ?>
             <?php echo "["; ?>
             <?php echo '"' .$cc .'",' ; ?>
             <?php echo $row2['tito'] + $nortedias ; ?>
             <?php echo "],"; ?>

            <?php
                    
                } 
            echo "]},";
            }
            ?>
        ]
    }
});
</script>
<script type="text/javascript">
    Highcharts.chart('individual', {
  chart: {
    type: 'column'
  },
  title: {
    text: 'Motivos'
  },
  subtitle: {
    text: 'Garantias de Jose Leon Suarez'
  },
  xAxis: {
    type: 'category',
    labels: {
      rotation: -45,
      style: {
        fontSize: '13px',
        fontFamily: 'Verdana, sans-serif'
      }
    }
  },
  yAxis: {
    min: 0,
    title: {
      text: 'Garantias'
    }
  },
  legend: {
    enabled: false
  },
  tooltip: {
    pointFormat: 'Garantias: <b>{point.y}</b>'
  },
  series: [{
    name: 'Population',
    data: [
            <?php
            $comentarios= "0";
            $query= "SELECT COUNT(fecharep) as motivos, coment FROM garantias WHERE fecharep like '%$mes%' AND tecrep <> 'Tecnicos...' AND zona = 'Jose Leon Suarez' GROUP BY coment"; 
            $result_tasks = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result_tasks)){ ?>

                <?php
                echo "['" .$row['coment'] ."',";                          
                echo $row['motivos'] + $comentarios ."],"; 
                ?>         
            

            <?php
            }
            ?>
    ],
    dataLabels: {
      enabled: true,
      rotation: -90,
      color: '#FFFFFF',
      align: 'right',
      format: '{point.y:}', // one decimal
      y: 10, // 10 pixels down from the top
      style: {
        fontSize: '13px',
        fontFamily: 'Verdana, sans-serif'
      }
    }
  }]
});
</script>
<script type="text/javascript">
    Highcharts.chart('individualsur', {
  chart: {
    type: 'column'
  },
  title: {
    text: 'Motivos'
  },
  subtitle: {
    text: 'Garantias de Lomas de Zamora'
  },
  xAxis: {
    type: 'category',
    labels: {
      rotation: -45,
      style: {
        fontSize: '13px',
        fontFamily: 'Verdana, sans-serif'
      }
    }
  },
  yAxis: {
    min: 0,
    title: {
      text: 'Garantias'
    }
  },
  legend: {
    enabled: false
  },
  tooltip: {
    pointFormat: 'Garantias: <b>{point.y}</b>'
  },
  series: [{
    name: 'Population',
    data: [
            <?php
            $comentarios= "0";
            $query= "SELECT COUNT(fecharep) as motivos, coment FROM garantias WHERE fecharep like '%$mes%' AND tecrep <> 'Tecnicos...' AND zona = 'Lomas de Zamora' OR fecharep like '%$mes%' AND tecrep <> 'Tecnicos...' AND zona = 'CABA' GROUP BY coment"; 
            $result_tasks = mysqli_query($conn, $query);
            while($row = mysqli_fetch_array($result_tasks)){ ?>

                <?php
                echo "['" .$row['coment'] ."',";                          
                echo $row['motivos'] + $comentarios ."],"; 
                ?>         
            

            <?php
            }
            ?>
    ],
    dataLabels: {
      enabled: true,
      rotation: -90,
      color: '#FFFFFF',
      align: 'right',
      format: '{point.y:}', // one decimal
      y: 10, // 10 pixels down from the top
      style: {
        fontSize: '13px',
        fontFamily: 'Verdana, sans-serif'
      }
    }
  }]
});
</script>
</body>
</html>
