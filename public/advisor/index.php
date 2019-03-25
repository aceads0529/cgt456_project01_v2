<?php include '../site.php';
site_header('', CGT_PAGE_DEFAULT);

$user = auth_allow(CGT_USER_ADVISOR);
$sessions = WorkSessionDao::get_instance()->select();
?>

<div class="card-background">
    <h2>Student Work Sessions</h2>

    <div class="label-input">
        <label for="name-search">Search by name</label>
        <input id="name-search" type="text"/>
    </div>

    <div id="session-table" style="height: 100%;" class="ag-theme-balham"></div>

    <script type="text/javascript" charset="utf-8">
        function initializeAgGrid() {
            const column = (props) => Object.assign({
                width: 100,
                sortable: true,
                filter: true,
                autoHeight: true
            }, props);

            const colDefs = [
                column({headerName: "Full name", field: "fullName", hide: true}),
                column({headerName: "First name", field: "firstName"}),
                column({headerName: "Last name", field: "lastName"}),
                column({headerName: "Employer", field: "employer"}),
                column({headerName: "Job title", field: "jobTitle"}),
                column({headerName: "Start date", field: "startDate"}),
                column({headerName: "End date", field: "endDate"}),
                column({
                    headerName: "Hours",
                    field: "hours",
                    width: 50,
                    cellRenderer: params => {
                        return `<div class="table-hour-wrapper"><span class="table-hour"/>${params.value}</span> <span class="table-hour-total">/ ${params.data.totalHours}</span></div>`;
                    }
                }),
                column({
                    headerName: "Status",
                    field: "session",
                    cellRenderer: params => {
                        const session = params.value;
                        if (session.approved) {
                            return `<span style="color: #c28e0e">Approved</span>`;
                        } else {
                            return `<a style="text-decoration: underline" onclick="approveSession(${session.id})">[Approve]</a>`;
                        }
                    },
                    comparator: (a, b) => {
                        return a.approved - b.approved;
                    }
                })
            ];

            const gridOptions = {
                columnDefs: colDefs,
                defaultColDef: {
                    resizable: true
                },
                onGridSizeChanged: (event) => {
                    event.api.sizeColumnsToFit();
                }
            };

            new agGrid.Grid(document.getElementById('session-table'), gridOptions);
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
