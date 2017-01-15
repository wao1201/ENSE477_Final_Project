$(document).ready(function(){
	buildForm();
    });//Document ready

//Format of data(common_name, time, date, sex, status, description, age, image, user)
function useData(data){
    //Clear all current graphs
    $("#sexBar").empty();
    $("#animalBar").empty();
    $("#line").empty();

    var sex = [];
    var sdata = [];
    var animals = [];
    var adata = [];
    var date = [];
    var ddata = [];
    
    //Process data into usable form of the new variables created above
    for (var i = 0; i < data.length; i++){
	//count animals
	var pos = animals.indexOf(data[i][0]);
	if (pos == -1){
	    animals.push(data[i][0]);
	    pos = animals.indexOf(data[i][0]);
	    adata.push(0);
	}
	adata[pos]++;
	//count sex
	pos = sex.indexOf(data[i][3]);
	if (pos == -1){
	    sex.push(data[i][3]);
	    pos = sex.indexOf(data[i][3]);
	    sdata.push(0);
	}
	sdata[pos]++;
	//Line Graph work
	var d = new Date(data[i][2]);
	var newD = new Date;
	newD.setMonth(d.getMonth());
	newD.setFullYear(d.getFullYear());
	newD.setHours(0,0,0,0);
	//	pos = date.indexOf(newD);
	pos = comp_date(date, newD);
	if (pos == -1){
	    date.push(newD);
	    pos = date.indexOf(newD);
	    ddata.push(0)
	}
	ddata[pos]++;
	console.log(pos);
	console.log(ddata);
	console.log(date);
   }

    if(animals.length == 1){
	build_line(ddata, date);
    } else if(animals.length > 1){
	build_animal_bar(adata, animals);
    }
    if(sex.length > 1){
	build_sex_bar(sdata, sex);
    }
    console.log("end");
}

function comp_date(d1, d2){
    for (var i = 0; i < d1.length; i++){
	if (d1[i].getTime() == d2.getTime()){
	    return i;
	}
    }
    return -1;
}

function build_line(data, name){
    $(function () {
    	    var d = [];
	    for(var i = 0; i < data.length; i++){
		d.push(Array(name[i].getTime(), data[i]));
		//d.push(Array(data[i], name[i].getTime()));
		//d.push(Array(name[i].getTime(), 2));
	    }

	    //Sorts 2D array by date
	    d = d.sort(function(a, b){
		    var r = new Date(a[0]) - new Date(b[0]);
		    return r;
	    	});
	    
    $('#line').highcharts({
            chart: {
		type: 'spline'
		    },
		title: {
                text: 'Volume of Reported Sightings over Time'
		    },
		xAxis: {
                type: 'datetime',
		    dateTimeLabelFormats: {
		    month: '%Y-%b'
			}

            },
		yAxis: {
                title: {
                    text: 'Number of Reported Sightings'
			},
		    min: 0
		    },
		series: [{
		    name: 'Reported Sightings per Week',
			data: d
			}]
		});
	});
}

function build_sex_bar(data, names){

    $('#sexBar').highcharts({
	    chart: {
		type: 'bar'
		    },
		title: {
		text: 'Gender Distribution'
		    },
		legend: {
		enabled: false
		    },
		xAxis: {
		categories: names
		    },
		yAxis: {
		title: {
		    text: 'Number of Sightings'
			}
	    },
		exporting: {
		enabled: true
		    },
		series: [{
		    data: data
			}],
		});
}


function build_animal_bar(data, names){
    $('#animalBar').highcharts({
	    chart: {
		type: 'bar'
		    },
		title: {
		text: 'Reported Animal Sightings'
		    },
		legend: {
		enabled: false
		    },
		xAxis: {
		categories: names
		    },
		yAxis: {
		title: {
		    text: 'Number of Sightings'
			}
	    },
		exporting: {
		enabled: true
		    },
		series: [{
		    data: data
			}],
		});
}

//May not need
//Taken from: http://stackoverflow.com/questions/1152024/best-way-to-generate-a-random-color-in-javascript
function rand_colour(){
    return '#' + (0x1000000 + Math.random() * 0xFFFFFF).toString(16).substr(1,6);
}