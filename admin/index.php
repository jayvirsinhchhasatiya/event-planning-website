<?php

session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
}

include './includes/connection.php';

include './includes/header.php';
include './includes/sidebar.php';

?>



<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <?php

        include './includes/topbar.php';
        ?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
            </div>

            <!-- Content Row -->
            <div class="row">
                <!-- all events Card Example -->
                <div class="col-xl-4 col-md-4 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Events</div>
                                    <?php
                                    $query = "SELECT COUNT(*) AS total_events FROM events";
                                    $result = mysqli_query($conn, $query);

                                    if ($result) {
                                        $row = mysqli_fetch_assoc($result);
                                        $totalevents = $row['total_events'];
                                        echo "<div class='h5 mb-0 font-weight-bold text-gray-800'>$totalevents</div>";
                                    } else {
                                        echo "Error: " . mysqli_error($conn);
                                    }
                                    ?>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- all organizers Card Example -->
                <div class="col-xl-4 col-md-4 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Total Organizers</div>
                                    <?php
                                    $query = "SELECT COUNT(*) AS total_organizers FROM users WHERE user_type = 'organizer'";
                                    $result = mysqli_query($conn, $query);

                                    if ($result) {
                                        $row = mysqli_fetch_assoc($result);
                                        $totalOrganizers = $row['total_organizers'];
                                        echo "<div class='h5 mb-0 font-weight-bold text-gray-800'>$totalOrganizers</div>";
                                    } else {
                                        echo "Error: " . mysqli_error($conn);
                                    }
                                    ?>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- total participants Card Example -->
                <div class="col-xl-4 col-md-4 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Participants
                                    </div>
                                    <?php
                                    $query = "SELECT COUNT(*) AS total_participants FROM participants";
                                    $result = mysqli_query($conn, $query);

                                    if ($result) {
                                        $row = mysqli_fetch_assoc($result);
                                        $totalparticipants = $row['total_participants'];
                                        echo "<div class='h5 mb-0 mr-3 font-weight-bold text-gray-800'>$totalparticipants</div>";
                                    } else {
                                        echo "Error: " . mysqli_error($conn);
                                    }
                                    ?>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Registration Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Organizers Details</h1>
            </div>


            <!-- customer registration -->
            <div class="row">
                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Organizers Details Table</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Number</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Number</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php

                                    $query = "SELECT first_name, last_name, email FROM users WHERE user_type = 'organizer' ORDER BY `user_id` DESC";
                                    $result = mysqli_query($conn, $query);

                                    if (mysqli_num_rows($result) > 0) {
                                        $count = 1;
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<tr>";
                                            echo "<td class='text-center align-middle'>" . $count . "</td>"; // Display the count
                                            echo "<td class='text-center align-middle'>" . $row['first_name'] . "</td>";
                                            echo "<td class='text-center align-middle'>" . $row['last_name'] . "</td>";
                                            echo "<td class='text-center align-middle'>" . $row['email'] . "</td>";
                                            $count++;
                                        }
                                    } else {
                                        echo "<tr><td colspan='12'>No records found</td></tr>";
                                    }
                                    mysqli_close($conn);
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

            <!-- chart Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Charts</h1>
            </div>
            <!-- /. customer registration -->

            <!--  charts -->
            <div class="row">

                <div class="col-xl-12 col-lg-12">
                    <!-- example Chart -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Events Count Chart</h6>
                        </div>
                        <div class="card-body">
                            <div class="chart-area">
                                <canvas id="eventCountChart"></canvas>
                            </div>
                            <hr>
                            Number of Events per month.
                        </div>
                    </div>
                </div>
                <!-- Donut Chart -->
                <div class="col-xl-12 col-lg-12">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Event Type Chart</h6>
                        </div>
                        <!-- Card Body -->
                        <div class="card-body">
                            <div class="chart-pie pt-4">
                                <canvas id="eventTypeChart"></canvas>
                            </div>
                            <hr>
                            Competitive & Non-Competitive Events
                        </div>
                    </div>
                </div>

            </div>


            <!-- /.charts -->


        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

    <!-- Bootstrap core JavaScript-->

    <!-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script> -->

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

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/organizer-form-validation.js"></script>
    <script src="js/demo/chart-event-count.js"></script>
    <script src="js/demo/chart-event-type.js"></script>
    <?php

    // include './includes/script.php';
    include './includes/footer.php';

    ?>