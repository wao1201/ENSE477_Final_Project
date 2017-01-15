$(document).ready(function(){

	buildForm();
	    
    function toggleHeatmap() {
	heatmap.setMap(heatmap.getMap() ? null : map);
    }
    
    function changeGradient() {
	var gradient = [
			'rgba(0, 255, 255, 0)',
			'rgba(0, 255, 255, 1)',
			'rgba(0, 191, 255, 1)',
			'rgba(0, 127, 255, 1)',
			'rgba(0, 63, 255, 1)',
			'rgba(0, 0, 255, 1)',
			'rgba(0, 0, 223, 1)',
			'rgba(0, 0, 191, 1)',
			'rgba(0, 0, 159, 1)',
			'rgba(0, 0, 127, 1)',
			'rgba(63, 0, 91, 1)',
			'rgba(127, 0, 63, 1)',
			'rgba(191, 0, 31, 1)',
			'rgba(255, 0, 0, 1)'
			]
	    heatmap.set('gradient', heatmap.get('gradient') ? null : gradient);
    }
    
    
    //    google.maps.event.addDomListener(window, 'load', initialize);



	
    });//Document ready

function initialize(coordinates) {
    var map, pointarray, heatmap;

    var mapOptions = {
	zoom: 11,
	center: new google.maps.LatLng(50.4547, -104.607),
	mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    
    map = new google.maps.Map(document.getElementById('map-canvas'),
			      mapOptions);
    
    //var pointArray = new google.maps.MVCArray(sightingData);
    var pointArray = new google.maps.MVCArray(coordinates);
    
    heatmap = new google.maps.visualization.HeatmapLayer({
	    data: pointArray
	});
    
    heatmap.set('radius', 10);
    
    heatmap.setMap(map);
}


function useData(data){
    console.log("useData");
    var result = [];
    for (var i = 0; i < data.length; i++){
	result.push(new google.maps.LatLng(data[i][10], data[i][11]));
    }

    initialize(result);
}
