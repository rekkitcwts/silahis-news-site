	
    <script src="js/bootstrap.js"></script>
	<!-- Start ADMINLTE dependencies here -->
	<!-- jQuery UI 1.10.3 -->
        <script src="js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
        <script src="js/plugins/datatables/1.9.4/jquery.dataTables.js" type="text/javascript"></script>
        <script src="js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
		<script src="js/AdminLTE/app.js" type="text/javascript"></script>
	<!-- End ADMINLTE dependencies here -->
	<script>
	$(
		function()
		{
    		$("#writersdesk").dataTable();
    		$("#tbedited").dataTable();
    		$("#students").dataTable({
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "backend/silahis_getstudentsnotinstaff.php",
        "aoColumns": [
            { "mData": "staff_id" },
            { "mData": "staff_fname" },
            { "mData": "staff_lname" },
            {
            	"mData": "staff_id2",
            	"mRender": function ( data, type, full ) {
        			return '<button type="button" class="btn btn-md btn-primary profile" data-idno="' + data + '">View Profile</button>';
      			}
            }
        ]
    });
            $("#curstaffs").dataTable({
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "backend/silahis_getstudentsinstaff.php",
        "aoColumns": [
            { "mData": "staff_id" },
            { "mData": "staff_fname" },
            { "mData": "staff_lname" },
            {
                "mData": "staff_id2",
                "mRender": function ( data, type, full ) {
                    return '<button type="button" class="btn btn-md btn-primary staffprofile" data-staffidno="' + data + '">View Staff Profile</button>';
                }
            }
        ]
    });
    	}
    	);
	</script>
	<script src="js/docready.js"></script>
	<script src="js/functions.js"></script>
	</body>
</html>