<?php include("../../db.php"); ?>
<?php include('../includesatc/headeratc.php'); ?>



<style>
#map { 
width: 100%;
height: 100%;
}
#cont {
width: 100%;
height: 1500px;
}
#multi { 
width: 100%;
height: 1900px;
}
#conten { 
overflow-y: auto;
max-height: 450px; /*alto de la tabla*/
}
#profile { 
height: 450px; /*alto de la tabla*/
}
#contact { 
height: 450px; /*alto de la tabla*/
}
#tablaacro {  
overflow-y:auto; 
}
</style>

<div class="container-fluid" >
    <div class="row" id="cont">
    <div class="col-lg-9 col-md-9 p-0 "> 
      <div class="p-1" id='map'></div>
    </div>    
      <div class="col-lg-3 col-md-3" id="multi"> 

        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item col">
            <a class="nav-link active text-center" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true"><i class="fas fa-map-marker-alt text-info"></i></a>
          </li>
          <li class="nav-item col">
            <a class="nav-link text-center" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false"><i class="fas fa-map text-info"></i></a>
          </li>
          <li class="nav-item col">
            <a class="nav-link text-center" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false"><i class="fas fa-ellipsis-v text-info"></i></a>
          </li>
        </ul>
               
        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active bg-white" id="home" role="tabpanel" aria-labelledby="home-tab">
            <div class="row justify-content-center" >
              <div class="container-fluid" id="conten">
            <table class="table-bordered table-hover table-md" id="tablaacro">
              <thead>
                <tr>
                  <th>Acronimo</th>
                </tr>
              </thead>
              <tbody id="t_points"></tbody>
            </table>
            </div>
          </div>
          </div>
          <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            CASA----
          </div>
          <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
            <form action="../Guardar/save_altas.php" method="POST">
              <div class="form-row">
                <div class="form-group col">
                  <label for="exampleFormControlSelect1">Direccion</label >
                  <input type="text" name="direccion" maxlength="80"  class="form-control" placeholder="Ingrese una direccion" autofocus required>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col">
                  <label for="exampleFormControlSelect1">Acronimo</label >
                  <input type="text" name="acronimo" maxlength="80"  class="form-control" placeholder="Ingrese una direccion" autofocus required>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col">
                  <label for="exampleFormControlSelect1">Lat</label >
                  <input type="text" name="lat" maxlength="80"  class="form-control" placeholder="Ingrese una direccion" autofocus required>
                </div>
              
                <div class="form-group col">
                  <label for="exampleFormControlSelect1">Lon</label >
                  <input type="text" name="lon" maxlength="80"  class="form-control" placeholder="Ingrese una direccion" autofocus required>
                </div>
              </div>
            </form>
          </div>
        </div>
        </div> 
      </div>
    </div>
<br>

<div class="container p-5">
  <div class="row justify-content-center">    
      <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Ver reportes</button>
  </div>
</div>

<div class="collapse" id="collapseExample">
  <div class="card card-body">




<style>
table{ table-layout: fixed; }

#contenedor{
  overflow-x: auto;
  height: 1200px;
  width: 900px;
}


#tabla{
  min-width: 900px;  
  overflow-x:auto; 
}

#fecha{ min-width: 100px; }
#acronimo{ min-width: 145px; }
#direccion{ min-width: 250px; }
#calle{ min-width: 180px; }
#obs{ min-width: 400px; }

/*La propiedad overflow: auto la utilizo para que, en caso de ser necesario el scroll, este aparezca automáticamente. También podrías usar overflow-x para hacer referencia solamente al scroll horizontal o overflow-y para hacer referencia al scroll vertical.

Este es tu ejemplo modificado. Le he puesto un borde a cada una de las cabeceras de columnas (th) para que se pueda ver que todas tienen el mismo tamaño.
CSS
.size{
  width: 330px;
}
<th><div class="size"> I.E.</div></th>*/
</style>




  <div class="row justify-content-center">    
      <p class="h4 mb-4 text-center">Reportes</p>
  </div>
  <div class="container-fluid" id="contenedor">    
        <table class="table table-striped  table-bordered table-sm" id="tabla">
          <thead class="thead-dark text-center">
            <tr>
              <th id="fecha">Fecha</th>              
              <th id="acronimo">Acronimo</th>
              <th id="direccion">Direccion</th>
              <th id="calle">Calle y altura</th>
              <th>Rotulada</th>
              <th>Tipo</th> 
              <th>Conectados</th>           
              <th>Latitud</th>
              <th>Longitud</th>
              <th>Fleje faltante</th>
              <th>Trabas dañadas</th>
              <th>Splitter dañados</th>
              <th>Prioridad</th>
              <th id="obs">Observaciones</th>
            </tr>
          </thead>
          <tbody align="center">

            <?php
            $query = "SELECT * FROM reportevl ORDER BY fecha desc LIMIT 20";
            $result_tasks = mysqli_query($conn, $query);    

            while($row = mysqli_fetch_assoc($result_tasks)) { ?>
              <tr>
                <td><?php echo $row['fecha']; ?></td>                
                <td><?php echo $row['acronimo']; ?></td>
                <td><?php echo $row['direccion']; ?></td>
                <td><?php echo $row['callealtura']; ?></td>
                <td><?php echo $row['rotulada']; ?></td>
                <td><?php echo $row['tipo']; ?></td>
                <td><?php echo $row['cant_drop']; ?></td>
                <td><?php echo $row['latitud']; ?></td>
                <td><?php echo $row['longitud']; ?></td>
                <td><?php echo $row['fleje']; ?></td>
                <td><?php echo $row['trabas']; ?></td>
                <td><?php echo $row['splitter_conectores'];; ?></td>
                <td><?php echo $row['prioridad']; ?></td>
                <td><?php echo $row['obs']; ?></td>                            
              </tr>
            <?php } ?>
          </tbody>
        </table>
      
    
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


<!-- Mapa -->
<script src="https://unpkg.com/leaflet-geosearch@3.0.0/dist/geosearch.umd.js"></script>
<script>

var map = L.map('map').setView([-34.5202867, -58.5264617],13); /////coordenadas del inicio del mapa//////

var mapabase= L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{attribution: '<a href="http://openstreetmap.org">OpenStreetMap</a>',
minZoom: 3, ////zoom minimo////
maxZoom: 17, ////zoom maximo////
}).addTo(map);

var mapanegro= L.tileLayer('http://{s}.tiles.wmflabs.org/bw-mapnik/{z}/{x}/{y}.png', {
attribution: '<a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
minZoom: 3, ////zoom minimo////
maxZoom: 17, ////zoom maximo////
}).addTo(map);


////////Buscador////////


// const provider = new GeoSearch.OpenStreetMapProvider();
// const search = new GeoSearch.GeoSearchControl({
//   provider: new GeoSearch.OpenStreetMapProvider(),
//   style: 'bar', // optional: bar|button  - default button
//   showMarker: true, // optional: true|false  - default true
//   showPopup: true, // optional: true|false  - default false
//    marker: {
//     // optional: L.Marker    - default L.Icon.Default
//     icon: new L.Icon.Default(),
//     draggable: false,
//   },
//   popupFormat: ({ query, result }) => result.label, // optional: function    - default returns result label,
//   resultFormat: ({ result }) => result.label, // optional: function    - default returns result label
//   maxMarkers: 1, // optional: number      - default 1
//   retainZoomLevel: false, // optional: true|false  - default false
//   animateZoom: true, // optional: true|false  - default true
//   autoClose: true, // optional: true|false  - default false
//   searchLabel: 'Busca la direccion', // optional: string      - default 'Enter address'
//   keepResult: false, // optional: true|false  - default false
//   updateMap: true, // optional: true|false  - default true
// }).addTo(map);



////////Buscador////////



////L.marker([-34.752549,-58.422083],{draggable: true}).addTo(map);/// coordenadas de las marcas/////

function addRowTable(code, coords){
  var tr = document.createElement("tr");
  var td = document.createElement("td");                
  td.textContent = code;
  tr.appendChild(td);
  tr.onclick = function(){map.flyTo(coords, 17);};
  document.getElementById("t_points").appendChild(tr);

}



var buffers = [];
function addMarker(code,lat,lng,nombre){
  var p = L.marker([lat,lng]);
  p.title = code;
  p.alt = code;
  p.bindPopup(code);
  p.addTo(map);               
  addRowTable(nombre, [lat,lng]);
  var c = L.circle([lat,lng], {}).addTo(map);
  buffers.push(c);
}

$(document).ready(function (){
  var points = [
                  <?php
                  $query= "SELECT * FROM reportevl"; 
                  $result = mysqli_query($conn, $query);
                  while($row = mysqli_fetch_assoc($result))
                  {
                    $latitud = $row['latitud'];
                    $longitud = $row['longitud'];
                    $direccion = $row['direccion'];
                    $fecha = $row['fecha'];
                    $acronimo = $row['acronimo'];
                    echo "[" .'"<p>Acronimo: ' .$acronimo .'<br>Direccion: ' .$direccion .'<br>Fecha: ' .$fecha .'<br>Latitud: ' .$latitud .'<br>Longitud: ' .$longitud .'</p>"'  .", $latitud , $longitud],";
                  } ?>
                ];
  var tabla = [
                  <?php
                  $query= "SELECT * FROM reportevl"; 
                  $result = mysqli_query($conn, $query);
                  while($row = mysqli_fetch_assoc($result))
                  {
                    $latitud = $row['latitud'];
                    $longitud = $row['longitud'];
                    $direccion = $row['direccion'];
                    $acronimo = $row['acronimo'];
                    echo "[" .'"' .$acronimo .'"'  ."],";
                  } ?>
                ];
  for (var i=0; i < points.length; i++){
    addMarker(points[i][0],points[i][1],points[i][2],tabla[i][0]);
  }
});




////cargar archivos GML///
var style = {
            color: 'blue',
            opacity: 0.6,
            fillOpacity: 1.0,
            weight: 1.5,
            clickable: false
            };
L.Control.FileLayerLoad.LABEL = '<i class="far fa-folder-open"></i>';  ////icono cargar archivo////
var control = L.Control.fileLayerLoad(
{      
  layer: L.geoJson,        
  layerOptions: {
          style: style,
          pointToLayer: function (data, latlng) {
              return L.circleMarker(
                  latlng,
                  { style: style }
              );
          }
      },       
  addToMap: true, ///agregar al mapa///        
  fileSizeLimit: 1024, ////maximo tamaño del archivo///       
  formats: [
            '.geojson', /////formatos/////
            '.gpx',  /////formatos/////
            '.kml'  /////formatos/////
            ]
}).addTo(map);

control.loader.on('data:loaded', function (event) {   
layerswitcher.addOverlay(event.layer, event.filename); ////agrega una capa si la subida es exitosa////
});

control.loader.on('data:error', function (error) {
alert(error.error.message);
});
////cargar archivos GML///

////capas///
var baseMaps =
{
"Mapa base": mapabase,
"Mapa oscuro": mapanegro,
};
var overlayMaps = {};
var layerswitcher= L.control.layers(baseMaps, overlayMaps,{collapsed:true}).addTo(map); 
////capas///

L.control.polylineMeasure({position:'topleft', imperial:false, clearMeasurementsOnStop: false, showMeasurementsClearControl: true}).addTo(map);

$("#range").change(function(e){
  var radius = parseInt($(this).val())
  buffers.forEach(function(e){
    e.setRadius(radius);
    e.addTo(map);
  });
});
</script>

</body>
</html>