<script type="text/javascript">

var baseTree =
[
];

<?php 

?>

<?php
if(isset($_POST['save_fechas']))
{
$fecha_uno = $_POST['fecha_uno'];
$fecha_dos = $_POST['fecha_dos'];
$reporte = $_POST['reporte'];
}
$mesi = "-" ."00" ."-";
if ($reporte == "gpon")
{
?>

var overlaysTree =
{
    label: 'Reportes gpon<div id="onlyselec"></div>',
    children:[
                
                            <?php $quer= "SELECT * FROM atcreportesgpon WHERE fecha BETWEEN '$fecha_uno' AND '$fecha_dos' GROUP BY fecha like '%$mesi%'"; 
                            $resul = mysqli_query($conn, $quer);
                            while($row = mysqli_fetch_assoc($resul)){                    
                            $fechifechi = $row['fecha'];
                            $fefefe = explode("-", $fechifechi);
                            $memes = $fefefe[1];
                            $mememes = $fefefe[0] ."-" .$fefefe[1];
                            $diaa = $fefefe[0] ."-" .$fefefe[1] ."-" .$fefefe[2] ;
                            switch ($memes){
                                          case '12': $mes = "Diciembre";
                                          break;
                                          case '11': $mes = "Noviembre";
                                          break;
                                          case '10': $mes = "Octubre";
                                          break;
                                          case '09': $mes = "Septiembre";
                                          break;
                                          case '08': $mes = "Agosto";
                                          break;
                                          case '07': $mes = "Julio";
                                          break;
                                          case '06': $mes = "Junio";
                                          break;
                                          case '05': $mes = "Mayo";
                                          break;
                                          case '04': $mes = "Abril";
                                          break;
                                          case '03': $mes = "Marzo";
                                          break;
                                          case '02': $mes = "Febrero";
                                          break;
                                          case '01': $mes = "Enero";
                                          break;
                                          }?>

                            {label:  <?php echo "' " .$mes ."'" ; ?> ,
                            selectAllCheckbox: 'De/seleccionar todo',
                            children:[
                                        <?php $consulta= "SELECT * FROM atcreportesgpon WHERE fecha BETWEEN '$fecha_uno' AND '$fecha_dos' GROUP BY fecha "; 
                                                $resultado = mysqli_query($conn, $consulta);
                                                while($row = mysqli_fetch_assoc($resultado)){                    
                                                $fech = $row['fecha'];
                                                $pibitos = $row['empleado'];
                                                $fe = explode("-", $fech);
                                                $diasinmes = $fe[2];
                                                $diafinal = $fe[0] ."-" .$fe[1] ."-" .$fe[2] ; ?>
                                                {label:  <?php echo "' " .$diasinmes ."'" ; ?> ,
                                                selectAllCheckbox: 'De/seleccionar todo',
                                                children:[                     
                                                        <?php $muestra= "SELECT * FROM atcreportesgpon WHERE fecha like '%$diafinal%' GROUP BY empleado"; 
                                                                $resulmuestra = mysqli_query($conn, $muestra);
                                                                while($row = mysqli_fetch_assoc($resulmuestra)){                    
                                                                $fechchi = $row['fecha'];
                                                                $pibes = $row['empleado'];
                                                                $ferro = explode("-", $fech);
                                                                $diasdos = $ferro[2];
                                                                $final = $ferro[0] ."-" .$ferro[1] ."-" .$ferro[2] ; ?>
                                                                {label:  <?php echo "' " .$pibes ."'" ; ?> ,
                                                                selectAllCheckbox: 'De/seleccionar todo',
                                                                children:[                     
                                                                        <?php   $consulls= "SELECT * FROM atcreportesgpon WHERE fecha like '%$final%' AND empleado like '%$pibes%'"; 
                                                                                $resulls = mysqli_query($conn, $consulls);
                                                                                while($row = mysqli_fetch_array($resulls))
                                                                                {
                                                                                $id = $row['id'];
                                                                                $latitud = $row['latitud'];
                                                                                $longitud = $row['longitud'];
                                                                                $tarea = $row['tarea'];
                                                                                $fecha = $row['fecha'];
                                                                                $hora = $row['hora'];
                                                                                $relevadores = $row['empleado'];
                                                                                $direccion = $row['direccion'];
                                                                                $partido = $row['partido'];
                                                                                $localidad = $row['localidad'];
                                                                                
                                                                                $prioridad = $row['prioridad'];
                                                                                $observaciones = $row['observaciones'];

                                                                                $reles  = $relevadores;             
                                                                                $soloreles = explode(" ", $reles); // explota el string en " " espacios
                                                                                $uno = $soloreles[0];  // asigna un valor por el resultado del explotado
                                                                                $dos = $soloreles[1];
                                                                                $tres = $soloreles[2];

                                                                                if ($uno != "")
                                                                                {
                                                                                    
                                                                                    $nomnom = $uno;
                                                                                    $apeape = $dos;
                                                                                }
                                                                                else
                                                                                {
                                                                                    

                                                                                    $nomnom = $dos;
                                                                                    $apeape = $tres;
                                                                                    
                                                                                }

                                                                                    $queryys= "SELECT * FROM tecnicosatc WHERE nombre LIKE '%$nomnom%' AND apellido LIKE '%$apeape%'"; 
                                                                                    $resultas = mysqli_query($conn, $queryys);
                                                                                    while($row = mysqli_fetch_array($resultas))
                                                                                    {   
                                                                                        $colors = $row['color'];
                                                                                    }   
                                                                                $circuloop = "{color: '" .$colors ."',
                                                                                                weight: 1,
                                                                                                opacity: 0.8,
                                                                                                fillColor: '" .$colors ."',
                                                                                                fillOpacity: 0.4,
                                                                                                radius: 5,} ";


                                                                                $informacion =   "<b>Fecha: </b>" .$fecha ."<br>"
                                                                                                ."<b>Hora: </b>" .$hora ."<br>"
                                                                                                ."<b>Tarea: </b>" .$tarea ."<br>"
                                                                                                ."<b>Relevador: </b>" .$relevadores ."<br>"
                                                                                                ."<b>Partido: </b>" .$partido ."<br>"
                                                                                                ."<b>Localidad: </b>" .$localidad ."<br>"
                                                                                                ."<b>Direccion: </b>" .$direccion ."<br>"
                                                                                                
                                                                                                ."<b>Lat: </b>" .$latitud ."<br>"
                                                                                                ."<b>Long: </b>" .$longitud ."<br>"
                                                                                                ."<b>Prioridad: </b>" .$prioridad ."<br>"
                                                                                                ."<b>Observaciones: </b>" .$observaciones ."<br>"
                                                                                                ."<b>Color: </b>" .$colors ."," .$nomnom ."," .$apeape ."<br>"
                                                                                                ."<b>Color: </b>" .$uno ."-" .$dos ."-" .$tres ."<br>";


                                                                                $editar =   '<form action="Editar/edit_reportesgpon.php?id=' .$id .' " method="POST">'
                                                                                            .'<div class="form-group row justify-content-center ml-0 mt-0 mb-0">'
                                                                                                .'<label for="edicionreportes" class="col-form-label-sm">Fecha</label>'
                                                                                                .'<div class="form-group col">'
                                                                                                    .'<input type="text" name="fecha" class="form-control form-control-sm" value="' .$fecha .'" readonly>'
                                                                                                .'</div>'
                                                                                            .'</div>'
                                                                                            .'<div class="form-group row justify-content-center ml-0 mt-0 mb-0">'
                                                                                                .'<label for="edicionreportes" class="col-form-label-sm">Hora</label>'
                                                                                                .'<div class="form-group col">'
                                                                                                    .'<input type="text" name="hora" class="form-control form-control-sm" value="' .$hora .'" readonly>'
                                                                                                .'</div>'
                                                                                            .'</div>'
                                                                                            .'<div class="form-group row justify-content-center ml-0 mt-0 mb-0">'
                                                                                                .'<label for="edicionreportes" class="col-form-label-sm">Tarea</label>'
                                                                                                .'<div class="form-group col">'
                                                                                                    .'<input type="text" name="tarea" class="form-control form-control-sm" value="' .$tarea .'" readonly>'
                                                                                                .'</div>'
                                                                                            .'</div>'
                                                                                            .'<div class="form-group row justify-content-center ml-0 mt-0 mb-0">'
                                                                                                .'<label for="edicionreportes" class="col-form-label-sm">Relevador</label>'
                                                                                                .'<div class="form-group col">'
                                                                                                    .'<input type="text" name="relevador" class="form-control form-control-sm" value="' .$relevador .'" readonly>'
                                                                                                .'</div>'
                                                                                            .'</div>'
                                                                                            .'<div class="form-group row justify-content-center ml-0 mt-0 mb-0">'
                                                                                                .'<label for="edicionreportes" class="col-form-label-sm">Partido</label>'
                                                                                                .'<div class="form-group col">'
                                                                                                    .'<select type="text" name="partido" class="form-control form-control-sm">'
                                                                                                      .'<option selected>' .$partido .'</option>'
                                                                                                      .'<option value="Moron" class="alert-primary">Moron</option>'
                                                                                                      .'<option value="San Martin" class="alert-success">San Martin</option>'
                                                                                                      .'<option value="Tres de Febrero" class="alert-danger">Tres de Febrero</option>'
                                                                                                      .'<option value="Hurlingham" class="alert-warning">Hurlingham</option>'
                                                                                                      .'<option value="Vicente Lopez" class="alert-info">Vicente Lopez</option>'
                                                                                                      .'<option value="CABA">CABA</option>'
                                                                                                    .'</select>'
                                                                                                .'</div>'
                                                                                            .'</div>'
                                                                                            .'<div class="form-group row justify-content-center ml-0 mt-0 mb-0">'
                                                                                                .'<label for="edicionreportes" class="col-form-label-sm">Localidad</label>'
                                                                                                .'<div class="form-group col">'
                                                                                                    .'<select type="text" name="localidad" class="form-control form-control-sm">'
                                                                                                      .'<option selected>' .$localidad .'</option>'
                                                                                                      .'<option value="Castelar" class="alert-primary">Castelar</option>'
                                                                                                      .'<option value="Palomar" class="alert-primary">Palomar</option>'
                                                                                                      .'<option value="Haedo" class="alert-primary">Haedo</option>'
                                                                                                      .'<option value="Mor??n" class="alert-primary">Mor??n</option>'
                                                                                                      .'<option value="Villa Sarmiento" class="alert-primary">Villa Sarmiento</option>'
                                                                                                      .'<option value="Billinghurst" class="alert-success">Billinghurst</option>'
                                                                                                      .'<option value="Loma Hermosa" class="alert-success">Loma Hermosa</option>'
                                                                                                      .'<option value="Jos?? Le??n Su??rez" class="alert-success">Jos?? Le??n Su??rez</option>'
                                                                                                      .'<option value="San Andr??s" class="alert-success">San Andr??s</option>'
                                                                                                      .'<option value="San Mart??n" class="alert-success">San Mart??n</option>'
                                                                                                      .'<option value="Villa Chacabuco" class="alert-success">Villa Chacabuco</option>'
                                                                                                      .'<option value="Villa Ballester" class="alert-success">Villa Ballester</option>'
                                                                                                      .'<option value="Villa Lynch" class="alert-success">Villa Lynch</option>'
                                                                                                      .'<option value="Villa Maip??" class="alert-success">Villa Maip??</option>'
                                                                                                      .'<option value="Villa Ayacucho" class="alert-success">Villa Ayacucho</option>'
                                                                                                      .'<option value="Caseros" class="alert-danger">Caseros</option>'
                                                                                                      .'<option value="Churruca" class="alert-danger">Churruca</option>'
                                                                                                      .'<option value="Ciudad Jard??n" class="alert-danger">Ciudad Jard??n</option>'
                                                                                                      .'<option value="Jos?? Ingenieros" class="alert-danger">Jos?? Ingenieros</option>'
                                                                                                      .'<option value="Ciudadela" class="alert-danger">Ciudadela</option>'
                                                                                                      .'<option value="El Libertador" class="alert-danger">El Libertador</option>'
                                                                                                      .'<option value="Loma Hermosa" class="alert-danger">Loma Hermosa</option>'
                                                                                                      .'<option value="Mart??n Coronado" class="alert-danger">Mart??n Coronado</option>'
                                                                                                      .'<option value="Once de Septiembre" class="alert-danger">Once de Septiembre</option>'
                                                                                                      .'<option value="Pablo Podest??" class="alert-danger">Pablo Podest??</option>'
                                                                                                      .'<option value="Remedios de Escalada" class="alert-danger">Remedios de Escalada</option>'
                                                                                                      .'<option value="S??enz Pe??a" class="alert-danger">S??enz Pe??a</option>'
                                                                                                      .'<option value="Santos Lugares" class="alert-danger">Santos Lugares</option>'
                                                                                                      .'<option value="Villa Bosch" class="alert-danger">Villa Bosch</option>'
                                                                                                      .'<option value="Villa Raffo" class="alert-danger">Villa Raffo</option>'
                                                                                                      .'<option value="William Morris" class="alert-warning">William Morris</option>'
                                                                                                      .'<option value="Villa Tesei" class="alert-warning">Villa Tesei</option>'
                                                                                                      .'<option value="Hurlingham" class="alert-warning">Hurlingham</option>'
                                                                                                      .'<option value="Vicente L??pez" class="alert-info">Vicente L??pez</option>'                                                                                      
                                                                                                      .'<option value="Olivos" class="alert-info">Olivos</option>'
                                                                                                      .'<option value="Florida" class="alert-info">Florida</option>'
                                                                                                      .'<option value="La Lucila" class="alert-info">La Lucila</option>'
                                                                                                      .'<option value="Buenos Aires">Buenos Aires</option>'
                                                                                                    .'</select>'
                                                                                                .'</div>'
                                                                                            .'</div>'
                                                                                            .'<div class="form-group row justify-content-center ml-0 mt-0 mb-0">'
                                                                                                .'<label for="edicionreportes" class="col-form-label-sm">Direccion</label>'
                                                                                                .'<div class="form-group col">'
                                                                                                    .'<input type="text" name="direccion" class="form-control form-control-sm" value="' .$direccion .'" readonly>'
                                                                                                .'</div>'
                                                                                            .'</div>'
                                                                                            
                                                                                            .'<div class="form-group row justify-content-center ml-0 mt-0 mb-0">'
                                                                                                .'<label for="edicionreportes" class="col-form-label-sm">Lat</label>'
                                                                                                .'<div class="form-group col">'
                                                                                                    .'<input type="text" name="latitud" class="form-control form-control-sm" value="' .$latitud .'" readonly>'
                                                                                                .'</div>'
                                                                                            .'</div>'
                                                                                            .'<div class="form-group row justify-content-center ml-0 mt-0 mb-0">'
                                                                                                .'<label for="edicionreportes" class="col-form-label-sm">Long</label>'
                                                                                                .'<div class="form-group col">'
                                                                                                    .'<input type="text" name="longitud" class="form-control form-control-sm" value="' .$longitud .'" readonly>'
                                                                                                .'</div>'
                                                                                            .'</div>'
                                                                                            .'<div class="form-group row justify-content-center ml-0 mt-0 mb-0">'
                                                                                                .'<label for="edicionreportes" class="col-form-label-sm">Prioridad</label>'
                                                                                                .'<div class="form-group col">'
                                                                                                    .'<select type="text" name="prioridad" class="form-control form-control-sm">'
                                                                                                      .'<option selected>' .$prioridad .'</option>'
                                                                                                      .'<option value="ALTA">ALTA</option>'
                                                                                                      .'<option value="MODERADA">MODERADA</option>'
                                                                                                      .'<option value="BAJA">BAJA</option>'
                                                                                                    .'</select>'
                                                                                                .'</div>'
                                                                                            .'</div>'
                                                                                            .'<div class="form-group row justify-content-center ml-0 mt-0 mb-0">'
                                                                                                .'<label for="edicionreportes" class="col-form-label-sm">Observaciones</label>'
                                                                                                .'<div class="form-group col">'
                                                                                                    .'<input type="text" name="observaciones" class="form-control form-control-sm" value="' .$observaciones .'" readonly>'
                                                                                                .'</div>'
                                                                                            .'</div>'
                                                                                            .'<br>'
                                                                                                .'<input type="submit" name="actualizar" class="btn btn-success btn-block" value="Actualizar reporte">'
                                                                                            .'</form>';                                                             

                                                                                
                                                                                ?>
                                                                                
                                                                            {label:  <?php echo "' " .$tarea ."'" ; ?> ,
                                                                            layer: L.circleMarker([ <?php echo $latitud; ?> , <?php echo $longitud; ?>], <?php echo $circuloop; ?>)
                                                                            .bindPopup( '<b>Direccion: </b>' +<?php echo "'" .$direccion ."'"; ?> +'<br>'+
                                                                                        '<b>Hora: </b>' +<?php echo "'" .$hora ."'"; ?> +'<br>'+
                                                                                        '<b>Relevador: </b>' +<?php echo "'" .$relevadores ."'"; ?> +'<br>')
                                                                            .on('click', function() {
                                                                            var primerId = document.querySelector('#informacion');  ////se crea la varaiable "primerId" y se enlaza con el "ID" de HTML llamado "titulo"
                                                                            primerId.innerHTML = <?php echo "'" .$informacion ."'" ; ?>; ////se le asigna a la variable "primerId" que traspase los nuevos datos por medio de la varaible "$informacion"
                                                                            var segundoId = document.querySelector('#editar');  ////se crea la varaiable "primerId" y se enlaza con el "ID" de HTML llamado "titulo"
                                                                            segundoId.innerHTML = <?php echo "'" .$editar ."'" ; ?>; ////se le asigna a la variable "primerId" que traspase los nuevos datos por medio de la varaible "$informacion"
                                                                            })},
                                                                            <?php } ?>
                                                                        ]
                                                                },
                                                        <?php } ?>
                                                        ]
                                                },
                                        <?php } ?>
                                     ]
                            },
                            <?php } ?>
                         
            ]
}

<?php } 
if ($reporte == "lineal") { ?>

var overlaysTree =
{
    label: 'Reportes lineal<div id="onlyselec"></div>',
    children:[
                
                            <?php $quer= "SELECT * FROM atcreporteslineal WHERE fecha BETWEEN '$fecha_uno' AND '$fecha_dos' GROUP BY fecha like '%$mesi%'"; 
                            $resul = mysqli_query($conn, $quer);
                            while($row = mysqli_fetch_assoc($resul)){                    
                            $fechifechi = $row['fecha'];
                            $fefefe = explode("-", $fechifechi);
                            $memes = $fefefe[1];
                            $mememes = $fefefe[0] ."-" .$fefefe[1];
                            $diaa = $fefefe[0] ."-" .$fefefe[1] ."-" .$fefefe[2] ;
                            switch ($memes){
                                          case '12': $mes = "Diciembre";
                                          break;
                                          case '11': $mes = "Noviembre";
                                          break;
                                          case '10': $mes = "Octubre";
                                          break;
                                          case '09': $mes = "Septiembre";
                                          break;
                                          case '08': $mes = "Agosto";
                                          break;
                                          case '07': $mes = "Julio";
                                          break;
                                          case '06': $mes = "Junio";
                                          break;
                                          case '05': $mes = "Mayo";
                                          break;
                                          case '04': $mes = "Abril";
                                          break;
                                          case '03': $mes = "Marzo";
                                          break;
                                          case '02': $mes = "Febrero";
                                          break;
                                          case '01': $mes = "Enero";
                                          break;
                                          }?>

                            {label:  <?php echo "' " .$mes ."'" ; ?> ,
                            selectAllCheckbox: 'De/seleccionar todo',
                            children:[
                                        <?php $consulta= "SELECT * FROM atcreporteslineal WHERE fecha BETWEEN '$fecha_uno' AND '$fecha_dos' GROUP BY fecha "; 
                                                $resultado = mysqli_query($conn, $consulta);
                                                while($row = mysqli_fetch_assoc($resultado)){                    
                                                $fech = $row['fecha'];
                                                $pibitos = $row['empleado'];
                                                $fe = explode("-", $fech);
                                                $diasinmes = $fe[2];
                                                $diafinal = $fe[0] ."-" .$fe[1] ."-" .$fe[2] ; ?>
                                                {label:  <?php echo "' " .$diasinmes ."'" ; ?> ,
                                                selectAllCheckbox: 'De/seleccionar todo',
                                                children:[                     
                                                        <?php $muestra= "SELECT * FROM atcreporteslineal WHERE fecha like '%$diafinal%' GROUP BY empleado"; 
                                                                $resulmuestra = mysqli_query($conn, $muestra);
                                                                while($row = mysqli_fetch_assoc($resulmuestra)){                    
                                                                $fechchi = $row['fecha'];
                                                                $pibes = $row['empleado'];
                                                                $ferro = explode("-", $fech);
                                                                $diasdos = $ferro[2];
                                                                $final = $ferro[0] ."-" .$ferro[1] ."-" .$ferro[2] ; ?>
                                                                {label:  <?php echo "' " .$pibes ."'" ; ?> ,
                                                                selectAllCheckbox: 'De/seleccionar todo',
                                                                children:[                     
                                                                        <?php   $consull= "SELECT * FROM atcreporteslineal WHERE fecha like '%$final%' AND empleado like '%$pibes%'"; 
                                                                                $resull = mysqli_query($conn, $consull);
                                                                                while($row = mysqli_fetch_assoc($resull))
                                                                                {
                                                                                $id = $row['id'];
                                                                                $latitud = $row['latitud'];
                                                                                $longitud = $row['longitud'];
                                                                                $tarea = $row['tarea'];
                                                                                $fecha = $row['fecha'];
                                                                                $hora = $row['hora'];
                                                                                $relevador = $row['empleado'];
                                                                                $direccion = $row['direccion'];
                                                                                $relevador = $row['empleado'];
                                                                                $partido = $row['partido'];
                                                                                $localidad = $row['localidad'];
                                                                                
                                                                                $prioridad = $row['prioridad'];
                                                                                $observaciones = $row['observaciones'];

                                                                                $rele  = $relevador;             
                                                                                
                                                                                $nombre = strtoupper(substr($relevador, 0, 3));

                                                                                    $queryy= "SELECT * FROM tecnicosatc WHERE nombre like '%$nombre%' "; 
                                                                                    $resulta = mysqli_query($conn, $queryy);
                                                                                    while($row = mysqli_fetch_assoc($resulta))
                                                                                    {   
                                                                                        $color = $row['color'];
                                                                                    }   
                                                                                $circuloopl = "{color: '" .$color ."',
                                                                                                weight: 1,
                                                                                                opacity: 0.8,
                                                                                                fillColor: '" .$color ."',
                                                                                                fillOpacity: 0.4,
                                                                                                radius: 5,} ";


                                                                                $informacion =   "<b>Fecha: </b>" .$fecha ."<br>"
                                                                                                ."<b>Hora: </b>" .$hora ."<br>"
                                                                                                ."<b>Tarea: </b>" .$tarea ."<br>"
                                                                                                ."<b>Relevador: </b>" .$relevador ."<br>"
                                                                                                ."<b>Partido: </b>" .$partido ."<br>"
                                                                                                ."<b>Localidad: </b>" .$localidad ."<br>"
                                                                                                ."<b>Direccion: </b>" .$direccion ."<br>"
                                                                                                
                                                                                                ."<b>Lat: </b>" .$latitud ."<br>"
                                                                                                ."<b>Long: </b>" .$longitud ."<br>"
                                                                                                ."<b>Prioridad: </b>" .$prioridad ."<br>"
                                                                                                ."<b>Observaciones: </b>" .$observaciones ."<br>";


                                                                                $editar =   '<form action="Editar/edit_reportesgpon.php?id=' .$id .' " method="POST">'
                                                                                            .'<div class="form-group row justify-content-center ml-0 mt-0 mb-0">'
                                                                                                .'<label for="edicionreportes" class="col-form-label-sm">Fecha</label>'
                                                                                                .'<div class="form-group col">'
                                                                                                    .'<input type="text" name="fecha" class="form-control form-control-sm" value="' .$fecha .'" readonly>'
                                                                                                .'</div>'
                                                                                            .'</div>'
                                                                                            .'<div class="form-group row justify-content-center ml-0 mt-0 mb-0">'
                                                                                                .'<label for="edicionreportes" class="col-form-label-sm">Hora</label>'
                                                                                                .'<div class="form-group col">'
                                                                                                    .'<input type="text" name="hora" class="form-control form-control-sm" value="' .$hora .'" readonly>'
                                                                                                .'</div>'
                                                                                            .'</div>'
                                                                                            .'<div class="form-group row justify-content-center ml-0 mt-0 mb-0">'
                                                                                                .'<label for="edicionreportes" class="col-form-label-sm">Tarea</label>'
                                                                                                .'<div class="form-group col">'
                                                                                                    .'<input type="text" name="tarea" class="form-control form-control-sm" value="' .$tarea .'" readonly>'
                                                                                                .'</div>'
                                                                                            .'</div>'
                                                                                            .'<div class="form-group row justify-content-center ml-0 mt-0 mb-0">'
                                                                                                .'<label for="edicionreportes" class="col-form-label-sm">Relevador</label>'
                                                                                                .'<div class="form-group col">'
                                                                                                    .'<input type="text" name="relevador" class="form-control form-control-sm" value="' .$relevador .'" readonly>'
                                                                                                .'</div>'
                                                                                            .'</div>'
                                                                                            .'<div class="form-group row justify-content-center ml-0 mt-0 mb-0">'
                                                                                                .'<label for="edicionreportes" class="col-form-label-sm">Partido</label>'
                                                                                                .'<div class="form-group col">'
                                                                                                    .'<select type="text" name="partido" class="form-control form-control-sm">'
                                                                                                      .'<option selected>' .$partido .'</option>'
                                                                                                      .'<option value="Moron" class="alert-primary">Moron</option>'
                                                                                                      .'<option value="San Martin" class="alert-success">San Martin</option>'
                                                                                                      .'<option value="Tres de Febrero" class="alert-danger">Tres de Febrero</option>'
                                                                                                      .'<option value="Hurlingham" class="alert-warning">Hurlingham</option>'
                                                                                                      .'<option value="Vicente Lopez" class="alert-info">Vicente Lopez</option>'
                                                                                                      .'<option value="CABA">CABA</option>'
                                                                                                    .'</select>'
                                                                                                .'</div>'
                                                                                            .'</div>'
                                                                                            .'<div class="form-group row justify-content-center ml-0 mt-0 mb-0">'
                                                                                                .'<label for="edicionreportes" class="col-form-label-sm">Localidad</label>'
                                                                                                .'<div class="form-group col">'
                                                                                                    .'<select type="text" name="localidad" class="form-control form-control-sm">'
                                                                                                      .'<option selected>' .$localidad .'</option>'
                                                                                                      .'<option value="Castelar" class="alert-primary">Castelar</option>'
                                                                                                      .'<option value="Palomar" class="alert-primary">Palomar</option>'
                                                                                                      .'<option value="Haedo" class="alert-primary">Haedo</option>'
                                                                                                      .'<option value="Mor??n" class="alert-primary">Mor??n</option>'
                                                                                                      .'<option value="Villa Sarmiento" class="alert-primary">Villa Sarmiento</option>'
                                                                                                      .'<option value="Billinghurst" class="alert-success">Billinghurst</option>'
                                                                                                      .'<option value="Loma Hermosa" class="alert-success">Loma Hermosa</option>'
                                                                                                      .'<option value="Jos?? Le??n Su??rez" class="alert-success">Jos?? Le??n Su??rez</option>'
                                                                                                      .'<option value="San Andr??s" class="alert-success">San Andr??s</option>'
                                                                                                      .'<option value="San Mart??n" class="alert-success">San Mart??n</option>'
                                                                                                      .'<option value="Villa Chacabuco" class="alert-success">Villa Chacabuco</option>'
                                                                                                      .'<option value="Villa Ballester" class="alert-success">Villa Ballester</option>'
                                                                                                      .'<option value="Villa Lynch" class="alert-success">Villa Lynch</option>'
                                                                                                      .'<option value="Villa Maip??" class="alert-success">Villa Maip??</option>'
                                                                                                      .'<option value="Villa Ayacucho" class="alert-success">Villa Ayacucho</option>'
                                                                                                      .'<option value="Caseros" class="alert-danger">Caseros</option>'
                                                                                                      .'<option value="Churruca" class="alert-danger">Churruca</option>'
                                                                                                      .'<option value="Ciudad Jard??n" class="alert-danger">Ciudad Jard??n</option>'
                                                                                                      .'<option value="Jos?? Ingenieros" class="alert-danger">Jos?? Ingenieros</option>'
                                                                                                      .'<option value="Ciudadela" class="alert-danger">Ciudadela</option>'
                                                                                                      .'<option value="El Libertador" class="alert-danger">El Libertador</option>'
                                                                                                      .'<option value="Loma Hermosa" class="alert-danger">Loma Hermosa</option>'
                                                                                                      .'<option value="Mart??n Coronado" class="alert-danger">Mart??n Coronado</option>'
                                                                                                      .'<option value="Once de Septiembre" class="alert-danger">Once de Septiembre</option>'
                                                                                                      .'<option value="Pablo Podest??" class="alert-danger">Pablo Podest??</option>'
                                                                                                      .'<option value="Remedios de Escalada" class="alert-danger">Remedios de Escalada</option>'
                                                                                                      .'<option value="S??enz Pe??a" class="alert-danger">S??enz Pe??a</option>'
                                                                                                      .'<option value="Santos Lugares" class="alert-danger">Santos Lugares</option>'
                                                                                                      .'<option value="Villa Bosch" class="alert-danger">Villa Bosch</option>'
                                                                                                      .'<option value="Villa Raffo" class="alert-danger">Villa Raffo</option>'
                                                                                                      .'<option value="William Morris" class="alert-warning">William Morris</option>'
                                                                                                      .'<option value="Villa Tesei" class="alert-warning">Villa Tesei</option>'
                                                                                                      .'<option value="Hurlingham" class="alert-warning">Hurlingham</option>'
                                                                                                      .'<option value="Vicente L??pez" class="alert-info">Vicente L??pez</option>'                                                                                      
                                                                                                      .'<option value="Olivos" class="alert-info">Olivos</option>'
                                                                                                      .'<option value="Florida" class="alert-info">Florida</option>'
                                                                                                      .'<option value="La Lucila" class="alert-info">La Lucila</option>'
                                                                                                      .'<option value="Buenos Aires">Buenos Aires</option>'
                                                                                                    .'</select>'
                                                                                                .'</div>'
                                                                                            .'</div>'
                                                                                            .'<div class="form-group row justify-content-center ml-0 mt-0 mb-0">'
                                                                                                .'<label for="edicionreportes" class="col-form-label-sm">Direccion</label>'
                                                                                                .'<div class="form-group col">'
                                                                                                    .'<input type="text" name="direccion" class="form-control form-control-sm" value="' .$direccion .'" readonly>'
                                                                                                .'</div>'
                                                                                            .'</div>'
                                                                                            
                                                                                            .'<div class="form-group row justify-content-center ml-0 mt-0 mb-0">'
                                                                                                .'<label for="edicionreportes" class="col-form-label-sm">Lat</label>'
                                                                                                .'<div class="form-group col">'
                                                                                                    .'<input type="text" name="latitud" class="form-control form-control-sm" value="' .$latitud .'" readonly>'
                                                                                                .'</div>'
                                                                                            .'</div>'
                                                                                            .'<div class="form-group row justify-content-center ml-0 mt-0 mb-0">'
                                                                                                .'<label for="edicionreportes" class="col-form-label-sm">Long</label>'
                                                                                                .'<div class="form-group col">'
                                                                                                    .'<input type="text" name="longitud" class="form-control form-control-sm" value="' .$longitud .'" readonly>'
                                                                                                .'</div>'
                                                                                            .'</div>'
                                                                                            .'<div class="form-group row justify-content-center ml-0 mt-0 mb-0">'
                                                                                                .'<label for="edicionreportes" class="col-form-label-sm">Prioridad</label>'
                                                                                                .'<div class="form-group col">'
                                                                                                    .'<select type="text" name="prioridad" class="form-control form-control-sm">'
                                                                                                      .'<option selected>' .$prioridad .'</option>'
                                                                                                      .'<option value="ALTA">ALTA</option>'
                                                                                                      .'<option value="MODERADA">MODERADA</option>'
                                                                                                      .'<option value="BAJA">BAJA</option>'
                                                                                                    .'</select>'
                                                                                                .'</div>'
                                                                                            .'</div>'
                                                                                            .'<div class="form-group row justify-content-center ml-0 mt-0 mb-0">'
                                                                                                .'<label for="edicionreportes" class="col-form-label-sm">Observaciones</label>'
                                                                                                .'<div class="form-group col">'
                                                                                                    .'<input type="text" name="observaciones" class="form-control form-control-sm" value="' .$observaciones .'" readonly>'
                                                                                                .'</div>'
                                                                                            .'</div>'
                                                                                            .'<br>'
                                                                                                .'<input type="submit" name="actualizar" class="btn btn-success btn-block" value="Actualizar reporte">'
                                                                                            .'</form>';                                                             

                                                                                
                                                                                ?>
                                                                                
                                                                            {label:  <?php echo "' " .$tarea ."'" ; ?> ,
                                                                            layer: L.circleMarker([ <?php echo $latitud; ?> , <?php echo $longitud; ?>], <?php echo $circuloopl; ?>)
                                                                            .bindPopup( '<b>Direccion: </b>' +<?php echo "'" .$direccion ."'"; ?> +'<br>'+
                                                                                        '<b>Hora: </b>' +<?php echo "'" .$hora ."'"; ?> +'<br>'+
                                                                                        '<b>Relevador: </b>' +<?php echo "'" .$relevador ."'"; ?> +'<br>')
                                                                            .on('click', function() {
                                                                            var primerId = document.querySelector('#informacion');  ////se crea la varaiable "primerId" y se enlaza con el "ID" de HTML llamado "titulo"
                                                                            primerId.innerHTML = <?php echo "'" .$informacion ."'" ; ?>; ////se le asigna a la variable "primerId" que traspase los nuevos datos por medio de la varaible "$informacion"
                                                                            var segundoId = document.querySelector('#editar');  ////se crea la varaiable "primerId" y se enlaza con el "ID" de HTML llamado "titulo"
                                                                            segundoId.innerHTML = <?php echo "'" .$editar ."'" ; ?>; ////se le asigna a la variable "primerId" que traspase los nuevos datos por medio de la varaible "$informacion"
                                                                            })},
                                                                            <?php } ?>
                                                                        ]
                                                                },
                                                        <?php } ?>
                                                        ]
                                                },
                                        <?php } ?>
                                     ]
                            },
                            <?php } ?>
                         
            ]
}

<?php } ?>

var lay = L.control.layers.tree(baseTree, overlaysTree,
{
    namedToggle: true,
    selectorBack: false,
    closedSymbol: '<i class="fas fa-folder text-info"></i>',
    openedSymbol: '<i class="fas fa-folder-open text-info"></i>',
    collapsed: false,
});

var control =  lay.addTo(map).collapseTree().expandSelected().collapseTree(true);
L.DomEvent.on(L.DomUtil.get('onlyselec'), 'click', function() {
    lay.collapseTree(true).expandSelected(true);
});

// Call the getContainer routine.
var htmlObject = control.getContainer();
// Get the desired parent node.
var a = document.getElementById('nuevo_objeto');

// Finally append that node to the new parent.
function setParent(el, newParent)
{
    newParent.appendChild(el);
}
setParent(htmlObject, a);
//////Capas en cascada, arbol//////// 
</script>