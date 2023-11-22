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
            <h1 class="h3 mb-4 text-gray-800">Event Participants Details</h1>
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Event Participants Details</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Sr. Number</th>
                                    <th>Event Name</th>
                                    <th>Participants</th>
                                    <th>Participant Count</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Sr. Number</th>
                                    <th>Event Name</th>
                                    <th>Participants</th>
                                    <th>Participant Count</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php
                                include './includes/connection.php';

                                // Fetch event and participant details from the database
                                $query = "SELECT events.event_id, events.event_name, 
                                GROUP_CONCAT(participants.participant_email SEPARATOR ', ') AS participant_emails,
                                COUNT(participants.id) AS participant_count
                                FROM events
                                LEFT JOIN participants ON events.event_id = participants.event_id
                                GROUP BY events.event_id";

                                $result = mysqli_query($conn, $query);

                                if ($result && mysqli_num_rows($result) > 0) {
                                    $srNumber = 1;
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<td class='text-center align-middle'>" . $srNumber . '</td>';
                                        echo "<td class='text-center align-middle'>" . $row['event_name'] . '</td>';
                                        echo "<td class='text-center align-middle'>" . $row['participant_emails'] . '</td>';
                                        echo "<td class='text-center align-middle'>" . $row['participant_count'] . '</td>';
                                        echo "</tr>";
                                        $srNumber++;
                                    }
                                } else {
                                    echo '<tr><td colspan="4">No events with participants found.</td></tr>';
                                }
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