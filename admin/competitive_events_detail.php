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
            <h1 class="h3 mb-4 text-gray-800">Competitive Events Details</h1>
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Competitive Events Details Table</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Sr. Number</th>
                                    <th>Event Name</th>
                                    <th>Event Description</th>
                                    <th>Event Date</th>
                                    <th>Event Time</th>
                                    <th>Event Venue</th>
                                    <th>Event Organizer Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Sr. Number</th>
                                    <th>Event Name</th>
                                    <th>Event Description</th>
                                    <th>Event Date</th>
                                    <th>Event Time</th>
                                    <th>Event Venue</th>
                                    <th>Event Organizer Name</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php
                                include './includes/connection.php';

                                $query = "SELECT events.*, CONCAT(users.first_name, ' ', users.last_name) AS organizer_name
                                            FROM events 
                                            LEFT JOIN users ON events.organizer_id = users.user_id 
                                            WHERE events.event_type = 'Competitive' 
                                            ORDER BY events.event_id DESC";
                                $result = mysqli_query($conn, $query);

                                if (mysqli_num_rows($result) > 0) {
                                    $count = 1;
                                    while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                        <!-- display table content start -->
                                        <tr>
                                            <td class='text-center align-middle'><?php echo $count; ?></td>
                                            <td class='text-center align-middle'><?php echo $row['event_name']; ?></td>
                                            <td class='text-center align-middle'><?php echo $row['event_description']; ?></td>
                                            <!-- Format the date in dd/mm/yyyy format -->
                                            <?php $date = date_create($row['event_date']); ?>
                                            <td class='text-center align-middle'><?php echo date_format($date, 'd/m/Y'); ?></td>
                                            <td class='text-center align-middle'><?php echo $row['event_time']; ?></td>
                                            <td class='text-center align-middle'><?php echo $row['venue']; ?></td>
                                            <td class='text-center align-middle'><?php echo $row['organizer_name']; ?></td>

                                            <td class='text-center align-middle'>
                                                <!-- update -->
                                                <form id='updateForm' method='POST'>
                                                    <input type='hidden' id='event_id_update' name='event_id_update' value="<?php echo $row['id']; ?>">
                                                    <button class='btn btn-primary m-2 update-btn' id='update-btn-<?php echo $row['id']; ?>' name='update_submit' data-update-id='<?php echo $row['id']; ?>'>Update</button>
                                                </form>

                                                <!-- delete -->
                                                <form id='deleteForm' method='POST'>
                                                    <input type='hidden' id='event_id_delete' name='event_id_delete' value="<?php echo $row['id']; ?>">
                                                    <button class='btn btn-danger delete-btn' id='delete-btn-<?php echo $row['id']; ?>' data-delete-id='<?php echo $row['id']; ?>' name='delete_submit'>Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                        <!-- display table content end -->

                                <?php
                                        $count++;
                                    }
                                } else {
                                    echo "<tr><td colspan='8'>No records found</td></tr>";
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