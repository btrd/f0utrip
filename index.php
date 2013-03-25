<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>f0utrip</title>
		<link rel="stylesheet" href="leaflet-0.5/leaflet.css" />
		<!--[if lte IE 8]>
			<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.5/leaflet.ie.css" />
		<![endif]-->
		<style type="text/css">
			html, body {
				margin :0;
				padding: 0;
				height: 100%;
			}
			#map {
				height:100%
			}
		</style>
	</head>
	<body>
		<div id="map"></div>
		<script src="leaflet-0.5/leaflet.js"></script>
		<script>
			function diffdate(d1,d2){
				var WNbJours = d2.getTime() - d1.getTime();
				return Math.ceil(WNbJours/(1000*60*60*24));
			}

			//url de "l'api" OSM
			var osmUrl='http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';

			var osmAttrib='<a href="http://openstreetmap.org">OpenStreetMap</a>';

			var maPos = new L.LatLng(46.7925, -71.185);

			var Date1 = new Date();
			var Date2 = new Date(2013,6,4);

			var nbrJrRest = diffdate(Date1,Date2);

			var map = new L.Map('map');

			function onLocationFound(e) {
				initmap(e.latlng);
			}
			map.on('locationfound', onLocationFound);

			function onLocationError(e) {
			    document.getElementById('map').innerHTML=e.message;
			}

			map.on('locationerror', onLocationError);

			map.locate();

			function initmap(taPos) {
				//à supprimer
				//taPos = new L.LatLng(50, 50);

				//calcul de la distance entre les 2pts
				dist = taPos.distanceTo(maPos).toFixed(0);

				var latlngs = new Array(maPos, taPos);
				//Rajoute un polyline
				var pll = L.polyline(latlngs, {color: 'red'}).addTo(map);

				//Rajoute un popup au centre du polyline
				var txt = dist+"m nous separent =(<br/>Ne t'en fais pas je rentre dans "+nbrJrRest+" jours !";
				latlngpll = pll.getBounds().getCenter();
				var popup = L.popup().setLatLng(latlngpll).setContent(txt).openOn(map);

				//Clic sur le polyline ouvre le popup
				pll.on('click', function(e) {
				    popup.openOn(map);
				});

				//Marque maPos
				txt = "Je suis là !";
				L.marker(maPos,{title: txt}).addTo(map).bindPopup(txt);

				//Marque taPos et affiche la disante et le nbjr de jour
				txt = "Tu es là !";
				L.marker(taPos,{title: txt}).addTo(map).bindPopup(txt);
				
				//Rajoute l'échèlle
				L.control.scale({imperial:false}).addTo(map);

				//centre la carte sur la polyline
				map.fitBounds(pll.getBounds());

				//on centre la carte sur un point
				//map.setView([51.505, -0.09], 2);

				var osm = new L.TileLayer(osmUrl, {minZoom: 2, maxZoom: 18, attribution: osmAttrib});
				map.addLayer(osm);
			}
		</script>
	</body>
<html>