$(document).ready(function(){
	$("#fileUpload").submit(function(){
		var file = $("#file").val();
		document.getElementById(file)
		alert(file);
	    });//Submit event handler
    });//Document ready