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

</script>