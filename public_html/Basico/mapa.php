
<!DOCTYPE html>
<html lang="es_ES">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Argentseal</title><!--titulo de pestaña-->
  <!--Bootstrap 4-->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <!--Bootstrap 4-->
  <!--- Font Awesome 5----->
  <link href="/fontawesome/css/all.css" rel="stylesheet"> 
  <!--- Font Awesome 5----->
<!-- Mapa -->
  <!-----CDN Leaflet----->
  <script src="/ATC/plugin/Leaflet-1.7.1/dist/leaflet.js"></script>
  <link rel="stylesheet" href="/ATC/plugin/Leaflet-1.7.1/dist/leaflet.css"/>
  <!-----CDN Leaflet----->
  <script src="https://maps.googleapis.com/maps/api/js" type="text/javascript"></script>
  <!-----LAYER TREE----->
  <link rel="stylesheet" href="/ATC/plugin/TreeMaster/L.Control.Layers.Tree.css" crossorigin=""/>
  <script src="/ATC/plugin/TreeMaster/L.Control.Layers.Tree.js"></script>
  <!-----LAYER TREE----->
  <!-----FULLSCREEN----->
  <script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/Leaflet.fullscreen.min.js'></script>
  <link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/leaflet.fullscreen.css' rel='stylesheet' />
  <!-----FULLSCREEN----->
  <!-----markercluster----->
  <link rel="stylesheet" href="../../ATC/plugin/markercluster/dist/MarkerCluster.css" />
  <link rel="stylesheet" href="../../ATC/plugin/markercluster/dist/MarkerCluster.Default.css" />
  <script src="https://unpkg.com/leaflet.markercluster@1.1.0/dist/leaflet.markercluster.js"></script>
  <!-----markercluster-----> 
  <!-----CDN Omnivore----->
  <script src='//api.tiles.mapbox.com/mapbox.js/plugins/leaflet-omnivore/v0.3.1/leaflet-omnivore.min.js'></script>
  <!-----CDN Omnivore----->
  <!-----CDN lector KML previo----->
  <script src="https://unpkg.com/togeojson@0.16.0"></script>
  <script src="https://unpkg.com/leaflet-filelayer@1.2.0"></script>
  <!-----CDN lector KML previo----->
  <!----PRINT---->
  <script src="../../ATC/plugin/print/dist/leaflet.browser.print.min.js"></script>
  <!----PRINT---->
  <!----PolylineMeasure---->
  <link rel="stylesheet" href="../../ATC/plugin/polylinemeasure/Leaflet.PolylineMeasure.css" />
  <script src="../../ATC/plugin/polylinemeasure/Leaflet.PolylineMeasure.js"></script>
  <!----PolylineMeasure---->
  <!----Geocoder---->
  <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder@2.3.0/dist/Control.Geocoder.css" />
  <script src="https://unpkg.com/leaflet-control-geocoder@2.3.0/dist/Control.Geocoder.js"></script>
  <!----Geocoder---->
  <!-- Mapa -->
  <!----Timepicker---->
  <link rel="stylesheet" type="text/css" href="../../clockpicker.css">
  <!----Timepicker---->

  <link rel="shortcut icon" href="https://www.argentseal.com.ar/vistas/images/favicon/favicon.ico" type="image/x-icon">
</head>
<body>
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
<div class="col-sm-9 col-xl-10" id="mapacol">
  <div id="map"></div>
</div>
<!-- PIE DE PAGINA -->
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<!-- then Popper -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<!-- Bootstrap -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<!------Plugin de los mapas------->
<script src="../ATC/plugin/js/leaflet-control-geocoder.Geocoder.js"></script>
<script src="../ATC/plugin/js/leaflet-search.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@[VERSION]/dist/L.Control.Locate.min.css" />
<script src="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@[VERSION]/dist/L.Control.Locate.min.js" charset="utf-8"></script>
<!------Plugin de los mapas------->
<script>
///comienzo de la pagina, agregado del mapa al ID map////////////
	var map = L.map('map').setView([-34.63338, -58.57216], 11); ///comienzo de la pagina
///comienzo de la pagina, agregado del mapa al ID map////////////

/////Mapas para las capas/////
	var mapabase= L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
	{attribution: '<a href="http://openstreetmap.org"></a>',
	minZoom: 3, ////zoom minimo////
	maxZoom: 18, ////zoom maximo////
	}).addTo(map);

	var monocromatico= L.tileLayer('http://{s}.tiles.wmflabs.org/bw-mapnik/{z}/{x}/{y}.png', {
	attribution: '<a href="http://www.openstreetmap.org/copyright"></a>',
	minZoom: 3, ////zoom minimo////
	maxZoom: 18, ////zoom maximo////
	}).addTo(map);

	var satelital= L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
	attribution: '<a href="http://www.openstreetmap.org/copyright"></a>',
	id: 'mapbox/satellite-streets-v11',
	minZoom: 3, ////zoom minimo////
	maxZoom: 18, ////zoom maximo////
	}).addTo(map);

	var oscuro= L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
	attribution: '<a href="http://www.openstreetmap.org/copyright"></a>',
	id: 'mapbox/dark-v10',
	minZoom: 3, ////zoom minimo////
	maxZoom: 18, ////zoom maximo////
	}).addTo(map);

	var transporte= L.tileLayer('https://tile.thunderforest.com/transport/{z}/{x}/{y}.png?apikey=dd1f2e5357094373a5dd6e1b32a38c3c', {
	attribution: '<a href="http://www.openstreetmap.org/copyright"></a>',
	minZoom: 3, ////zoom minimo////
	maxZoom: 18, ////zoom maximo////
	}).addTo(map);
/////Mapas para las capas/////
////GEOLOCALIZACION
////GEOLOCALIZACION
////capas///
var baseMaps =   //////////baseMaps RADIO BUTTON////////
{
"Satelital": satelital, /////nombre de la capa CAPA CONSTANTE/////
"Oscuro": oscuro, /////nombre de la capa CAPA CONSTANTE/////
"Transporte": transporte, /////nombre de la capa CAPA CONSTANTE/////	
"Monocormatico": monocromatico, /////nombre de la capa CAPA CONSTANTE/////
"Base": mapabase, /////nombre de la capa CAPA CONSTANTE/////	
};
var overlayMaps =   //////////overlayMapas CAPA APAGABLE////////
{
}; 

var layerswitcher= L.control.layers(baseMaps, overlayMaps,{collapsed:true}).addTo(map); /////switch de capas; colapsable//////
////capas///
///PANTALLA COMPLETA Y QUITAR BOTONES DE ZOMM//////
  map.addControl(new L.Control.Fullscreen({ position: 'bottomright' }));
	map.removeControl(map.zoomControl);
///PANTALLA COMPLETA Y QUITAR BOTONES DE ZOMM//////
///IMPRIMIR////
L.control.browserPrint({
		printModes: [L.control.browserPrint.mode.landscape('<i class="fas fa-arrows-alt-h"></i>'),
		L.control.browserPrint.mode.portrait('<i class="fas fa-arrows-alt-v"></i>'),
		L.control.browserPrint.mode.custom('<i class="fas fa-expand-arrows-alt"></i>')],
		position: 'bottomright',
		title: 'Selecciona como imprimir',
		documentTitle: 'Mapa relevamiento',
	}).addTo(map);
///IMPRIMIR////
/////GEOCODER/////
L.Control.geocoder({position:'topleft', placeholder:'Buscar...'}).addTo(map);
/////GEOCODER/////

////MEDIR/////
L.control.polylineMeasure(
	{position:'topleft',
	unit:'metres',
	showBearings:false,
	clearMeasurementsOnStop: false,
	showClearControl: true,
	tooltipTextMove: 'Toca y arrastra para <b>mover el punto</b><br>',
	tooltipTextDelete: 'Presiona SHIFT y toca para <b>borrar el punto</b>',
	tooltipTextResume: '<br>Presiona CTRL y toca para <b>continuar el trazado</b>',
	tooltipTextAdd: 'Presiona CTRL y toca para <b>agregar un punto</b>',
	currentCircle: {
        color: '#000',
        weight: 1,
        fillColor: '#fb5607', 
        fillOpacity: 1,
        radius: 3
    },
	clearControlTitle: 'Limpiar medidas',
	measureControlTitleOn: 'Comenzar a medir',
	measureControlTitleOff: 'Terminar de medir'}).addTo(map);
////MEDIR/////
</script>
</body>
</html>
