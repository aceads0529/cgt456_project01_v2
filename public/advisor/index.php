<?php include '../site.php';
site_header('', CGT_PAGE_DEFAULT);

$user = require_login();
$sessions = WorkSessionDao::get_instance()->select();
?>

<div class="card-background">
    <h2>Student Work Sessions</h2>

    <input id="name-search" type="text"/>

    <div id="myGrid" style="height: 100%;" class="ag-theme-balham"></div>

    <script type="text/javascript" charset="utf-8">
        function initializeAgGrid() {
            const colDefs = [
                {hide: true, headerName: "Full name", field: "fullName", filter: true},
                {headerName: "First name", field: "firstName", width: 200, sortable: true, filter: true},
                {headerName: "Last name", field: "lastName", width: 200, sortable: true, filter: true},
                {headerName: "Job title", field: "jobTitle", width: 168, sortable: true, filter: true},
                {headerName: "Start date", field: "startDate", width: 100, sortable: true, filter: true},
                {headerName: "End date", field: "endDate", width: 100, sortable: true, filter: true},
                {headerName: "Employer", field: "employer", width: 200, sortable: true, filter: true},
                {headerName: "Total hours", field: "totalHours", width: 80, sortable: true, filter: true},
                {
                    headerName: "", field: "session", width: 50,
                    cellRenderer: params => {
                        return `<a target="_blank" href="student/session.php?sid=${params.value.id}">[View]</a>`;
                    }
                },
                {
                    headerName: "Status", field: "session", width: 100, sortable: true,
                    cellRenderer: params => {
                        const session = params.value;
                        if (session.approved) {
                            return `<span style="color: #c28e0e">Approved</span>`;
                        } else {
                            return `<a style="text-decoration: underline" onclick="approveSession(${session.id})">[Approve]</a>`;
                        }
                    }
                }
            ];

            const gridOptions = {
                columnDefs: colDefs,
                defaultColDef: {
                    resizable: true
                }
            };

            new agGrid.Grid(document.getElementById('myGrid'), gridOptions);
            return gridOptions;
        }

        function approveSession(id) {
            $api.call("supervisor/form-approve", {sessionId: id}, response => {
                if (response.success) {
                    location.reload();
                }
            });
        }

        function debounce(func, wait, immediate) {
            var timeout;
            return function () {
                var context = this, args = arguments;
                var later = function () {
                    timeout = null;
                    if (!immediate) func.apply(context, args);
                };
                var callNow = immediate && !timeout;
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
                if (callNow) func.apply(context, args);
            };
        }

        const options = initializeAgGrid();
        const nameFilter = options.api.getFilterInstance('fullName');

        $api.call("data/sessions", {}, (response) => {
            options.api.setRowData(response.data);
            options.api.sizeColumnsToFit();
        });

        $("#name-search").keydown(debounce(() => {
            console.log($("#name-search").val());

            nameFilter.setModel({
                type: "contains",
                filter: $("#name-search").val()
            });
            nameFilter.onFilterChanged();
        }, 250));

    </script>

    <?php include '.\..\footer.php'; ?>
