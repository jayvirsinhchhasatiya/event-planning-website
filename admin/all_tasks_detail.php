<?php

session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
}

include './includes/header.php';
include './includes/sidebar.php';


?>

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- topbar -->
        <?php
        include './includes/topbar.php';
        ?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-4 text-gray-800">Event Tasks Details</h1>
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Event Tasks Details</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Sr. Number</th>
                                    <th>Event Name</th>
                                    <th>Event Date</th>
                                    <th>Event Venue</th>
                                    <th>Event Organizer Name</th>
                                    <th>Task</th>
                                    <th>Assignees</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Sr. Number</th>
                                    <th>Event Name</th>
                                    <th>Event Date</th>
                                    <th>Event Venue</th>
                                    <th>Event Organizer Name</th>
                                    <th>Task</th>
                                    <th>Assignees</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php
                                include './includes/connection.php';

                                $query = "SELECT events.*, CONCAT(users.first_name, ' ', users.last_name) AS organizer_name
                                            FROM events 
                                            LEFT JOIN users ON events.organizer_id = users.user_id 
                                            ORDER BY events.event_id DESC";
                                $result = mysqli_query($conn, $query);

                                if (mysqli_num_rows($result) > 0) {
                                    $count = 1;
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        // Fetch tasks for the event
                                        $tasksQuery = "SELECT * FROM tasks WHERE event_id = {$row['event_id']}";
                                        $tasksResult = mysqli_query($conn, $tasksQuery);

                                        // Display event details in a row
                                        while ($task = mysqli_fetch_assoc($tasksResult)) {
                                            // Fetch assignees for each task
                                            $assigneesQuery = "SELECT assignee_email FROM assignees WHERE task_id = {$task['task_id']}";
                                            $assigneesResult = mysqli_query($conn, $assigneesQuery);
                                            $assignees = mysqli_fetch_all($assigneesResult);

                                            echo "<tr>";
                                            echo "<td class='text-center align-middle'>{$count}</td>";
                                            echo "<td class='text-center align-middle'>{$row['event_name']}</td>";
                                            echo "<td class='text-center align-middle'>" . date_format(date_create($row['event_date']), 'd/m/Y') . "</td>";
                                            echo "<td class='text-center align-middle'>{$row['venue']}</td>";
                                            echo "<td class='text-center align-middle'>{$row['organizer_name']}</td>";
                                            echo "<td class='text-center align-middle'>{$task['task_description']}</td>";
                                            echo "<td class='text-center align-middle'>" . implode(', ', array_column($assignees, 0)) . "</td>";
                                            echo "</tr>";
                                            $count++;
                                        }
                                    }
                                } else {
                                    echo "<tr><td colspan='7'>No records found</td></tr>";
                                }
                                mysqli_close($conn);
                                ?>
                            </tbody>
                        </table>


                    </div>
                </div>
            </div>

        </div>
        <!-- /.container-fluid end page content -->

    </div>
    <!-- End of Main Content -->

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>


    <?php

    // include './includes/script.php';
    include './includes/footer.php';


    ?>