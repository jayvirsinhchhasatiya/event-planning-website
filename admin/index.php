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
                <div class="col-xl-3 col-md-6 mb-4">
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
                <div class="col-xl-3 col-md-6 mb-4">
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
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Participants
                                    </div>
                                    <?php
                                    $query = "SELECT COUNT(*) AS total_participants FROM users WHERE user_type = 'participant'";
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

                <!-- guest Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Total Guests</div>
                                    <?php
                                    $query = "SELECT COUNT(*) AS total_guests FROM guests";
                                    $result = mysqli_query($conn, $query);

                                    if ($result) {
                                        $row = mysqli_fetch_assoc($result);
                                        $totalguests = $row['total_guests'];
                                        echo "<div class='h5 mb-0 font-weight-bold text-gray-800'>$totalguests</div>";
                                    } else {
                                        echo "Error: " . mysqli_error($conn);
                                    }
                                    ?>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-comments fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Registration Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Organizers Details</h1>
                <a href="#" class="btn btn-primary btn-icon-split" data-toggle="modal" data-target="#addOrganizerModal">
                    <span class="icon text-white-50">
                        <i class="fa-solid fa-user"></i>
                    </span>
                    <span class="text">Add New Organizer</span>
                </a>
            </div>

            <!-- Add new organizer Modal -->
            <div class="modal fade" id="addOrganizerModal" tabindex="-1" role="dialog" aria-labelledby="addOrganizerModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addOrganizerModalLabel">Add New Organizer</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="organizerForm" action="add_organizer.php" method="POST">
                                <!-- first name -->
                                <div class="md-3">
                                    <label for="firstname" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Enter First Name" required>
                                    <div id="firstname-valid" class="">
                                    </div>
                                </div>

                                <!-- last name -->
                                <div class="md-3">
                                    <label for="lastname" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Enter Last Name" required>
                                    <div id="lastname-valid" class="">
                                    </div>
                                </div>

                                <!-- user name -->
                                <div class="md-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username" required>
                                    <div id="username-valid" class="">
                                    </div>
                                </div>

                                <!-- email -->
                                <div class="md-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" required>
                                    <div id="email-valid" class="">
                                    </div>
                                </div>

                                <!-- password -->
                                <div class="md-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required>
                                    <div id="password-valid" class="">
                                    </div>
                                </div>

                                <!-- confirm password -->
                                <div class="md-3">
                                    <label for="cpassword" class="form-label">Confirm Password</small></label>
                                    <input type="password" class="form-control " id="cpassword" name="cpassword" placeholder="Confirm Password" required>
                                    <div id="cpassword-valid" class="">

                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" id="submitBtn">Add</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Update Equipment Modal -->
            <div class="modal fade" id="updateEquipmentModal" tabindex="-1" role="dialog" aria-labelledby="updateEquipmentModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="updateEquipmentModalLabel">Update Equipment</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="equipmentUpdateForm" action="update_equipment.php" method="POST" enctype="multipart/form-data">
                                <input type="hidden" id="equipment-id" name="equipment-id" value="">
                                <div class="mb-3">
                                    <label for="nameupdate" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="nameupdate" name="nameupdate" required>
                                </div>
                                <div class="mb-3">
                                    <label for="descriptionupdate" class="form-label">Description (Max 15 words)</label>
                                    <textarea class="form-control" id="descriptionupdate" name="descriptionupdate" rows="3" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="previousimg" class="form-label">Previous Image</label>
                                    <img src='' alt='image' id="previousimg" height='100px' weight='100px'>
                                </div>
                                <div class="mb-3">
                                    <label for="imageupdate" class="form-label">Image (Max file size: 5MB)</label>
                                    <input type="file" class="form-control" id="imageupdate" name="imageupdate" accept="image/*">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" id="update-button" name="update-button">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
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