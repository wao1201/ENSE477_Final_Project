

function buildForm(){
    $.ajax({
	    type:"post",
		url: "../php/data.php",
		data: {action: 'get_common_name'},
		error: function(data){
		data = JSON.parse(data);
		alert("error: "+data);
	    }
	}).done(function(data){
		data = JSON.parse(data);

		var result = '<div class="filterForm"><fieldset><legend>Explore Sightings</legend><form id="filterForm">';
		result += '<label>Common Name: <select id="common_name">';
		result += '<option value="all">all</option>';
		for (i = 0; i < data.length; i++){
		    result += '<option value="'+data[i]+'">'+data[i]+'</option>';
		}
		result += '</select></label>';
		result += '<label>Sex: <select id="sex">';
		result += '<option value="all">All</option>';
		result += '<option value="male">Male</option>';
		result += '<option value="female">Female</option>';
		result += '</select></label>';
		result += '<label>User: <input type="text" name="username" id="username"></label>';
		result += '<label>Rating: <input type="number" id="rating" value="0"></label>';
		result += '<label>Start Date: <input type="text" id="start_date" placeholder="yyyy-mm-dd"></label>';
		result += '<label>End Date: <input type="text" id="end_date" placeholder="yyyy-mm-dd"></label>';
		result += '<label>Start Time: <input type="text" id="start_time" placeholder="hh:mm"></label>';
		result += '<label>End Time: <input type="text" id="end_time" placeholder="hh:mm"></label>';
		result += '<button type="button" id="download">Download as CSV</button>';
		result += '<input type="submit" value="submit" style="margin-left:10px;">';
		result +='</form></fieldset></div>';
		$('#filterFormDiv').html(result);    
		$('#download').hide();
		//		buildSubmit();
		//submit	
		$("#filterForm").submit(function(){
			var common_name = $("#common_name").val();
			var sex = $("#sex").val();
			var rating = $("#rating").val();
			var start_date;
			var end_date;
			var start_time;
			var end_time;
			var user;

			var date_pat=/^(19|20)\d\d[- /.](0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])$/;
			var time_pat=/^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5]?[0-9]$/;
			
			if ($("#username").val() != ''){
			    user = $("#username").val();
			}
			if ($("#start_time").val() != ''){
			    start_time = $("#start_time").val();
			    if(!time_pat.test(start_time)){
				alert("Start time invalid.  Follow form 'yyyy-mm-dd'");
				return false;
			    }
			}
			if ($("#start_date").val() != ''){
			    start_date = $("#start_date").val();
			    if (!date_pat.test(start_date)){
				alert("Start date invalid.  Follow form 'hh:mm'");
				return false;
			    }
			}
			if ($("#end_time").val() != ''){
			    end_time = $("#end_time").val();
			    if (!time_pat.test(end_time)){
				alert("End Time invalid.  Follow form 'hh:mm'");
				return false;
			    }
			}
			if ($("#end_date").val() != ''){
			    end_date = $("#end_date").val();
			    if (!date_pat.test(end_date)){
				alert("End Date invalid.  Follow form 'yyyy-mm-dd'");
				return false;
			    }
			}

			$.ajax({
				type:"post",
				    url: "../php/data.php",
				    data: {action: 'get_data', common_name: common_name, sex: sex, user: user, rating: rating, start_date: start_date, end_date: end_date, start_time: start_time, end_time: end_time},
				    error: function(data){
				    //				    data = JSON.parse(data);
				    console.log(data);
				    alert("error: You query filters are proabably too broad, please revise them and try again: "+data);
				    return false;
				}
			    }).done(function(data){
				    //Functions are not being called from in here for some reason.
				    //likly an issue with nested calls
				    //				    console.log(data);
				    $("#download").show();
				    data = JSON.parse(data);
				    useData(data);//each page.js in Explore has a unique implementation of this function to work with the data separatly.
				});
			return false;	
			
		    });//Submit Event Handler	
		$("#download").click(function(e){
			$.ajax({
				type:"post",
				    url: "../php/data.php",
				    data: {action: 'download_CSV'}
			    }).done(function(data){
				    if (data != 'false'){
					console.log("here"+data);
					e.preventDefault();
					data = JSON.parse(data);
					window.location.href = data;
				    } else {
					alert("We appologise for the inconvenience, but you must sign in to download data");
				    }
				    return false;
				});
			return false;
		    });
		
	    });
}
