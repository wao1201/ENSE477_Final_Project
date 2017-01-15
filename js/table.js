$(document).ready(function(){

	buildForm();
	//	getData();	//Build Default table on load.  Removed beucase it was not consistent with graph or map page

    });//Document ready

function useData(data){
    console.log("useData");
    buildTable(data);
}

function getData(){
	    $.ajax({
		    type:"post",
			url: "../php/data.php",
			data: {action: 'get_data'},
			error: function(data){
			data = JSON.parse(data);
			alert("error:" +data);
		    }
		}).done(function(data){
			data = JSON.parse(data);
			buildTable(data);
		    });//Ajax done
}

function buildTable(data){
    console.log("build table");
    var result = '';
    if (data.length < 1){
	result += '<p>There are no entries associated with this account</p>';
	$('#table').html(result);
    } else {
	result += '<table id="dataTable" class="tablesorter">';
	result += '<thead><tr>';
	result += '<th>Common Name</th>';
	result += '<th>Time</th>';
	result += '<th>Date</th>';
	result += '<th>Sex</th>';
	result += '<th>Status</th>';
	result += '<th>Description</th>';
	result += '<th>Age</th>';
	result += '<th>Image</th>';
	result += '<th>User</th>';
	result += '</thead></tr>';
	result += '<tbody>';
	for (var i = 0; i < data.length; i++){
	    result += '<tr>';
	    for (var j = 0; j < data[i].length-6; j++){
		result += '<td>';
		if (j == data[i].length-8){
		    if (data[i][j] == null){
			result += "<div class='noImage'>No Image</div>";
		    } else {
			result += '<img src="'+data[i][j]+'" class="tableImage" style="">';
		    }
		} else if(j == 0){
		    result += '<a href="sighting.php?common_name='+data[i][0]+'&time='+data[i][1]+'&date='+data[i][2]+'&sex='+data[i][3]+'&status='+data[i][4]+'&description='+data[i][5]+'&age='+data[i][6]+'&image='+data[i][7]+'&user='+data[i][8]+'&sightingID='+data[i][9]+'&lat='+data[i][10]+'&lon='+data[i][11]+'&date_created='+data[i][12]+'&date_edited='+data[i][13]+'&edited_by='+data[i][14]+'">'+data[i][j]+'</a>';
		} else {
		    result += data[i][j];
		}
		result += '</td>';
	    }
	    result += '</tr>';
	}
	
	result += '</tbody>';
	result += '</table>';
	$('#table').html(result);
	$("#dataTable").tablesorter();
    }
}
