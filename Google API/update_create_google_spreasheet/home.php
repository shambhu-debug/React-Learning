<?php
session_start();

if(!isset($_SESSION['access_token'])) {
	header('Location: google-login.php');
	exit();	
}

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<style type="text/css">

#form-container {
	width: 400px;
	margin: 100px auto;
}

input[type="text"] {
	border: 1px solid rgba(0, 0, 0, 0.15);
	font-family: inherit;
	font-size: inherit;
	padding: 8px;
	border-radius: 0px;
	outline: none;
	display: block;
	margin: 0 0 20px 0;
	width: 100%;
	box-sizing: border-box;
}

.input-error {
	border: 1px solid red !important;
}

#create-spreadsheet {
	background: none;
	width: 100%;
    display: block;
    margin: 0 auto;
    border: 2px solid #2980b9;
    padding: 8px;
    background: none;
    color: #2980b9;
    cursor: pointer;
}

</style>
</head>

<body>

<div id="form-container">
	<input type="text" id="spreadsheet-title" placeholder="Spreadsheet Title" autocomplete="off" />
	<button id="create-spreadsheet">Create Spreadsheet</button>
</div>

<script>

// Send an ajax request to create spreadsheet
$("#create-spreadsheet").on('click', function(e) {
	var blank_reg_exp = /^([\s]{0,}[^\s]{1,}[\s]{0,}){1,}$/;

	$(".input-error").removeClass('input-error');

	if(!blank_reg_exp.test($("#spreadsheet-title").val())) {
		$("#spreadsheet-title").addClass('input-error');
		return;
	}

	$("#create-spreadsheet").attr('disabled', 'disabled');
	$.ajax({
        type: 'POST',
        url: 'ajax.php',
        data: { spreadsheet_title: $("#spreadsheet-title").val() },
        dataType: 'json',
        success: function(response) {
        	$("#create-spreadsheet").removeAttr('disabled');
        	alert('Spreadsheet created in Google Drive with with ID : ' + response.spreadsheet_id);
        },
        error: function(response) {
            $("#create-spreadsheet").removeAttr('disabled');
            alert(response.responseJSON.message);
        }
    });
});

</script>

</body>
</html>