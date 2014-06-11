$(
function()
{
	$('#staffLogin').click(loginCheck);
    $('#btnConfirmRemoveArticle').click(removeArticle);
	$('#students').on('click', 'button.profile',showStudentProfile);
	$('#curstaffs').on('click', 'button.staffprofile', showStaffProfile);
	$('#staffProfileArea').on('click', 'button.staffterm', endStaffTerm);
	$('div#staffConfirmationChoices').on('click', 'button#confirmEndTerm', endStaffTermConfirm);
	$('#staffProfileArea').on('click', 'button.extendterm', showExtendDiffPos);
	$('#addtoBoard').click(addStudentToEditorialBoard);
	$('div#staffConfirmationChoices').on('click', 'button#confirmExtendTerm', confirmNewPosition);
	$('div#staffConfirmationChoices').on('click', 'button#cancelEndTerm', function () {
		clearConfirmArea();
	});
	$('#staffProfileArea').on('click', 'button.readdstaff', showRestoreStaff);
	$('div#staffConfirmationChoices').on('click', 'button#confirmRestoreStaff', confirmRestoreStaff);
}
);