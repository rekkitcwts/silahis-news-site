var baseurl = '127.0.0.1/silahis-news-site';

function loginCheck()
{
	var staff_username = $('#username').val();
	var staff_password = $('#password').val();
	// alert(staff_username + ', ' + staff_password);
	$.ajax({
		url: './backend/silahis_login.php',
		type: "POST",
		data: {
			username: staff_username,
			password: staff_password
		},
		dataType: "json",
		async: true,
		success: function(response)
		{
			//alert(response);
			if (response.result == "AUSTRALIA")
			{
				// PLACEHOLDER
				//alert('OK!');
				$("p#loginError").text('');
				if ((response.position == "Adviser") || (response.position == "Editor-In-Chief"))
					window.location = 'adminpanel.php';
				else if ((response.position == "News Editor") || (response.position == "Feature Editor") || (response.position == "Associate Editor"))
					window.location = 'editor_dashboard.php';
				else if ((response.position == "News Writer") || (response.position == "Feature Writer"))
					window.location = 'writer_dashboard.php';
			}
			else
			{
				$("p#loginError").text('Login Error.');
			}
		},
		error: function()
		{
			alert('I don\'t hate you.');
		}
	})
}

// Validation functions
	// Default, from Head First JavaScript
    function validateRegEx(regex, input, helpText, helpMessage) 
	{
        // See if the input data validates OK
		if (!regex.test(input)) 
		{
          // The data is invalid, so set the help message and return false
			if (helpText != null)
				helpText.innerHTML = helpMessage;
			return false;
        }
        else 
		{
			// The data is OK, so clear the help message and return true
			if (helpText != null)
				helpText.innerHTML = "";
			return true;
        }
    }

      function validateNonEmpty(inputField, helpText) 
	  {
        // See if the input value contains any text
        return validateRegEx(/.+/,
          inputField.value, helpText,
          "<i>Please enter a value.</i>");
      }

      function validateLength(minLength, maxLength, inputField, helpText) {
        // See if the input value contains at least minLength but no more than maxLength characters
        return validateRegEx(new RegExp("^.{" + minLength + "," + maxLength + "}$"),
          inputField.value, helpText,
          "Please enter a value " + minLength + " to " + maxLength +
          " characters in length.");
      }

      function validateZipCode(inputField, helpText) {
        // First see if the input value contains data
        if (!validateNonEmpty(inputField, helpText))
          return false;

        // Then see if the input value is a ZIP code
        return validateRegEx(/^\d{5}$/,
          inputField.value, helpText,
          "Please enter a 5-digit ZIP code.");
      }

      function validateDate(inputField, helpText) {
        // First see if the input value contains data
        if (!validateNonEmpty(inputField, helpText))
          return false;

        // Then see if the input value is a date
        return validateRegEx(/^\d{2}\/\d{2}\/(\d{2}|\d{4})$/,
          inputField.value, helpText,
          "Please enter a date (for example, 01/14/1975).");
      }

      function validatePhone(inputField, helpText) {
        // First see if the input value contains data
        if (!validateNonEmpty(inputField, helpText))
          return false;

        // Then see if the input value is a phone number
        return validateRegEx(/^\d{3}-\d{3}-\d{4}$/,
          inputField.value, helpText,
          "Please enter a phone number (for example, 123-456-7890).");
      }

      function validateEmail(inputField, helpText) {
        // First see if the input value contains data
        if (!validateNonEmpty(inputField, helpText))
          return false;

        // Then see if the input value is an email address
        return validateRegEx(/^[\w\.-_\+]+@[\w-]+(\.\w{2,3})+$/,
          inputField.value, helpText,
          "Please enter an email address (for example, reimuhakurei@gmail.com OR kureido@donutfortress.com.au).");
      }
	  
	// SILAHIS - Custom validation functions that use the above functions
	function validateTwoPasswordFields(passwordField1, passwordField2, minPwdLength, maxPwdLength, helpText)
	{
		console.log(passwordField1);
		console.log(passwordField2);
		if ((!validateNonEmpty(passwordField1, helpText)) && (!validateNonEmpty(passwordField2, helpText)))
			return false;
		if (!validateLength(minLength, maxLength, passwordField1, helpText) || !validateLength(minLength, maxLength, passwordField2, helpText))
			return false;
		
		return (passwordField1.value == passwordField2.value);
	}	

function addStudentToEditorialBoard()
{
	var idno = $('#idnoHidden').val();
    var positionID = $('select#positionDesired').val();

    if (idno != "")
    {
    	$.ajax({
			url: './backend/silahis_newuser.php',
			type: "POST",
			data: {
				idnumber: idno,
				position_id: positionID
			},
			dataType: "text",
			async: true,
			success: function(response)
			{
				alert('New staff member successfully added.');
				if (response == "AUSTRALIA")
				{
					$("#students").dataTable().fnDraw();
					$('#curstaffs').dataTable().fnDraw();
					$('p#idno').text('Waiting...');
    				$('#idnoHidden').val('');
				}
			},
			error: function()
			{
				alert("Something went wrong.");
			}
		});
    }
    else
    {
    	alert('WARNING: No ID number');
    }
}

function showRemoveArticleModal(articleID)
{
	$('#articleIDhidden').val(articleID);
	
	// Show the modal!
	$('#articleRemoveDialog').modal('show');
}

function removeArticle()
{
	var articleID = $("#articleIDhidden").val();
	$.ajax({
		url: './backend/silahis_removearticle.php',
		type: "POST",
		data: {
			article_id: articleID
		},
		dataType: "text",
		async: true,
		success: function(response)
		{
			// this is only temporary
			//alert(response);
			if (response == "ARTICLE_REMOVED")
				location.reload();
		}
	});
}

function showStudentProfile()
{
	var idno = $(this).attr('data-idno');
	var inlineText = '';
    $.ajax({
    	url: './backend/silahis_getstudentprofile.php',
    	type: "POST",
    	data: {
    		idno: idno
    	},
    	dataType: "json",
    	async: true,
    	beforeSend: function()
    	{
    		$('p#idno').text('Loading, please wait...');
    	},
    	success: function(response)
    	{
    	//	alert(JSON.stringify(response));
    	//	$('p#idno').text(JSON.stringify(response));
    		inlineText += 'ID No.: ' + response.idno + '<br />';
    		inlineText += 'Name: ' + response.lname + ', ' + response.fname + '<br />';
    		inlineText += 'Course: ' + response.course + '<br />';
    		$('p#idno').html(inlineText);
    		$('#idnoHidden').val(response.idno);
    	},
    	error: function()
    	{
    		alert('Sum Ting Wong');
    	}
    });
}

function getSemesterByMonth(dateObject, calendarShift)
{
	// Future-proofing this function since we don't know if the calendar shift will push through
	calendarShift = (typeof optionalArg === "undefined") ? false : calendarShift;
	var firstSemMonths = [];
	var secondSemMonths = [];
	if (calendarShift == false)
	{
		firstSemMonths = [5,6,7,8,9];
		secondSemMonths = [10,11,0,1,2];
	}
	else
	{
		firstSemMonths = [7,8,9,10,11];
		secondSemMonths = [0,1,2,3,4];
	}

	var monthToSearch = dateObject.getMonth(); 
	if(firstSemMonths.indexOf(monthToSearch) > -1)
	{
		return '1st Semester';
	}
	if(secondSemMonths.indexOf(monthToSearch) > -1)
	{
		return '2nd Semester';
	}
	else
	{
		return 'Summer';
	}
}

function clearConfirmArea()
{
	$('div#staffConfirmationQuestion').html('');
	$('div#staffConfirmationChoices').html('');
}

function showStaffProfile()
{
	var idno = $(this).attr('data-staffidno');
	var inlineText = '';
	var startYear = '';
	var endYear = '';
	var startDate;
	var endDate;

    $.ajax({
    	url: './backend/silahis_getstaffprofile.php',
    	type: "POST",
    	data: {
    		idno: idno
    	},
    	dataType: "json",
    	async: true,
    	beforeSend: function()
    	{
    		$('p#staffProfileArea').text('Loading, please wait...');
    		clearConfirmArea();
    	},
    	success: function(response)
    	{
    		inlineText += 'ID No.: ' + response.idno + '<br />';
    		inlineText += 'Name: ' + response.lname + ', ' + response.fname + '<br />';
    		inlineText += 'Course: ' + response.course + '<br />';
    		inlineText += 'Status: ' + response.is_active + '<br />';
    		inlineText += 'Current Position: ' + response.curposition + '<br /><br />';
    		inlineText += 'Position History<br />';
    		for (i = 0; i < response.positions.length; i++)
    		{
    			startDate = new Date(response.positions[i].startdate);
    			endDate = new Date(response.positions[i].enddate);
    			startYear = startDate.getFullYear();
    			endYear = endDate.getFullYear();
    			inlineText += '<strong>' + response.positions[i].position_name + '</strong><br />';
    			inlineText += startYear + ' (' + getSemesterByMonth(startDate) + ')&mdash;';
    			if (endYear == 1970)
    			{
    				inlineText += 'present';
    				inlineText += '<br />';
    				inlineText += '<br />';
    				inlineText += '<button class="btn btn-danger btn-sm staffterm" data-staffidno="' + response.idno + '">End Term</button>&nbsp;';
    				inlineText += '<button class="btn btn-success btn-sm extendterm" data-staffidno="' + response.idno + '">Extend Term (different position)</button>';
    			}
    			else
    			{
    				inlineText += endYear + ' (' + getSemesterByMonth(endDate) + ')';
    				if (((response.positions.length) - i) == 1)
    				{
    					inlineText += '<br />';
    					inlineText += '<br />';
    					inlineText += '<button class="btn btn-success btn-sm readdstaff" data-staffidno="' + response.idno + '">Add to Editorial Board</button>';
    				}
    			}
    			inlineText += '<br />';
    			inlineText += '<br />';
    		//	inlineText += JSON.stringify(response.positions[i]) + '<br />';
    		}
    //		inlineText += '<button class="btn btn-danger">End Term</button>';
    		$('p#staffProfileArea').html(inlineText);
    		$('#idnoStaffHidden').val(response.idno);

    	},
    	error: function()
    	{
    		alert('Sum Ting Wong');
    	}
    });
}

function generateStudentList()
{
	var tableBody = "";

	$.ajax({
		url: './backend/silahis_getstudentsnotinstaff.php',
		type: "POST",
		dataType: "json",
		async: true,
		success: function(response)
		{
			//alert(response.data[0].staff_lname);
			for (i = 0; i < response.data.length; i++)
			{
				tableBody += '<tr>';
				tableBody += '<td>' + response.data[i].staff_id + '</td>';
				tableBody += '<td>' + response.data[i].staff_lname + '</td>';
				tableBody += '<td>' + response.data[i].staff_fname + '</td>';
				tableBody += '<td><button type="button" class="btn btn-md btn-primary profile" data-idno="' + response.data[i].staff_id + '">Profile</button></th></td>';
				tableBody += '<tr>';
			}
			$('tbody#students').html(tableBody);
		},
		error: function()
		{
			alert('Something wrong here, mate.');
		}
	});
}

function endStaffTerm()
{
	var staffIDno = $(this).attr('data-staffidno');
	//alert(staffIDno);
	$('div#staffConfirmationQuestion').html('<input type="hidden" id="staffIDhiddenEndTerm" value="' + staffIDno + '" /><p>End this staff member\'s term? This cannot be undone.</p>');
	$('div#staffConfirmationChoices').html('<button type="button" class="btn btn-md btn-danger" id="confirmEndTerm">Yes</button><button type="button" class="btn btn-md btn-default" id="cancelEndTerm">No</button>');
}

function endStaffTermConfirm()
{
	var idno = $('#staffIDhiddenEndTerm').val();
	//alert(idno);
	$.ajax({
		url: './backend/silahis_endStaffTerm.php',
		type: "POST",
		data: {
			idno: idno
		},
		dataType: 'text',
		async: true,
		beforeSend: function() {
			clearConfirmArea();
			$('p#staffProfileArea').html('Processing...');
		},
		success: function(response) {
			//alert(response);
			if (response == "AUSTRALIA")
			{
				clearConfirmArea();
				$('p#staffProfileArea').html('Please select a staff member from the table on the left');
				$('#curstaffs').dataTable().fnDraw();
			}
		},
		error: function() {
			alert('Sum Ting Wong');
		}
	});
}

function getPositionListOptions(jsonResponse)
{
	var optionsList = '';
	for (var i = 0; i < jsonResponse.length; i++) 
	{
		optionsList += '<option value="' + jsonResponse[i].position_id + '">' + jsonResponse[i].position_name + '</option>';
	}
	return optionsList;
}

function showExtendDiffPos()
{
	// Extends the term of the staff member, but has a different position.
	var staffIDno = $(this).attr('data-staffidno');
	var inlineText = '';
	//alert(staffIDno);
	$.ajax({
		url: './backend/silahis_getAllPositions.php',
		type: "POST",
		dataType: "json",
		async: true,
		success: function(response) {
			inlineText += '<input type="hidden" id="staffIDhiddenExtendTerm" value="' + staffIDno + '" /><p>Select the staff\'s new position below:</p>';
			inlineText += '<select class="form-control" name="positionlistextendterm" id="positionlistextendterm">';
	//		for (var i = 0; i < response.length; i++) 
	//		{
	//			inlineText += '<option value="' + response[i].position_id + '">' + response[i].position_name + '</option>';
	//		}
			inlineText += getPositionListOptions(response);
			inlineText += '</select>';

			$('div#staffConfirmationChoices').html('<button type="button" class="btn btn-sm btn-primary" id="confirmExtendTerm">Confirm New Position</button><button type="button" class="btn btn-sm btn-default" id="cancelEndTerm">Cancel</button>');
			$('div#staffConfirmationQuestion').html(inlineText);
		},
		error: function() {
			$('div#staffConfirmationQuestion').html('Sum Ting Wong');
		}
	});
}

function confirmNewPosition()
{
	var idno = $('#staffIDhiddenExtendTerm').val();
	var positionID = $('select#positionlistextendterm').val();
	//alert(idno + ' applying for position ' + positionID);
	$.ajax({
		url: './backend/silahis_newStaffPositionCurrent.php',
		type: "POST",
		data: {
			idno: idno,
			position_id: positionID
		},
		dataType: "text",
		async: true,
		beforeSend: function() {
			clearConfirmArea();
			$('p#staffProfileArea').html('Processing...');
		},
		success: function(response) {
			//alert(response);
			if (response == "AUSTRALIA")
			{	
				clearConfirmArea();
				$('p#staffProfileArea').html('Please select a staff member from the table on the left');
				$('#curstaffs').dataTable().fnDraw();
			}
		},
		error: function()
		{
			alert('Sum Ting Wong');
		}
	});
}

function showRestoreStaff()
{
	var staffIDno = $(this).attr('data-staffidno');
	var inlineText = '';
	$.ajax({
		url: './backend/silahis_getAllPositions.php',
		type: "POST",
		dataType: "json",
		async: true,
		success: function(response) {
			inlineText += '<input type="hidden" id="staffIDhiddenRestoreStaff" value="' + staffIDno + '" />';
			inlineText += '<p>Select a position:</p>';
			inlineText += '<select class="form-control" name="posRestoreStaff" id="posRestoreStaff">';
			inlineText += getPositionListOptions(response);
			inlineText += '</select><br />';
			$('div#staffConfirmationQuestion').html(inlineText);
			$('div#staffConfirmationChoices').html('<button type="button" class="btn btn-md btn-success" id="confirmRestoreStaff">Add New Position</button><button type="button" class="btn btn-md btn-default" id="cancelEndTerm">Cancel</button>');
		},
		error: function() {
			$('div#staffConfirmationQuestion').html('Sum Ting Wong');
		}
	});
}

function confirmRestoreStaff()
{
	var idno = $('#staffIDhiddenRestoreStaff').val();
	var positionID = $('select#posRestoreStaff').val();
	//alert(idno + ' applying for position with ID ' + positionID);
	$.ajax({
		url: './backend/silahis_newStaffPosition.php',
		type: "POST",
		data: {
			idno: idno,
			position_id: positionID
		},
		dataType: "text",
		async: true,
		beforeSend: function() {
			clearConfirmArea();
			$('p#staffProfileArea').html('Processing...');
		},
		success: function (response) {
			if (response == "AUSTRALIA")
			{	
				clearConfirmArea();
				$('p#staffProfileArea').html('Please select a staff member from the table on the left');
				$('#curstaffs').dataTable().fnDraw();
			}
		},
		error: function() {
			$('div#staffConfirmationQuestion').html('Sum Ting Wong');
		}
	});
}