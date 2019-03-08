<?php include '.\..\header.php';
$user = require_login();
$sessions = WorkSessionDao::get_instance()->select();
?>

<div class="card-background">
    <h1>Hello from ag-grid!</h1>

    <div id="myGrid" style="height: 100%;" class="ag-theme-balham"></div>
    
    <script type="text/javascript" charset="utf-8">
        // specify the columns
        var columnDefs = [
            {headerName: "Student ID", field: "studentID", width: 100, sortable: true, filter: true, cellEditor: 'agRichSelectCellEditor'},
            {headerName: "Student", field: "studentName", width: 200, sortable: true, filter: true, cellEditor: 'agRichSelectCellEditor'},
            {headerName: "Start date", field: "startDate", width: 100, sortable: true, filter: true, cellEditor: 'agRichSelectCellEditor'},
            {headerName: "End date", field: "endDate", width: 100, sortable: true, filter: true, cellEditor: 'agRichSelectCellEditor'},
            {headerName: "Company name", field: "companyName", width: 200, sortable: true, filter: true, cellEditor: 'agRichSelectCellEditor'},
            {headerName: "Job title", field: "jobTitle", width: 100, sortable: true, filter: true, cellEditor: 'agRichSelectCellEditor'},
            {headerName: "Hours", field: "hours", width: 80, sortable: true, filter: true, cellEditor: 'agRichSelectCellEditor'},
            {headerName: "", field: "view", width: 50, cellEditor: 'agRichSelectCellEditor', 
                cellRenderer: function(params) {
                    $test = "Help"
                return '<a href="student/session.php?sid='+params.value+'">View</a>'
                }
            },
            {headerName: "Approval", field: 'approve', width: 100, sortable: true, filter: true},
        ];
    
        // specify the data
        
        var rowData = [
            <?php 
                if ($sessions): foreach ($sessions as $session):
                $employer = EmployerDao::get_instance()->select($session->employer_id)[0];
                $student = UserDao::get_instance()->select($session->student_id)[0];
            ?>
            {studentID: "<?php echo $session->student_id; ?>", 
            studentName: "<?php echo $student->first_name . ' ' . $student->last_name; ?>", 
            startDate: "<?php echo $session->start_date; ?>", 
            endDate: "<?php echo $session->end_date; ?>", 
            companyName: "<?php echo $employer->name; ?>", 
            jobTitle: "<?php echo $session->job_title; ?>", 
            hours: "<?php echo $session->total_hours; ?>", 
            //<php echo "<a href='student/session.php?sid=".$session->id."'>Index Page</a>"; ?>
            //document.getElementById("148").innerHTML = 'View'.link('student/session.php?sid=31')
            view: "<?php echo $session->id; ?>",
            approve: "<?php if ($session->approved === 1){echo("Yes");} else {echo("");}?>",

            },
            <?php endforeach; endif; ?>
        ];
        
    
        // let the grid know which columns and what data to use
        var gridOptions = {
            columnDefs: columnDefs,
            rowData: rowData,
            defaultColDef: {
                editable: true,
                resizable: true
            },
            onCellValueChanged: onCellValueChanged
        };

        //Detects when any value is changed
        function onCellValueChanged(params) {
            alert("Change");
        }

        // setup the grid after the page has finished loading
        document.addEventListener('DOMContentLoaded', function () {
            var gridDiv = document.querySelector('#myGrid');
            new agGrid.Grid(gridDiv, gridOptions);
        });
    </script>

<script>
    function approveSession(id) {
        $api.call("supervisor/form-approve", {sessionId: id}, response => {
            if (response.success) {
                location.reload();
            }
        });
    }
</script>

<?php include '.\..\footer.php'; ?>
